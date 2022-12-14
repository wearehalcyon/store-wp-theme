<?php
    $aad = get_advanced_account_data(get_current_user_id())[0];
    $manu = get_become_manufacturer(get_current_user_id())[0];
    $manumeta = get_user_meta(get_current_user_id());
?>
<div class="add_data">
    <?php if (1 == 2) : ?>
    <div class="<?php echo $manu->type ? 'account_status type_defined' : 'account_status type_undefined'; ?>">
        <div class="manu_column left">
            <strong>Manufacturer Type:</strong> <?php echo $manu->type ? ucfirst($manu->type . ' Manufacturer') : 'Not Assigned'; ?>
        </div>
        <div class="manu_column right">
            <?php echo !$manu->type ? '<a href="' . home_url('/account/') . '">Make Request</a>' : null; ?>
            <?php
                if ($manu->status == 'pending') {
                    echo '(Pending)';
                } elseif ($manu->status == 'reviewed') {
                    if ($manu->conclusion == 'NaN') {
                        echo '<span class="waiting">(Reviewed / Wait for a decision)</span>';
                    } elseif ($manu->conclusion == 'rejected') {
                        echo '<span class="rejected">(Reviewed / Rejected)</span>';
                    } else {
                        echo null;
                    }
                }
            ?>
        </div>
    </div>
    <div class="account_data">
        <div class="account_data_column account_earnings">
            <span class="add_money_titl"><?php esc_html_e('Earnings'); ?></span>
            <span class="moneys earns"><?php echo $aad->earns ? '$' . $aad->earns : '$0'; ?></span>
        </div>
        <div class="account_data_column account_withdrawn">
            <span class="add_money_titl"><?php esc_html_e('Withdrawned'); ?></span>
            <span class="moneys"><?php echo $aad->withdrawn ? '$' . $aad->withdrawn : '$0'; ?></span>
        </div>
    </div>
    <p><?php esc_html_e('Leave a request for withdrawal of funds, and we will consider it as soon as possible.'); ?></p>
    <?php endif; ?>
    <h2><?php esc_html_e('Update your details'); ?></h2>
    <form id="add_account_form" class="add_form" method="post" enctype="multipart/form-data">
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Banner'); ?><span><?php esc_html_e('(This banner shows your brand and how well you do your job. JPEG, JPG, PNG or GIF only and 350Kb max)'); ?></span>
                </div>
                <a href="#" class="remove banner" onclick="removeBanner(event)" value="123"><?php esc_html_e('Remove'); ?></a>
            </h4>
            <div class="banner_img">
                <div>
                    <p>1000x250</p>
                    <span><?php esc_html_e('Click to choose image'); ?></span>
                </div>
                <input id="set_banner" type="file" name="banner" class="banner" onchange="fileBanner(event)" accept="image/jpeg, image/jpg, image/png, image/gif">
                <?php
                    if ($aad->banner) {
                        echo '<img src="' . $aad->banner . '" id="banner_preview">';
                    } else {
                        echo '<img src="#" id="banner_preview" class="media-unset">';
                    }
                ?>
            </div>
        </div>
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Account Photo or Logo'); ?><span><?php esc_html_e('(This is your account photo or logo. JPEG, JPG, or PNG only and 200Kb max)'); ?></span>
                </div>
                <a href="#" class="remove banner" onclick="removePhoto(event)" value="123"><?php esc_html_e('Remove'); ?></a>
            </h4>
            <div class="photo_img">
                <div class="photo_container">
                    <input id="set_photo" type="file" name="photo" class="photo" onchange="filePhoto(event)" accept="image/jpeg, image/jpg, image/png">
                    <?php
                        if ($aad->avatar) {
                            echo '<img src="' . $aad->avatar . '" id="photo_preview">';
                        } else {
                            echo '<img src="#" id="photo_preview" class="media-unset">';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Public URL Nickname'); ?>
                </div>
            </h4>
            <span class="nickname-attr" data-nickname="<?php echo home_url('/manufacturer/'); ?>">
                <input type="text" name="nickname" class="text_input nickname" placeholder="johndoe" value="<?php echo $manumeta['nickname'][0] ? $manumeta['nickname'][0] : null; ?>">
            </span>
        </div>
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Public Email'); ?><span><?php esc_html_e('(If you want publish your email - fill this field)'); ?></span>
                </div>
            </h4>
            <input type="email" name="email" class="text_input email" placeholder="myemail@site.com" value="<?php echo $aad->email ? $aad->email : null; ?>">
        </div>
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Description'); ?><span><?php esc_html_e('(Please tell about yourself)'); ?></span>
                </div>
            </h4>
            <textarea name="description" class="text_input description" cols="30" rows="5" placeholder="Your description"><?php echo $aad->description ? $aad->description : null; ?></textarea>
        </div>
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Website'); ?><span><?php esc_html_e('(If you have your own website you can set it in this field)'); ?></span>
                </div>
            </h4>
            <input type="text" name="web" class="text_input web" placeholder="https://mysite.com/" value="<?php echo $aad->web ? $aad->web : null; ?>">
        </div>
        <div class="formcontrol">
            <button type="submit" class="update_add_account_form button"><?php esc_html_e('Update'); ?></button>
        </div>
        <div class="sending_preloader">
            <img src="<?php echo THEME_URI . '/assets/images/loading-spiner.svg' ?>" alt="Sending...">
        </div>
    </form>
    <?php if ($manu->conclusion != 'NaN' && $manu->conclusion != 'rejected' && 1 == 2) : ?>
        <div class="formcontrol manufacturer_control">
            <h2>Manufacturer Area</h2>
            <div class="manufacturer_form_description">
            You have access to the form of uploading your product to the marketplace. Enter all the data and send the item to us. We will check according to our requirements and put the product on the shop window. Please note that if we find any violations or inconsistencies with our requirements - we have the right to reject your request. Also, if your product violates our rules, but has already been published, we reserve the right to remove it from the store, with the right to no refund and block your account. Therefore, we ask you to carefully follow the rules and not break them. More details, you can find <a href="#">here</a>.
            </div>
            <hr>
            <h4 class="manufacturer_subtitle">
                <div class="add_data_half">Your products:</div>
                <div class="add_new_item">
                    <a href="<?php echo home_url('/account/item-add/'); ?>" class="button">Add New Item</a>
                </div>
            </h4>
            <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $pargs = [
                    'post_type' => 'product',
                    'posts_per_page' => 5,
                    'author' => get_current_user_id(),
                    'paged' => $paged
                ];
                $pquery = new WP_Query($pargs);
                if ($pquery->have_posts()) :
            ?>
                <ul class="products_list">
                    <?php while ($pquery->have_posts()) : $pquery->the_post(); ?>
                        <li>
                            <span class="title"><?php the_title(); ?></span>
                            <div class="actions">
                                <a href="<?php the_permalink(); ?>" class="view" target="_blank">View</a>
                                <a href="<?php echo home_url('/account/item-edit/?item=' . base64_encode(get_the_ID())); ?>" class="edit" target="_blank">Edit</a>
                                <a href="#remove_item" class="remove" data-item-id="<?php echo base64_encode(get_the_ID()); ?>">Delete Item</a>
                            </div>
                        </li>
                    <?php
                        endwhile;
                        echo paginate_links( array(
                            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                            'total'        => $pquery->max_num_pages,
                            'current'      => max( 1, get_query_var( 'paged' ) ),
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'plain',
                            'end_size'     => 2,
                            'mid_size'     => 1,
                            'prev_next'    => true,
                            'prev_text'    => null,
                            'next_text'    => null,
                            'add_args'     => false,
                            'add_fragment' => '',
                        ) );
                        wp_reset_query();
                    ?>
                </ul>
            <?php else : ?>
                <p>No products yet.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>


<div id="invalid_add_image" class="popup_win invalid_add_image">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win">✕</button>
        <div class="popup_win_ico large">
            <img src="<?php echo THEME_URI . '/assets/images/ico-alert.svg' ?>" alt="Alert Icon">
        </div>
        <h4>Error!</h4>
        <span>You uploading invalid image type or your image has a large size. Please use only JPEG, JPG, PNG or GIF images and not more than 350Kb.</span>
        <div class="confiramtion_buttons">
            <a href="#" class="button close_win">OK</a>
        </div>
    </div>
</div>
<div id="invalid_add_photo" class="popup_win invalid_add_photo">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win">✕</button>
        <div class="popup_win_ico large">
            <img src="<?php echo THEME_URI . '/assets/images/ico-alert.svg' ?>" alt="Alert Icon">
        </div>
        <h4>Error!</h4>
        <span>You uploading invalid image type or your image has a large size. Please use only JPEG, JPG, or PNG images and not more than 200Kb.</span>
        <div class="confiramtion_buttons">
            <a href="#" class="button close_win">OK</a>
        </div>
    </div>
</div>
<div id="remove_item_request" class="popup_win remove_item_request">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win">✕</button>
        <h4 style="margin-top: 10px;">Remove Item Request</h4>
        <span>Please tell us why you would like to remove this item.</span>
        <form action="" method="post" id="remove_item_req_form" class="remove_item_req_form">
            <strong class="remove-item-name"><span></span></strong>
            <div class="formcontrol" data-uid="<?php echo get_current_user_id(); ?>">
                <input type="hidden" name="uid" value="<?php echo get_current_user_id(); ?>">
                <input type="hidden" name="item_id" value="">
                <input type="hidden" name="item_name" value="">
            </div>
            <div class="formcontrol">
                <textarea name="message" id="" cols="10" rows="5" placeholder="Message text" required></textarea>
            </div>
            <div class="formcontrol" style="margin-bottom: 0;">
                <button type="submit" class="button">Submit Request</button>
                <div class="sending_preloader" style="margin: 10px 0 -10px;">
                    <img src="<?php echo THEME_URI . '/assets/images/loading-spiner.svg' ?>" alt="Sending...">
                </div>
            </div>
        </form>
    </div>
</div>
<div id="remove_item_request_success" class="popup_win remove_item_request_success">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win">✕</button>
        <h4 style="margin-top: 10px;">Success!</h4>
        <span>Your request was sent. We will reply as soon as possible. As usual it can take about 120 hours (5 days). Please be patient and wait for response.</span>
        <div class="confiramtion_buttons">
            <a href="#" class="button close_win">OK</a>
        </div>
    </div>
</div>
<div id="remove_item_request_error" class="popup_win remove_item_request_error">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win">✕</button>
        <div class="popup_win_ico large">
            <img src="<?php echo THEME_URI . '/assets/images/ico-alert.svg' ?>" alt="Alert Icon">
        </div>
        <h4>Error!</h4>
        <span>Something went wrong and request was not sent! Please try again later.</span>
        <div class="confiramtion_buttons">
            <a href="#" class="button close_win">OK</a>
        </div>
    </div>
</div>