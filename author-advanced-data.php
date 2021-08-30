<?php
/**
 * Template name: User Advanced Data
 */
get_header();
?>
    <div class="add_page">
        <main id="main" class="main site-main pjax-container">
            <?php
                if ( is_user_logged_in() ) {
                    echo '<h1 class="page_title">Account ' . get_the_title() . '</h1>';
                    get_template_part( 'template-parts/content', 'manufacturer-advanced-data' );
                } else {
                    get_template_part( 'template-parts/content', 'none' );
                }
            ?>

        </main><!-- #main -->
    </div>

<?php
get_footer();