<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package INTAKE_DIgital
 */

get_header();
?>
	<div class="pjax-container">
		<main id="main" class="main site-main pjax-container">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div>
<?php
get_footer();
