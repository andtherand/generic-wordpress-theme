<?php
/**
 * Toolbox functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Toolbox
 * @since Toolbox 0.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'toolbox_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override toolbox_setup() in a child theme, add your own toolbox_setup to your child theme's
 * functions.php file.
 */
function toolbox_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on toolbox, use a find and replace
	 * to change 'toolbox' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'toolbox', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	//add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'toolbox' ),
		'secondary' => __( 'Secondary Menu', 'toolbox'),
		'footer' => __( 'Footer Menu', 'toolbox' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	// add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
	add_theme_support( 'post-thumbnails',  array( 'post', 'page', 'player' ) );
	add_image_size('featured', 400, 340, true);
	add_image_size('post-thumb', 100, 140, true);
}
endif; // toolbox_setup

/**
 * Tell WordPress to run toolbox_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'toolbox_setup' );

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);


/**
 * Register widgetized area and update sidebar with default widgets
 */
function toolbox_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'toolbox' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'toolbox_widgets_init' );

if ( ! function_exists( 'toolbox_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Toolbox 1.2
 */
function toolbox_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'toolbox' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'toolbox' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'toolbox' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'toolbox' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'toolbox' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // toolbox_content_nav


if ( ! function_exists( 'toolbox_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own toolbox_posted_on to override in a child theme
 *
 * @since Toolbox 1.2
 */
function toolbox_posted_on() {
	printf( __(
		'<time class="date" datetime="%1$s" pubdate>%2$s</time>', 'toolbox' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )

	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Toolbox 1.2
 */
function toolbox_body_classes( $classes ) {
	global $post;

	$classes = array();

	if (is_front_page()) {
		$classes[] = 'frontpage';
	}

	$post_name = $post->post_name;
	$classes[] = $post_name;

	return $classes;
}
add_filter( 'body_class', 'toolbox_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Toolbox 1.2
 */
function toolbox_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so toolbox_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so toolbox_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in toolbox_categorized_blog
 *
 * @since Toolbox 1.2
 */
function toolbox_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'toolbox_category_transient_flusher' );
add_action( 'save_post', 'toolbox_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function toolbox_enhanced_image_navigation( $url ) {
	global $post;

	if ( wp_attachment_is_image( $post->ID ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'toolbox_enhanced_image_navigation' );

//------------------------------------------------------------------------------
// - ADDITION
//

function toolbox_remove_menu_entries () {
	remove_menu_page( 'edit-comments.php' );
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );

}
add_action( 'admin_menu', 'toolbox_remove_menu_entries' );

// removes unnecessary wlw meta tag
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'feed_links_extra', 3); // Removes the links to the extra feeds
remove_action('wp_head', 'feed_links', 2); // Removes links to the general feeds


function disable_our_feeds() {
    wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

add_action('do_feed', 'disable_our_feeds', 1);
add_action('do_feed_rdf', 'disable_our_feeds', 1);
add_action('do_feed_rss', 'disable_our_feeds', 1);
add_action('do_feed_rss2', 'disable_our_feeds', 1);
add_action('do_feed_atom', 'disable_our_feeds', 1);
/**
* Remove recent comments styling
* @link http://webstractions.com/wordpress/remove-recent-comments-inline-styl/
*/
if (!function_exists('toolbox_remove_recent_comments_style')) {
    function toolbox_remove_recent_comments_style()
    {
        global $wp_widget_factory;
        remove_action(
            'wp_head', array(
                $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
                'recent_comments_style'
            )
        );
    }
    add_action('widgets_init', 'toolbox_remove_recent_comments_style');
}


//remove page meta box
function remove_wpcf_marketing_field() {
	$doNotRemove = array('post', 'attachment', 'page', 'revision', 'nav_menu_items');
	$types = get_post_types();
	foreach($types as $type) {

		if (!in_array($type, $doNotRemove)) {
    		remove_meta_box('wpcf-marketing', $type, 'side');
    	}
    }
}
add_action('wpcf_admin_post_init','remove_wpcf_marketing_field');



// function toolbox_footer_add_script()
// {
// 	$js_path = get_template_directory_uri() . '/js/';

// 	wp_register_script('plugins', $js_path . 'plugins.js', array('jquery'), 1, true);
// 	wp_enqueue_script('plugins');
// }

// add_action('wp_enqueue_scripts', 'toolbox_footer_add_script');



//-----------------------------------------------------------------------------
// WALKER CLASS FOR THE MENU

class T5_Nav_Menu_Walker_Simple extends Walker_Nav_Menu
{

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth, $args )
	{
		$output     .= '<li';
		$hrefAttributes  = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		!empty ( $item->attr_title )
			// Avoid redundant titles
			&& $item->attr_title !== $item->title
			&& $hrefAttributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

		!empty ( $item->url )
			&& $hrefAttributes .= ' href="' . esc_attr( $item->url ) .'"';

		$activeClasses = array('current-menu-item', 'current-page-ancestor');
		$liAttribute = '>';

		foreach($activeClasses as $activeClass) {
			if (in_array($activeClass, $classes)) {
        		$liAttribute = ' class="active">';
        		$hrefAttributes .= ' class="active-link"';
        	}
        }

        $output .= $liAttribute;

		$hrefAttributes  = trim( $hrefAttributes );
		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output = sprintf("%s<a %s>%s%s</a>%s%s", $args->before, $hrefAttributes, $args->link_before, $title,  $args->link_after, $args->after);

		$output .= apply_filters(
			'walker_nav_menu_start_el'
			,   $item_output
			,   $item
			,   $depth
			,   $args
		);
	}

	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function start_lvl( &$output )
	{
		$output .= '<ul class="sub-menu">';
	}

	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output )
	{
		$output .= '</ul>';
	}

	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output )
	{
		$output .= '</li>';
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output )
    {
        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

// ---
