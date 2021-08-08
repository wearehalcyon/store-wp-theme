<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package INTAKE_DIgital
 */
global $product, $post;
?>

<li class="product_item fresh_item">
	<a href="<?php the_permalink(); ?>">
		<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'small'); ?>" alt="<?php the_title(); ?>">
		<h4><?php the_title(); ?></h4>
		<span class="price"><?php echo '$' . $product->get_price(); ?></span>
		<button>View Item</button>
	</a>
</li>
