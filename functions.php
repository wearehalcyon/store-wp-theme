<?php

/**
 * INTAKE DIgital functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package INTAKE_DIgital
 */

/**
 * Hide admin bar
 */
//show_admin_bar(false);

function woocommerce_theme_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'woocommerce_theme_support' );

if (!defined('THEME_URI')) {
	// Replace the version number of the theme on each release.
	define('THEME_URI', get_template_directory_uri());
}

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('intake_digital_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function intake_digital_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on INTAKE DIgital, use a find and replace
		 * to change 'intake-digital' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('intake-digital', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'intake-digital'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'intake_digital_custom_background_args',
				array(
					'default-image' => '',
					'wp-head-callback'       => '_custom_background_cb',
					'admin-head-callback'    => '',
					'admin-preview-callback' => ''
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'intake_digital_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function intake_digital_content_width()
{
	$GLOBALS['content_width'] = apply_filters('intake_digital_content_width', 640);
}
add_action('after_setup_theme', 'intake_digital_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function intake_digital_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'intake-digital'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'intake-digital'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'intake_digital_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function intake_digital_scripts()
{
	wp_enqueue_style('intake-digital-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('intake-digital-owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css', array(), _S_VERSION);
	wp_enqueue_style('intake-digital-owl-slider', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), _S_VERSION);
	wp_enqueue_style('intake-digital-nice-select', get_template_directory_uri() . '/assets/css/nice-select.css', array(), _S_VERSION);
	wp_enqueue_style('intake-digital-main-style', get_template_directory_uri() . '/assets/css/app.css', array(), filemtime(__DIR__ . '/assets/css/app.css'));
	wp_style_add_data('intake-digital-style', 'rtl', 'replace');

	wp_enqueue_script('intake-digital-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('intake-digital-owl-slider', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), _S_VERSION, true);
	wp_enqueue_script('intake-digital-nice-select', get_template_directory_uri() . '/assets/js/nice-select.min.js', array('jquery'), _S_VERSION, true);
	if ( is_product() ) {
		wp_enqueue_script('intake-digital-progressbar', get_template_directory_uri() . '/assets/js/progressbar.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_script('intake-digital-progress-bar', get_template_directory_uri() . '/assets/js/progress-bar.js', array('jquery'), _S_VERSION, true);
		if (get_field('audio_file')) {
			wp_enqueue_script('intake-digital-wavesurfer', get_template_directory_uri() . '/assets/js/wavesurfer.js', array('jquery'), _S_VERSION, true);
		}
	}
    wp_register_script( 'app-scripts', get_template_directory_uri() . '/assets/js/app.js', array( 'jquery' ), filemtime(__DIR__ . '/assets/js/app.js'), true );
    wp_enqueue_script( 'app-scripts');

    wp_localize_script( 'app-scripts', 'ajax_url', array(
        'url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce('app-ajax-nonce')
    ) );

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'intake_digital_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Register form.
 */
require get_template_directory() . '/inc/register-form.php';

/**
 * Browser detector class.
 */
require get_template_directory() . '/inc/Browser.php';

/**
 * Admin menus.
 */
require get_template_directory() . '/inc/admin/admin-menus.php';

/**
 * REST API.
 */
require get_template_directory() . '/inc/rest-api.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Disable Gutenberg
 */
if ('disable_gutenberg') {
	remove_theme_support('core-block-patterns');
	add_filter('use_block_editor_for_post_type', '__return_false', 100);
	remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
	add_action('admin_init', function () {
		remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
		add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']);
	});
}

/**
 * Menus
 */
register_nav_menus(array(
	'aside'    => 'Aside Sidebar Top',
	'aside-bottom' => 'Aside Sidebar Bottom',
	'footer-menu' => 'Footer Menu'
));

// Custom body classes
add_filter('body_class', 'intake_digital_custom_body_classes');
function intake_digital_custom_body_classes($classes)
{
	$classes[] = 'wpb-class';
	if (!is_front_page()) {
		return str_replace('custom-background', '', $classes);
	} else {
		return $classes;
	}
}

// Options page
if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	]);
}

// Browser detector baset on Browser class
function get_browser_name()
{
	$browser = new Browser();
	return $browser->getBrowser();
}

// Become Manufacturer request
add_action('wp_ajax_nopriv_ajax_become_manufacturer', 'become_manufacturer_ajax_form');
add_action('wp_ajax_ajax_become_manufacturer', 'become_manufacturer_ajax_form');
function become_manufacturer_ajax_form()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'become_manufacturer_requests';

	$user_id = $_POST['user_id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$type = $_POST['type'];
	$message = $_POST['message'];
	$demo_link = $_POST['demo_link'];
	$date = $_POST['date'];
	
	if (!empty($type) && !empty($message) && !empty($demo_link)) {
		$wpdb->insert($table_name, [
			'user_id' => $user_id,
			'public_id' => mt_rand(1000, 9999),
			'name' => $name,
			'email' => $email,
			'type' => $type,
			'message' => $message,
			'demo_link' => $demo_link,
			'date' => $date,
			'status' => 'pending',
			'conclusion' => 'NaN'
		]);
		$response = true;
	} else {
		$response = false;
	}

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo $response;
		wp_die();
	} else {
		echo $response;
	}
}

//add_action('wp_footer', 'sendtest');
function get_manufacturer_request($id = null)
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'become_manufacturer_requests';

	$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`user_id` = $id)");

	return $request;
}

// Messenger request
add_action('wp_ajax_nopriv_ajax_messenger', 'messenger_ajax_form');
add_action('wp_ajax_ajax_messenger', 'messenger_ajax_form');
function messenger_ajax_form()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'user_messages';

	$user_id = $_POST['user_id'];
	$sender_id = $_POST['sender_id'];
	$message = $_POST['message'];

	$wpdb->insert($table_name, [
		'user_id' => $user_id,
		'sender_id' => $sender_id,
		'message' => stripslashes($message),
		'viewed' => 0,
		'date' => date('m/d/Y H:i:s'),
		'hash' => md5(date('m/d/Y H:i:s'))
	]);

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo true;
		wp_die();
	} else {
		echo false;
	}
}

// Messenger request - delete
add_action('wp_ajax_nopriv_ajax_messenger_delete', 'messenger_ajax_delete_link');
add_action('wp_ajax_ajax_messenger_delete', 'messenger_ajax_delete_link');
function messenger_ajax_delete_link()
{
	global $wpdb, $current_user;

	$id = $current_user->ID;

	$table_name = $wpdb->prefix . 'user_messages';

	$message_id = $_POST['message_id'];

	$wpdb->update(
		$table_name,
		[
			'deleted' => 1,
			'deleted_by' => $id,
			'deleting_date' => date('m/d/Y H:i:s')
		],
		[
			'ID' => $message_id
		]
	);

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo true;
		wp_die();
	} else {
		echo false;
	}
}

// Detect if user have new messages
function get_new_messages()
{
	global $wpdb, $current_user;

	$id = $current_user->ID;

	$table_name = $wpdb->prefix . 'user_messages';

	$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`user_id` = $id AND `viewed` = 0)");

	if ($request) {
		return true;
	}

	return false;
};

// Messenger request
add_action('wp_ajax_nopriv_ajax_compose_message', 'messenger_ajax_compose_message');
add_action('wp_ajax_ajax_compose_message', 'messenger_ajax_compose_message');
function messenger_ajax_compose_message()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'user_messages';

	$user_id = $_POST['user_id'];
	$sender_id = $_POST['sender_id'];
	$message = $_POST['message'];

	if (!empty($user_id) && !empty($sender_id) && !empty($message)) {
		$wpdb->insert($table_name, [
			'user_id' => $user_id,
			'sender_id' => $sender_id,
			'message' => stripslashes($message),
			'viewed' => 0,
			'deleted' => 0,
			'deleted_by' => null,
			'deleting_date' => null,
			'date' => date('m/d/Y H:i:s'),
			'hash' => md5(date('m/d/Y H:i:s'))
		]);
		$response = true;
	} else {
		$response = false;
	}

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo $response;
		wp_die();
	}
}

// Remove comments login link
add_filter( 'comment_form_logged_in', '__return_empty_string' );

// Customize reviewer form
add_filter('comment_form_defaults', 'wpsites_modify_comment_form_text_area');
function wpsites_modify_comment_form_text_area($arg) {
	global $post;
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
    $arg['comment_field'] = '<div class="rate_product_please"><h5>Rate product please</h5><div class="rating_slider"><img src="' . THEME_URI . '/assets/images/star-orange.svg" data-count="1" alt="Rating Star" class="voting_star choosed"><img src="' . THEME_URI . '/assets/images/star-orange.svg" data-count="2" alt="Rating Star" class="voting_star"><img src="' . THEME_URI . '/assets/images/star-orange.svg" data-count="3" alt="Rating Star" class="voting_star"><img src="' . THEME_URI . '/assets/images/star-orange.svg" data-count="4" alt="Rating Star" class="voting_star"><img src="' . THEME_URI . '/assets/images/star-orange.svg" data-count="5" alt="Rating Star" class="voting_star"><input type="hidden" name="rating" value="1"></div></div><input type="hidden" name="ip" value="' . $ip . '"><input type="hidden" name="agent" value="' . $_SERVER['HTTP_USER_AGENT'] . '"><input type="hidden" name="item_id" value="' . $post->ID . '"><p class="formcontroll"><textarea id="comment" name="comment" cols="45" rows="1" aria-required="true" placeholder="Your review" required></textarea></p>';
    return $arg;
}

// Send review AJAX
add_action('wp_ajax_nopriv_ajax_send_review', 'send_review_ajax_form');
add_action('wp_ajax_ajax_send_review', 'send_review_ajax_form');
function send_review_ajax_form()
{
	global $wpdb, $post, $current_user;

	$table_name = $wpdb->prefix . 'comments';

	$comment_post_ID = $_POST['comment_post_ID'];
	$comment_author = $current_user->display_name;
	$comment_author_email = $current_user->user_email;
	$comment_author_url = $current_user->user_url;
	$comment_author_IP = $_POST['comment_author_IP'];
	$comment_date = date('Y-m-d H:i:s');
	$comment_date_gmt = date('Y-m-d H:i:s');
	$comment_content = $_POST['comment_content'];
	$comment_karma = 0;
	$comment_approved = 0;
	$comment_agent = $_POST['comment_agent'];
	$comment_type = 'review';
	$comment_parent = 0;
	$user_id = $current_user->ID;
	$rating = $_POST['rating'];

	if ( !empty($comment_content) ) {
		$wpdb->insert($table_name, [
			'comment_post_ID' => $comment_post_ID,
			'comment_author' => $comment_author,
			'comment_author_email' => $comment_author_email,
			'comment_author_url' => $comment_author_url,
			'comment_author_IP' => $comment_author_IP,
			'comment_date' => $comment_date,
			'comment_date_gmt' => $comment_date_gmt,
			'comment_content' => $comment_content,
			'comment_karma' => $comment_karma,
			'comment_approved' => $comment_approved,
			'comment_agent' => $comment_agent,
			'comment_type' => $comment_type,
			'comment_parent' => $comment_parent,
			'user_id' => $user_id,
			'rating' => $rating
		]);
		$response = true;
	} else {
		$response = false;
	}

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo $response;
		wp_die();
	}
}

// Custom product price in single page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30); // ----
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_filter('woocommerce_is_sold_individually', 'custom_remove_all_quantity_fields', 10, 2);
function custom_remove_all_quantity_fields( $return, $product ){
	return true;
}

// Add to cart link button redirect
add_action('send_headers', 'wc_cart_add_custom_redirect', 9999);
function wc_cart_add_custom_redirect(){
	if (isset($_GET['redirect']) == 'true') {
		header('Location: ' . $_GET['url']);
		exit;
	}
}

// Author slug
add_action('init', 'cng_author_base');
function cng_author_base() {
    global $wp_rewrite;
    $author_slug = 'manufacturer'; // change slug name
    $wp_rewrite->author_base = $author_slug;
}

// Advanced Account Data
function get_advanced_account_data($id){
    global $wpdb;

    $table_name = $wpdb->prefix . 'user_advanced_data';

    $request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`user_id` = $id)");

    return $request;
}

// Become manufacturer
function get_become_manufacturer($user_id = null){
	global $wpdb;

	$table_name = $wpdb->prefix . 'become_manufacturer_requests';

	$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`user_id` = $user_id)");

    return $request;	
}

// Update Advanced Account Data
if( WP_DEBUG && WP_DEBUG_DISPLAY && (defined('DOING_AJAX') && DOING_AJAX) ){
    @ ini_set( 'display_errors', 1 );
}
if (wp_doing_ajax()) {
    add_action('wp_ajax_send_advanced_account_data', 'send_advanced_account_data');
    add_action('wp_ajax_nopriv_send_advanced_account_data', 'send_advanced_account_data');
}
function send_advanced_account_data(){
    global $wpdb, $current_user;
    $id = $current_user->ID;
    $table_name = $wpdb->prefix . 'user_advanced_data';
    $created = $wpdb->get_results("SELECT * FROM $table_name WHERE (`user_id` = $id)");

	$photo_permalink = filter_var($_POST['photo'], FILTER_VALIDATE_URL);
	$bannr_permalink = filter_var($_POST['banner'], FILTER_VALIDATE_URL);

    $banner   = $_POST['banner'] != $bannr_permalink ? $_POST['banner'] : null;
    $photo    = $_POST['photo'] != $photo_permalink ? $_POST['photo'] : null;
    $email    = $_POST['email'] ? $_POST['email'] : null;
    $description = $_POST['description'] ? $_POST['description'] : null;
    $web      = $_POST['web'] ? $_POST['web'] : null;
	$nickname = $_POST['nickname'] ? $_POST['nickname'] : time();

	update_user_meta( $id, 'nickname', $nickname );
	wp_update_user( array(
		'ID'            => $id,
		'user_nicename' => $nickname
	) );

    if ($created) {
        $wpdb->update(
            $table_name,
            [
                'banner' => $banner,
                'avatar' => $photo,
                'email' => $email,
                'description' => $description,
                'web' => $web
            ],
            [
                'ID' => $created[0]->id
            ]
        );
    } else {
        $wpdb->insert($table_name, [
            'user_id' => $id,
            'banner' => $banner,
            'avatar' => $photo,
            'email' => $email,
            'description' => $description,
            'web' => $web
        ]);
    }

    if (wp_doing_ajax()) {
        echo true;
        wp_die();
    } else {
        echo false;
    }
}

// Remove checkout fields
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );
function wc_remove_checkout_fields( $fields ){
	unset( $fields['order']['order_comments'] );
	// Billing fields
	unset( $fields['billing']['billing_company'] );
	unset( $fields['billing']['billing_state'] );
	unset( $fields['billing']['billing_address_1'] );
	unset( $fields['billing']['billing_address_2'] );
	unset( $fields['billing']['billing_city'] );
	unset( $fields['billing']['billing_postcode'] );
	unset( $fields['billing']['billing_phone'] );
	unset( $fields['billing']['billing_country'] );
	return $fields;
}

// Remove Item Request
add_action('wp_ajax_nopriv_remove_item_req_form', 'remove_item_req_form_ajax_form');
add_action('wp_ajax_remove_item_req_form', 'remove_item_req_form_ajax_form');
function remove_item_req_form_ajax_form()
{
	global $wpdb, $post, $current_user;

	$table_name = $wpdb->prefix . 'admin_notifications';

	$item_id = base64_decode($_POST['item_id']);

	$subject = $_POST['subject'];
	$user_id = $_POST['user_id'];
	$message = $_POST['message'];
	$status = 4; // 1 - responded, 2 - readed, 3 - closed, 4 - new

	if ( !empty($message) ) {
		$wpdb->insert($table_name, [
			'user_id' => $user_id,
			'subject' => $subject . ' [Item ID: ' . $item_id . ']',
			'message' => $message,
			'date' => date('Y-m-d H:i:s'),
			'status' => $status
		]);
		$response = true;
	} else {
		$response = false;
	}

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo $response;
		wp_die();
	}
}