<?php
/**
 * Template name: Item Add
 */
    get_header();
    $curruser = get_current_user_id();

    $cats_args = array(
        'taxonomy'     => 'product_cat',
        'orderby'      => 'name',
        'show_count'   => false,
        'pad_counts'   => false,
        'hierarchical' => true,
        'title_li'     => null,
        'hide_empty'   => false,
        'parent'       => false
    );
    $all_categories = get_categories( $cats_args );
?>
    <div class="add_page">
        <main id="main" class="main site-main">
            <h1 class="page_title">Add New Item</h1>
            <form action="" method="post" class="add_data item_data" enctype="multipart/form-data">
                <div class="cover">
                    <img src="<?php echo get_the_post_thumbnail_url($itemID); ?>" alt="<?php echo get_the_title($itemID); ?>" class="cover_img">
                </div>
                <div class="desc">
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Title'); ?>
                            </div>
                        </h4>
                        <input type="text" name="title" class="text_input title" placeholder="Ableton Progressive House Template (vol. 1)">
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Description'); ?>
                            </div>
                        </h4>
                        <textarea name="description" class="text_input description" cols="30" rows="5" placeholder="The description of the product greatly influences the sale. Try to describe your work in as much detail as possible, but at the same time, do not overload it with text."></textarea>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Category'); ?>
                            </div>
                        </h4>
                        <?php $parcount = 1; foreach ($all_categories as $all_category) : ?>
                            <label class="input_label">
                                <input type="radio" name="category" class="radio_input category" value="<?php echo $all_category->slug; ?>"<?php echo $parcount++ == 1 ? ' checked' : null; ?>><span><?php echo $all_category->name; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Subcategory'); ?>
                            </div>
                        </h4>
                        <label class="input_label">
                            <input type="radio" name="subcategory" class="radio_input category" value="construction_kits" checked><span>Construction Kits</span>
                        </label>
                        <label class="input_label">
                            <input type="radio" name="subcategory" class="radio_input category" value="releases"><span>Releases</span>
                        </label>
                        <label class="input_label">
                            <input type="radio" name="subcategory" class="radio_input category" value="sample-packs"><span>Sample Packs</span>
                        </label>
                        <label class="input_label">
                            <input type="radio" name="subcategory" class="radio_input category" value="vst-soundbanks"><span>VST Soundbanks</span>
                        </label>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Price'); ?><span style="display: block; margin: 0;">(IMPORTANT! We can offer this price if we consider your product to be of lower or higher quality. Notification will be sent to you in private messages.)</span>
                            </div>
                        </h4>
                        <input type="text" name="price" class="text_input price" placeholder="$100">
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Archive Link'); ?><span style="display: block; margin: 0;">(Please use sharing services like Dropbox, Zippyshare, WeTransfer etc...)</span>
                            </div>
                        </h4>
                        <input type="text" name="archive" class="text_input archive" placeholder="https://www.dropbox.com/h?preview=example-archive.zip">
                    </div>
                </div>
            </form>
        </main><!-- #main -->
    </div>
<?php
get_footer();