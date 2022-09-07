<?php
    get_header();
    global $wpdb;
    $table = $wpdb->prefix . 'user_advanced_data';
    $manu_adv_data = $wpdb->get_results( "SELECT * FROM $table WHERE user_id = $author" );

?>
    <section class="manu_hero_banner" style="background-image: <?php echo $manu_adv_data[0]->banner ? 'url(' . $manu_adv_data[0]->banner . '); background-repeat: no-repeat; background-position: center center; background-size: cover;' : 'linear-gradient(#fafafa, #ccc)'; ?>;">
        <div class="user-data">
            <div class="avatar">
                <img src="<?php echo $manu_adv_data[0]->avatar ? $manu_adv_data[0]->avatar : get_template_directory_uri() . '/assets/images/no-avatar.svg'; ?>" alt="<?php echo get_author_name( $author ); ?>">
            </div>
            <div class="meta">
                <h1 class="name"><?php echo get_author_name( $author ); ?></h1>
                <div class="actions">
                    <a href="<?php echo home_url('/account/msg/compose/?manu=' . $author); ?>">Message</a>
                </div>
            </div>
        </div>
    </section>
    <main id="main" class="main site-main manu-content">

        <?php
            $args = [
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'meta_query'     => [
                    [
                        'key'     => 'manufacturer',
                        'value'   => $author,
                        'compare' => 'IN'
                    ]
                ]
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

<?php
get_footer();