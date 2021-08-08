<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package INTAKE_DIgital
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Page can’t be found.', 'intake-digital' ); ?></h1>
			</header><!-- .page-header -->

			<p><?php _e( 'Use search or back to <a href="' . home_url('/') . '">home</a>.', 'intake-digital' ); ?></p>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
