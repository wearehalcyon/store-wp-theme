<?php
get_header();
?>
    <div class="pjax-container">
        <main id="main" class="main">
            <div class="fresh_releases">
                <?php
                    $args = [
                        'post_type' => 'product',
                        'posts_per_page' => 5,
                        // 'meta_query' => [
                        //     'relation' => 'AND',
                        //     [
                        //         'key' => '_price',
                        //         'value' => 0,
                        //         'compare' => '!='
                        //     ]
                        // ]
                    ];
                    $query = new WP_Query($args);
                    if ( $query->have_posts() ) :
                ?>
                    <h2 class="home_section_title">Fresh Items<a href="#">View All</a></h2>
                    <div class="fresh_releases_list">
                        <?php while( $query->have_posts() ) : $query->the_post(); $_product = wc_get_product( get_the_ID() ); ?>
                            <div class="fresh_item<?php echo $_product->is_on_sale() ? ' on_sale' : null; echo $_product->get_price() < 1 ? ' free_item' : null; ?>">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (get_field('black_friday')) : ?>
                                        <span class="black_friday_badge">BLACK FRIDAY</span>
                                    <?php endif; ?>
                                    <div class="item_cover">
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'small'); ?>" alt="<?php the_title(); ?>">
                                    </div>
                                    <h4><?php the_title(); ?></h4>
                                    <span class="price"><?php echo '$' . $_product->get_price(); ?></span>
                                    <button>View Item</button>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="other_content">
                <?php
                    $all_terms = get_terms([
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => false,
                        'orderby' => 'name',
                        'order' => 'ASC'
                    ]);
                    if ( $all_terms ) :
                ?>
                    <h2 class="home_section_title small_title">Categories</h2>
                    <div class="owl-carousel owl-theme all_categories all-categories-slider">
                        <?php foreach( $all_terms as $all_term ) : ?>
                            <div class="item category_item">
                                <a href="<?php echo get_term_link($all_term->term_id); ?>">
                                    <div class="cat_icon">
                                        <?php the_field('svg_icon', $all_term); ?>
                                    </div>
                                <h4><?php echo $all_term->name; ?></h4>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ( have_rows('banner_slider', 'option') ) : ?>
                    <div class="featured">
                        <h2 class="home_section_title small_title">Featured</h2>
                        <div class="owl-carousel owl-theme banners-slider">
                            <?php while( have_rows('banner_slider', 'option') ) : the_row(); ?>
                                <div class="item banner_slide">
                                    <a href="<?php the_sub_field('link', 'option'); ?>">
                                        <img src="<?php the_sub_field('image', 'option'); ?>" alt="<?php the_sub_field('banner_title', 'option'); ?>">
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                    $free_args = [
                        'post_type' => 'product',
                        'posts_per_page' => 12,
                        'meta_query' => [
                            'relation' => 'AND',
                            [
                                'key' => '_price',
                                'value' => 0,
                                'compare' => '='
                            ]
                        ]
                    ];
                    $free_query = new WP_Query($free_args);
                    if ( $free_query->have_posts() ) :
                ?>
                    <!-- free items -->
                    <div class="free_items">
                        <h2 class="home_section_title small_title">Free Items<a href="#">View All</a></h2>
                        <?php
                            while( $free_query->have_posts() ) : $free_query->the_post();
                            $_product = wc_get_product( get_the_ID() );
                            $object_terms = wp_get_object_terms( get_the_ID(), 'product_cat', array( 'fields' => 'all' ) );
                            foreach ($object_terms as $object_term) {
                                if ( $object_term->parent ) {
                                    $free_item_cat = $object_term->name;
                                }
                            }
                        ?>
                            <div class="free_item">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'small'); ?>" alt="<?php the_title(); ?>">
                                    <div class="free_item_meta">
                                        <h4 class="free_item_title"><?php the_title(); ?></h4>
                                        <span class="free_item_cat"><?php echo $free_item_cat; ?></span>
                                        <div class="free_item_download">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M20 17.2919H-1.90735e-06V20H20V17.2919ZM6.32025 0H13.6797V8.2772H18.2794L10 15.9878L1.72053 8.2772H6.32025V0Z" fill="black"/>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php
                    $reviews = get_comments([
                        'post_type' => 'product',
                        'number' => 4
                    ]);
                    if ( $reviews ) :
                ?>
                    <div class="latest_reviews">
                        <h2 class="home_section_title small_title">Latest Reviews</h2>
                        <?php foreach( $reviews as $review ) : ?>
                            <div class="review_card">
                                <div class="avatar">
                                    <?php if (get_avatar_url($review->comment_author_email)) : ?>
                                        <img src="<?php echo get_avatar_url($review->comment_author_email); ?>" alt="<?php echo $review->comment_author; ?>">
                                    <?php else : ?>
                                        <img class="no_avatar" src="<?php echo THEME_URI . '/assets/images/no-avatar.svg'; ?>" alt="<?php echo $review->comment_author; ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="reviewer_meta">
                                    <h4>
                                        <?php echo $review->comment_author; ?>
                                        <span><?php echo date('F d, Y', strtotime($review->comment_date_gmt)); ?></span>
                                    </h4>
                                    <div class="review_source">
                                        <a href="<?php echo get_the_permalink($review->comment_post_ID); ?>"><?php echo get_the_title($review->comment_post_ID); ?></a>
                                    </div>
                                    <p><?php echo $review->comment_content; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
<?php
get_footer();