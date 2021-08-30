<?php
get_header();
?>
    <section class="manu_hero_banner">

    </section>
    <div class="pjax-container">
        <main id="main" class="main site-main pjax-container">

            <?php
                $args = [
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'order_by'       => 'date',
                    'order'          => 'ASC'
                ];
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                    while ( $query->have_posts() ) :
                        $query->the_post();

                        get_template_part( 'template-parts/content', 'manufacturer' );

                    endwhile; // End of the loop.
                endif;
            ?>

        </main><!-- #main -->
    </div>

<?php
get_footer();