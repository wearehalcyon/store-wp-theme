<?php
add_shortcode('get-account-form', 'get_account_form');
function get_account_form()
{
    $current_user = wp_get_current_user();
    ob_start();
?>
    <div class="get_account_form">
        <?php if (is_user_logged_in()) : ?>
            <h4>Hi, <?php echo $current_user->display_name; ?></h4>
            <p>You are already have account and now you are logged in.</p>
            <p>Visit your <a href="<?php echo wc_get_page_permalink('myaccount'); ?>">account page</a> or <a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>">logout</a>.</p>
        <?php else : ?>
            <form method="post" class="woocommerce-form woocommerce-form-register register">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="off" placeholder="Email address">
                </p>
                <p class="woocommerce-form-row form-row">
                    <input type="hidden" id="woocommerce-register-nonce" name="woocommerce-register-nonce" value="c19e5f738e">
                    <input type="hidden" name="_wp_http_referer" value="<?php echo home_url('/account/'); ?>">
                    <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="Register">Create Account</button>
                </p>
                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="<?php echo home_url('/privacy-policy/'); ?>" target="_blank">privacy policy</a>.</p>
            </form>
        <?php endif; ?>
    </div>
<?php
    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}
