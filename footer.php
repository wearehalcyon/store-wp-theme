<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package INTAKE_DIgital
 */
global $woocommerce, $current_user;
?>

	<footer class="footer">
        <div class="footer_container">
            <div class="footer_column footer_left">
                <a href="<?php echo home_url('/'); ?>">
                    <img class="logo" src="<?php echo THEME_URI . '/assets/images/logo.svg'; ?>" alt="<?php bloginfo('name'); ?>">
                </a>
                <p>Copyright by INTAKE Digital &copy <?php echo date('Y'); ?></p>
            </div>
            <div class="footer_column footer_middle">
                <h4>Quick Information</h4>
                <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu',
                        'menu_class' => false,
                        'menu_id' => false,
                        'container' => false,
                        'after' => '<span class="delimiter">|</span>'
                    ]);
                ?>
            </div>
            <div class="footer_column footer_right">
                <?php
                    $theme = wp_get_theme();
                    echo '<a href="https://intakedigital.net/" target="_blank">INTAKE Digital</a><br>';
                    echo '<p>Version: ' . $theme->Version . '</p>';
                ?>
            </div>
        </div>
    </footer>
    <?php if ( 1 == 2 &&  get_browser_name() != 'Chrome' && get_browser_name() != 'Safari' && get_browser_name() != 'Opera' ) : ?>
        <div class="unsupported_browser">
            <?php esc_html_e('You are used unsupported browser. Application will work but sometimes you can see some glitches or transparencies. For better experience you can use Chrome based browsers or Safari.'); ?>
            <br>
            <?php esc_html_e('Your current browser is: ' . get_browser_name()) ?>
        </div>
    <?php endif; ?>
    <?php if ($woocommerce->cart->cart_contents_count > 0) : ?>
        <div id="quick_cart" class="quick_cart_layer">
            <h4><?php esc_html_e('Your Bag'); ?></h4>
            <?php
                $qcart = WC()->cart->get_cart();
                foreach ($qcart as $qproduct) :
                    $price = wc_get_product( $qproduct['product_id'] );
                    $total_price += $price->get_price();
            ?>
                <div class="qcart_item <?php echo 'product-id-' . $qproduct['product_id']; ?>">
                    <a href="<?php echo get_the_permalink($qproduct['product_id']); ?>" title="<?php echo get_the_title($qproduct['product_id']); ?>">
                        <div class="icon">
                            <img src="<?php echo get_the_post_thumbnail_url($qproduct['product_id'], 'small'); ?>" alt="<?php echo get_the_title($qproduct['product_id']); ?>" title="<?php echo get_the_title($qproduct['product_id']); ?>">
                        </div>
                        <div class="meta">
                            <h4><?php echo get_the_title($qproduct['product_id']); ?></h4>
                            <p><?php echo __('Quantity: ') . $qproduct['quantity'] . ' <span>Price: ' . get_woocommerce_currency_symbol() . $price->get_price() . '</span>'; ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
            <div class="qcart_total">
                <h4><?php echo 'Total to pay: ' . get_woocommerce_currency_symbol() . $total_price; ?></h4>
            </div>
            <?php if (!is_cart()) : ?>
                <div class="qcart_goto">
                    <a href="<?php echo home_url('/cart/'); ?>" class="button button-primary">Go to cart</a>
                </div>
            <?php endif; ?>
            <a href="<?php echo home_url($_SERVER['REQUEST_URI'] . '?qcart=empty'); ?>" title="Empty Cart" class="button button-delete empty-cart-button">Empty bag</a>
        </div>
    <?php endif; ?>
</div><!-- #page -->
<?php if (!is_user_logged_in()) : ?>
<div id="signin" class="popup_win signin_popup">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win"></button>
        <h4>Sign In</h4>
        <span>To take full advantage of this store, you need to sign in to your account.</span>
        <?php
            wp_login_form( array(
                'echo'           => true,
                'redirect'       => site_url( $_SERVER['REQUEST_URI'] ),
                'form_id'        => 'loginform',
                'label_username' => null,
                'label_password' => null,
                'label_remember' => null,
                'label_log_in'   => __( 'Sign In' ),
                'id_username'    => 'user_login',
                'id_password'    => 'user_pass',
                'id_remember'    => 'rememberme',
                'id_submit'      => 'wp-submit',
                'remember'       => false,
                'value_username' => false,
                'value_remember' => false,
                'placeholder_username' => __('Test'),
                'placeholder_remember' => false
            ) );
        ?>
        <script>
            var name_ph = document.getElementById('user_login');
            var pass_ph = document.getElementById('user_pass');
            name_ph.setAttribute('placeholder', 'Account name or email');
            pass_ph.setAttribute('placeholder', 'Password');
        </script>
        <div class="create_account">
            <a href="<?php echo home_url('/get-account/'); ?>">Create account</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['status']) == 'cleared') : ?>
    <div class="tooltip message qcart_cleared">
        <button class="close_tooltip">✕</button>
        <p>Your bag was been emptied completely.</p>
    </div>
<?php endif; ?>
<div id="coockie_policy" class="popup_win coockie_policy">
    <div class="bglayer"></div>
    <div class="signin_win">
        <h4>Cookie Policy</h4>
        <span>This application uses cookies. By using this application, you agree to our privacy policy.</span>
        <div class="browse_coockie_policy">
            <a href="#read_cpolicy" class="read_cockie_policy">Read Coockie Policy</a>
            <div class="read_cpolicy_text">
                <?php
                    $coockie = get_post(3);
                    $coockie_content = $coockie->post_content;
                    echo $coockie_content;
                ?>
            </div>
            <div class="submit_coockie_policy">
                <a href="#" class="button button-primary close_coockie_policy">Accept</a>
            </div>
        </div>
    </div>
</div>
<?php if (is_user_logged_in()) : ?>
    <div id="become_manufacturer" class="popup_win become_manufacturer">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win"></button>
        <h4>Become Manufacturer</h4>
        <span>Fill out the application form and we will review it shortly.</span>
        <form action="" method="post">
            <input class="user_id" type="hidden" name="user_id" value="<?php echo $current_user->id; ?>">
            <input class="name" type="hidden" name="name" value="<?php echo $current_user->display_name; ?>">
            <input class="email" type="hidden" name="email" value="<?php echo $current_user->user_email; ?>">
            <input class="date" type="hidden" name="date" value="<?php echo date('m-d-Y H:i:s'); ?>">
            <p class="formcontrol">
                <select class="type" name="type" required>
                    <option value="design">Design</option>
                    <option value="development">Development</option>
                    <option value="artwork">Artwork</option>
                    <option value="music">Music</option>
                </select>
            </p>
            <p class="formcontrol">
                <textarea class="message" name="message" cols="30" rows="4" placeholder="Tell us more about yourself and your request..." required></textarea>
            </p>
            <p class="formcontrol">
                <input class="demo_link" type="text" name="demo_link" placeholder="Demo link" required>
            </p>
            <p class="formcontrol">
                <button type="submit" name="send_request" class="button button-primary send_request_become_manufacturer">Send Request</button>
            </p>
        </form>
    </div>
</div>
<div id="confirm_deleting" class="popup_win confirm_deleting">
    <div class="bglayer"></div>
    <div class="signin_win">
        <button class="close_win"></button>
        <div class="popup_win_ico large">
            <img src="<?php echo THEME_URI . '/assets/images/ico-alert.svg' ?>" alt="Alert Icon">
        </div>
        <h4>Delete this item</h4>
        <span>Are you sure? It will be permanently deleted and cannot be restored.</span>
        <div class="confiramtion_buttons">
            <a href="#" class="button cancel">Cancel</a>
            <a href="#" class="button approve">Delete</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (is_product()) : ?>
    <div id="review_not_sent" class="popup_win review_not_sent">
        <div class="bglayer"></div>
        <div class="signin_win">
            <button class="close_win"></button>
            <div class="popup_win_ico large">
                <img src="<?php echo THEME_URI . '/assets/images/ico-alert.svg' ?>" alt="Alert Icon">
            </div>
            <h4>Error!</h4>
            <span>Something went wrong! Review was not sent. Try again later or check review field again.</span>
            <div class="confiramtion_buttons">
                <a href="#" class="button close_win">OK</a>
            </div>
        </div>
    </div>
    <div id="review_sent" class="popup_win review_sent">
        <div class="bglayer"></div>
        <div class="signin_win">
            <button class="close_win"></button>
            <h4>Success!</h4>
            <span>Review was sent successfully! Now we should verify your comment. Wait a bit.</span>
            <div class="confiramtion_buttons">
                <a href="#" class="button close_win">OK</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
