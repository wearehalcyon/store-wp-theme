<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package INTAKE_DIgital
 * Template name: Messages
 */

get_header();

?>
<main id="main" class="main site-main">

	<?php
	while (have_posts()) :
		the_post();

		if ( is_user_logged_in() ) {
			get_template_part('template-parts/content', 'messages');
		} else {
			echo '<h1>Error 404. Page not found. Try again or sign in to continue.</h1>';
		}

	endwhile; // End of the loop.
	?>

</main><!-- #main -->
<?php
get_footer();