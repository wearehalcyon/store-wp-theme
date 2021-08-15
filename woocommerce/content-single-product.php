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
						</div>
						<div class="reviewer_content">
							<h4 class="author"><?php echo $review->comment_author; ?> #1</h4>
							<span class="date"><?php echo date('F d, Y / H:i', strtotime($review->comment_date_gmt)); ?></span>
							<p><?php echo $review->comment_content; ?></p>
						</div>
					</div>
				<?php
					}
				?>
			</div>
			<?php
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
