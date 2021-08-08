<?php

/**
 * INTAKE DIgital functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package INTAKE_DIgital
 */

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
	wp_enqueue_style('intake-digital-main-style', get_template_directory_uri() . '/assets/css/app.css', array(), filemtime(__DIR__ . '/assets/css/app.css'));
	wp_style_add_data('intake-digital-style', 'rtl', 'replace');

	wp_enqueue_script('intake-digital-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('intake-digital-owl-slider', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), _S_VERSION, true);
	wp_enqueue_script('intake-digital-pjax', get_template_directory_uri() . '/assets/js/pjax.min.js', array('jquery'), _S_VERSION, true);
	wp_enqueue_script('intake-digital-app', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), filemtime(__DIR__ . '/assets/js/app.js'), true);

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

/**
 * Hide admin bar
 */
show_admin_bar(false);

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

	if (defined('DOING_AJAX') && DOING_AJAX) {
		echo true;
		wp_die();
	} else {
		echo false;
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
		'message' => $message,
		'viewed' => 0,
		'date' => date('m-d-Y H:i:s'),
		'hash' => md5(date('m-d-Y H:i:s'))
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
			'deleting_date' => date('m-d-Y H:i:s')
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

// Messenger request - delete
add_action('wp_ajax_nopriv_ajax_messenger_delete_notify', 'messenger_ajax_delete_notify_link');
add_action('wp_ajax_ajax_messenger_delete_notify', 'messenger_ajax_delete_notify_link');
function messenger_ajax_delete_notify_link()
{
	global $wpdb, $current_user;

	$id = $current_user->ID;

	$table_name = $wpdb->prefix . 'user_messages';

	$notify_id = $_POST['notify_id'];

	$wpdb->update(
		$table_name,
		[
			'deleted_notify' => 1,
		],
		[
			'ID' => $notify_id
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
			'message' => $message,
			'viewed' => 0,
			'deleted' => 0,
			'deleted_by' => null,
			'deleting_date' => null,
			'date' => date('m-d-Y H:i:s'),
			'hash' => md5(date('m-d-Y H:i:s'))
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
