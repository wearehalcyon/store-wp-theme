<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package INTAKE_DIgital
 */

get_header();

global $product, $post;
?>

	<main id="main" class="main site-main">
				<?php if ( have_posts() ) : ?>
					<div class="fresh_releases">
						<header class="page-header">
							<h1 class="page-title">
								<?php
								/* translators: %s: search query. */
								printf( esc_html__( 'Search Results for: %s', 'intake-digital' ), '<span>' . get_search_query() . '</span>' );
								?>
							</h1>
						</header><!-- .page-header -->
						<ul class="products products-list fresh_releases_list">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					the_posts_navigation();
				?>
						</ul>
					</div>
				<?php

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
				?>

	</main><!-- #main -->

<?php
get_footer();
