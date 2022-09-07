<?php $_product = wc_get_product( get_the_ID() ); ?>
<div class="fresh_item">
    <a href="<?php the_permalink(); ?>">
        <div class="item_cover">
            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'small'); ?>" alt="<?php the_title(); ?>">
        </div>
        <h4><?php the_title(); ?></h4>
        <span class="price"><?php echo '$' . $_product->get_price(); ?></span>
        <button>View Item</button>
    </a>
</div>