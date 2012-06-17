<?php
/**
 * @package WordPress
 * @subpackage Toolbox
 */
?>

<article class="single-article">
	<header>
		<h1><?php toolbox_posted_on(); ?>: <?php the_title(); ?></h1>
	</header>

	<div class="content">
		<?php the_content(); ?>
	</div>

	<footer>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'toolbox' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );
			
			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
	</footer>
</article>
