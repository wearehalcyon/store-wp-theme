<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;
$WC_Product = new WC_Product();

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single_product_wrap', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="single_product_summary entry-summary">
		<div class="product_card product_details">
			<?php
			$manufacturer = get_field('manufacturer', $post->ID);
			$manufacturer = get_userdata($manufacturer);
			echo '<h1>' . get_the_title() . '</h1>';
			echo '<div class="manufacturer">Manufacturer: <a href="' . get_author_posts_url( $manufacturer->ID ) . '" title="' . $manufacturer->display_name . '">' . $manufacturer->display_name . '</a></div>';
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
			<div class="product_meta_info">
				<div class="product_rating">
					<div class="rating_count">
						<div class="rating_stars">
							<?php
								$ratings_comments = get_comments([
									'post_id' => $post->ID,
									'type' => 'review',
									'status' => 1,
									'number' => 999999
								]);
								$rated_counter = 1;
								foreach ($ratings_comments as $ratings_comment) {
									$rated_count = $rated_counter++;
									$rating_all += $ratings_comment->rating;
									$rating = $rating_all / $rated_count;
								}
								//$rating = $product->get_average_rating();
								for( $stars = 1; $stars <= floor($rating); $stars++ ) {
									echo '<img src="' . THEME_URI . '/assets/images/star-orange.svg" alt="Rating Star">';
								}
								for ( $stars = 1; $stars <= (5 - floor($rating)); $stars++ ) {
									echo '<img src="' . THEME_URI . '/assets/images/star-gray.svg" alt="Rating Star">';
								}
								if ( round($rating, 1) == 5 ) {
									$dataRating = 1;
								} elseif ( round($rating, 1) == 4.9 ) { // 4.9
									$dataRating = 0.98;
								} elseif ( round($rating, 1) == 4.8 ) {
									$dataRating = 0.96;
								} elseif ( round($rating, 1) == 4.7 ) {
									$dataRating = 0.94;
								} elseif ( round($rating, 1) == 4.6 ) {
									$dataRating = 0.92;
								} elseif ( round($rating, 1) == 4.5 ) {
									$dataRating = 0.9;
								} elseif ( round($rating, 1) == 4.4 ) {
									$dataRating = 0.88;
								} elseif ( round($rating, 1) == 4.3 ) {
									$dataRating = 0.86;
								} elseif ( round($rating, 1) == 4.2 ) {
									$dataRating = 0.84;
								} elseif ( round($rating, 1) == 4.1 ) {
									$dataRating = 0.82;
								} elseif ( round($rating, 1) == 4 ) {
									$dataRating = 0.8;
								} elseif ( round($rating, 1) == 3.9 ) { // 3.9
									$dataRating = 0.78;
								} elseif ( round($rating, 1) == 3.8 ) {
									$dataRating = 0.76;
								} elseif ( round($rating, 1) == 3.7 ) {
									$dataRating = 0.74;
								} elseif ( round($rating, 1) == 3.6 ) {
									$dataRating = 0.72;
								} elseif ( round($rating, 1) == 3.5 ) {
									$dataRating = 0.6;
								} elseif ( round($rating, 1) == 3.4 ) {
									$dataRating = 0.68;
								} elseif ( round($rating, 1) == 3.3 ) {
									$dataRating = 0.66;
								} elseif ( round($rating, 1) == 3.2 ) {
									$dataRating = 0.64;
								} elseif ( round($rating, 1) == 3.1 ) {
									$dataRating = 0.62;
								} elseif ( round($rating, 1) == 3 ) {
									$dataRating = 0.6;
								} elseif ( round($rating, 1) == 2.9 ) { // 2.9
									$dataRating = 0.58;
								} elseif ( round($rating, 1) == 2.8 ) {
									$dataRating = 0.56;
								} elseif ( round($rating, 1) == 2.7 ) {
									$dataRating = 0.54;
								} elseif ( round($rating, 1) == 2.6 ) {
									$dataRating = 0.52;
								} elseif ( round($rating, 1) == 2.5 ) {
									$dataRating = 0.5;
								} elseif ( round($rating, 1) == 2.4 ) {
									$dataRating = 0.48;
								} elseif ( round($rating, 1) == 2.3 ) {
									$dataRating = 0.46;
								} elseif ( round($rating, 1) == 2.2 ) {
									$dataRating = 0.44;
								} elseif ( round($rating, 1) == 2.1 ) {
									$dataRating = 0.42;
								} elseif ( round($rating, 1) == 2 ) {
									$dataRating = 0.4;
								} elseif ( round($rating, 1) == 1.9 ) { // 1.9
									$dataRating = 0.38;
								} elseif ( round($rating, 1) == 1.8 ) {
									$dataRating = 0.36;
								} elseif ( round($rating, 1) == 1.7 ) {
									$dataRating = 0.34;
								} elseif ( round($rating, 1) == 1.6 ) {
									$dataRating = 0.32;
								} elseif ( round($rating, 1) == 1.5 ) {
									$dataRating = 0.3;
								} elseif ( round($rating, 1) == 1.4 ) {
									$dataRating = 0.28;
								} elseif ( round($rating, 1) == 1.3 ) {
									$dataRating = 0.26;
								} elseif ( round($rating, 1) == 1.2 ) {
									$dataRating = 0.24;
								} elseif ( round($rating, 1) == 1.1 ) {
									$dataRating = 0.22;
								} elseif ( round($rating, 1) == 1 ) {
									$dataRating = 0.2;
								} elseif ( round($rating, 1) == 0.9 ) { // 0.9
									$dataRating = 0.18;
								} elseif ( round($rating, 1) == 0.8 ) {
									$dataRating = 0.16;
								} elseif ( round($rating, 1) == 0.7 ) {
									$dataRating = 0.14;
								} elseif ( round($rating, 1) == 0.6 ) {
									$dataRating = 0.12;
								} elseif ( round($rating, 1) == 0.5 ) {
									$dataRating = 0.1;
								} elseif ( round($rating, 1) == 0.4 ) {
									$dataRating = 0.08;
								} elseif ( round($rating, 1) == 0.3 ) {
									$dataRating = 0.06;
								} elseif ( round($rating, 1) == 0.2 ) {
									$dataRating = 0.04;
								} elseif ( round($rating, 1) == 0.1 ) {
									$dataRating = 0.02;
								} elseif ( round($rating, 1) == 0 ) {
									$dataRating = 0;
								}
							?>
						</div>
						<div class="product-rating rating_circle" data-points="<?php echo round($rating, 1); ?>" data-percent="<?php $rating = (100 / 5) * round($rating, 1); echo $rating; ?>" data-duration="1000" data-color="#f4f4f4, #4CE426"></div>
					</div>
				</div>
				<div class="product_info">
					<?php the_content(); ?>
					<div class="product_price_and_buy">
						<?php if ( $product->get_price() ) : ?>
							<div class="product_price">
								<span class="product_price_range free_item">
									<?php
										if ($product->sale_price) {
											echo get_woocommerce_currency_symbol() . $product->sale_price . '<span class="old_price">' . get_woocommerce_currency_symbol() . $product->regular_price . '</span>';
										} else {
											echo get_woocommerce_currency_symbol() . $product->regular_price;
										}
									?>
								</span>
							</div>
						<?php endif; ?>
						<div class="product_buy">
							<a id="gray_button" class="gray_button" href="<?php echo home_url('/cart/?add-to-cart=' . $post->ID . '&redirect=true&url=' . get_the_permalink()); ?>" class="more">Get Now</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="product_card reviews">
			<div class="reviews_list">
				<?php 
					echo '<h3 class="reviews_title">Reviews</h3>';
					$reviews = get_comments([
						'post_id' => $post->ID,
						'type' => 'review',
						'status' => 1,
						'number' => 999999
					]);
					foreach ( $reviews as $review ) {
						$avatar = get_avatar_url($review->comment_author_email);
				?>
					<div class="review_item">
						<div class="reviewer_photo">
							<?php
								if ( $avatar ) {
									echo '<img src="' . $avatar . '" alt="' . $review->comment_author . '" title="' . $review->comment_author . '" width="50" height="50">';
								} else {
									echo '<img src="" alt="' . $review->comment_author . '" title="' . $review->comment_author . '" width="50" height="50">';
								}
							?>
							<div class="user_rating">
								<?php
									for( $stars = 1; $stars <= $review->rating; $stars++ ) {
										echo '<img src="' . THEME_URI . '/assets/images/star-orange.svg" alt="Rating Star">';
									}
									for ( $stars = 1; $stars <= (5 - $review->rating); $stars++ ) {
										echo '<img src="' . THEME_URI . '/assets/images/star-gray.svg" alt="Rating Star">';
									}
								?>
							</div>
						</div>
						<div class="reviewer_content">
							<h4 class="author">
								<?php echo $review->comment_author; ?> #<?php echo $review->user_id; ?>
							</h4>
							<span class="date"><?php echo date('F d, Y / H:i', strtotime($review->comment_date_gmt)); ?></span>
							<p><?php echo $review->comment_content; ?></p>
						</div>
					</div>
				<?php
					}
				?>
			</div>
			<?php
                if ( is_user_logged_in() ) :
                    if ( comments_open() || get_comments_number() ) {
                        comment_form([
                            'class_form' => 'item_reviews_cord',
                            'title_reply_before' => '<h2 class="replyform_title">',
                            'title_reply' => null,
                            'title_reply_after' => '</h2>',
                            ''
                        ]);
                    }
			?>
                <div class="sending_preloader">
                    <img src="<?php echo THEME_URI . '/assets/images/loading-spiner.svg' ?>" alt="Sending...">
                    <span>Sending</span>
                </div>
            <?php else : ?>
                <div class="comments_closed">
                    <p><?php esc_html_e('You should be logged in for leave reviews on this item.'); ?></p>
                </div>
            <?php endif; ?>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
