<?php
	/**
	 * Single Product Image
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see     https://docs.woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 3.5.1
	 */
	global $post;
?>
<div class="product_card_display">
	<img class="cover" src="<?php echo get_the_post_thumbnail_url($post->ID, 'medium'); ?>" alt="<?php the_title(); ?>">
	<h4><?php esc_html_e('Preview'); ?></h4>
</div>