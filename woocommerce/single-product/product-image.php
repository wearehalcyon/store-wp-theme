<?php
	global $post;
?>
<div class="product_card_display">
	<img class="cover" src="<?php echo get_the_post_thumbnail_url($post->ID, 'medium'); ?>" alt="<?php the_title(); ?>">
	<h4><?php esc_html_e('Preview'); ?></h4>
</div>