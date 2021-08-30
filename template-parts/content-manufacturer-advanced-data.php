<?php
    $aad = get_advanced_account_data(get_current_user_id())[0];
?>
<div class="add_data">
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
    <h2><?php esc_html_e('Update your details'); ?></h2>
    <form id="add_account_form" class="add_form" method="post" enctype="multipart/form-data">
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Banner'); ?><span><?php esc_html_e('(This banner shows your brand and how well you do your job. JPEG, JPG, PNG or GIF only and 250Kb max)'); ?></span>
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
                    }
                ?>
            </div>
        </div>
        <div class="formcontrol">
            <h4>
                <div class="add_data_half">
                    <?php esc_html_e('Account Photo or Logo'); ?><span><?php esc_html_e('(This is your account photo or logo. JPEG, JPG, or PNG only and 100Kb max)'); ?></span>
                </div>
                <a href="#" class="remove banner" onclick="removePhoto(event)" value="123"><?php esc_html_e('Remove'); ?></a>
            </h4>
            <div class="photo_img">
                <div class="photo_container">
                    <input id="set_photo" type="file" name="photo" class="photo" onchange="filePhoto(event)" accept="image/jpeg, image/jpg, image/png">
                    <?php
                        if ($aad->avatar) {
                            echo '<img src="' . $aad->avatar . '" id="photo_preview">';
                        }
                    ?>
                </div>
            </div>
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
</div>