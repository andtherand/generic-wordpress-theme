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

	<div class="content-body group">

          <?php the_content(); ?>
          <?php wp_link_pages( array( 'before' => '<div class="link">' . __( 'Pages:', 'toolbox' ), 'after' => '</div>' ) ); ?>

    </div>

</article>
