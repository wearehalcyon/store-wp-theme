<?php
/**
 * Template name: Item Edit
 */
get_header();
$curruser = get_current_user_id();

if (isset($_GET['item'])) {
    $itemID = (int)base64_decode($_GET['item']);
    $itemAvailable = get_post($itemID);
    $product = wc_get_product($itemID);
    $author = (int)$itemAvailable->post_author;
    $post_type = $itemAvailable->post_type;
}
?>
    <div class="add_page">
        <main id="main" class="main site-main">
            <?php if ($itemAvailable && $curruser === $author && $post_type === 'product') : ?>
                <h1 class="page_title"><?php echo 'Edit Item: ' . get_the_title($itemID); ?></h1>
                <div class="add_data item_data">
                    <div class="cover">
                        <img src="<?php echo get_the_post_thumbnail_url($itemID); ?>" alt="<?php echo get_the_title($itemID); ?>" class="cover_img">
                    </div>
                    <div class="desc">
                        <p class="exc"><?php echo $product->description; ?></p>
                    </div>
                </div>
            <?php else : ?>
                <h1 class="page_title">Error: Item not found!</h1>
            <?php endif; ?>
        </main><!-- #main -->
    </div>
<?php
get_footer();