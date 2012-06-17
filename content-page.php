<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Toolbox
 * @since Toolbox 1.0
 */
?>

<article class="static-page">
	<header class="assistive-text section-heading"><h1><?php the_title(); ?></h1></header>

	<div class="content cf">
        <?php
            // renders a picture on the right column
            $picture = types_render_field("picture-right-column", array());
            if (!empty($picture)) : ?>

        <div class="fr like-five-columns right-column-pic">
            <?php
                $picture = preg_replace('/alt="\S*"/', '', $picture);
                $picture = preg_replace('/title="\S*"/', '', $picture);
                echo $picture;
            ?>
        </div>
        <?php endif; ?>

        <div class="ten columns alpha">
          <?php the_content(); ?>
          <?php wp_link_pages( array( 'before' => '<div class="link">' . __( 'Pages:', 'toolbox' ), 'after' => '</div>' ) ); ?>
        </div>

    </div>

</article>
