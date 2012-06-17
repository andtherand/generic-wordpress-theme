<?php
/**
 * @package WordPress
 * @subpackage Toolbox
 */
?>

<article class="multiple-articles cf">
	<?php 
	$thumb = get_field('post_pic');
		if (!empty($thumb)): ?>
	<div class="thumbnail">
		<img src="<?php echo $thumb; ?>">
	</div>
	<?php endif; ?>
	<div class="news">
		<header>
			<h1><?php toolbox_posted_on(); ?>: <?php the_title(); ?></h1>
		</header>
	
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="summary">
			<?php the_excerpt(); ?>
		</div>
		
		<?php else : ?>
			
		<div class="content">
			<?php the_content( __( 'Continue reading <span class="nav">&rarr;</span>', 'toolbox' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="link">' . __( 'Pages:', 'toolbox' ), 'after' => '</div>' ) ); ?>
		</div>
		<?php endif; ?>
	
		<footer>
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'toolbox' ) );
					if ( $categories_list && toolbox_categorized_blog() ) :
				?>
				<span class="categories">
					<?php printf( __( 'Posted in %1$s', 'toolbox' ), $categories_list ); ?>
				</span>
				<span class="sep"> | </span>
				<?php endif; // End if categories ?>
	
				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'toolbox' ) );
					if ( $tags_list ) :
				?>
				<span class="tags">
					<?php printf( __( 'Tagged %1$s', 'toolbox' ), $tags_list ); ?>
				</span>
				<span class="sep"> | </span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>
	
			
		</footer>
	</div>
</article>
