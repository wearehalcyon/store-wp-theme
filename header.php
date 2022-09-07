<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package INTAKE_DIgital
 */
$aad = get_advanced_account_data(get_current_user_id())[0];
if ( isset( $_GET['qcart'] ) == 'empty' ) {
	$redirect = home_url($_SERVER['REQUEST_URI']);
	WC()->cart->empty_cart();
	header('Location: ' . str_replace('?qcart=empty', '?status=cleared', $redirect));
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-pjax-version" content="v2">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); global $woocommerce; ?>
</head>

<body <?php body_class('id-store'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="logo">
			<a href="<?php echo home_url('/'); ?>">
				<img src="<?php echo THEME_URI . '/assets/images/logo.svg'; ?>" alt="<?php bloginfo('name'); ?>">
			</a>
		</div>
		<div class="search">
			<form role="search" id="searchform" class="searchform" action="<?php echo home_url('/'); ?>">
				<input type="text" name="s" id="results" value="<?php echo get_search_query(); ?>" placeholder="Search Item...">
				<button type="submit">
					<img src="<?php echo THEME_URI . '/assets/images/search.svg' ?>" alt="Search Icon">
				</button>
			</form>
		</div>
		<div class="account">
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">My Account</a>
				<?php if ($aad->avatar) : ?>
					<img class="top-pan-avatar top-pan-avatar-uploaded" src="<?php echo $aad->avatar; ?>" data-avatar="<?php echo get_template_directory_uri() . '/assets/images/no-avatar.svg'; ?>" alt="User Avatar">
				<?php else : ?>
					<img class="top-pan-avatar" src="<?php echo get_template_directory_uri() . '/assets/images/no-avatar.svg'; ?>" data-avatar="<?php echo get_template_directory_uri() . '/assets/images/no-avatar.svg'; ?>" alt="User Avatar Not Installed">
				<?php endif; ?>
			<?php else : ?>
				<a href="#signin" class="open_signin">Sign In</a>
			<?php endif; ?>
		</div>
	</header><!-- #masthead -->
	<aside class="sidebar">
		<?php
			wp_nav_menu([
				'theme_location' => 'aside',
				'menu_class' => false,
				'menu_id' => false,
				'container' => false
			]);
			if ($woocommerce->cart->cart_contents_count > 0) {
		?>
		<div class="bottom_menus">
			<ul class="cart_list">
				<li>
					<a href="#quick_cart">
						<span class="quick_cart_count"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 279 279" style="enable-background:new 0 0 279 279;" xml:space="preserve">
							<path d="M262.421,270.339L246.466,72.896C246.151,69.001,242.898,66,238.99,66h-42.833v-9.495C196.157,25.348,171.143,0,139.985,0  h-0.99c-31.157,0-56.838,25.348-56.838,56.505V66H39.99c-3.908,0-7.161,3.001-7.476,6.896l-16,198  c-0.169,2.088,0.543,4.15,1.963,5.689S21.897,279,23.99,279h231c0.006,0,0.014,0,0.02,0c4.143,0,7.5-3.357,7.5-7.5  C262.51,271.105,262.48,270.717,262.421,270.339z M97.157,56.505C97.157,33.619,116.109,15,138.995,15h0.99  c22.886,0,41.172,18.619,41.172,41.505V66h-84V56.505z"/>
						</svg>
					</a>
				</li>
			</ul>
		<?php
			}
			wp_nav_menu([
				'theme_location' => 'aside-bottom',
				'menu_class' => 'aside_bottom',
				'menu_id' => false,
				'container' => false
			]);
			echo '</div>';
		?>
	</aside>

	<?php if (is_front_page()) : ?>
		<section class="hero">
            <div class="title">
                <?php the_content(); ?>
                <div class="cta_button">
                    <?php if (!is_user_logged_in()) : ?>
                        <a href="#signin" class="open_signin">Get Started</a>
                    <?php else : $current_user = wp_get_current_user(); ?>
                        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>"><?php echo $current_user->display_name; ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
	<?php endif; ?>