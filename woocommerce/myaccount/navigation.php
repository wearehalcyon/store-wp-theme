<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

global $current_user;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$user = wp_get_current_user();

$has_messages = get_new_messages();
?>

<nav class="woocommerce-MyAccount-navigation">
	<ul class="account_nav">
		<li><?php echo $has_messages ? '<span class="new_message"></span>' : false; ?><a href="<?php echo home_url('/account/msg/'); ?>">Messages</a></li>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="start_saler">
		<?php if ($user->roles[0] != 'manufacturer') : ?>
			<?php
				$request_data = get_manufacturer_request($current_user->id);
				if (!$request_data && $request_data[0]->conclusion != 'rejected') :
			?>
				<a href="#become_manufacturer" class="button-light get_become_manufacturer">Become Manufacturer</a>
			<?php elseif ($request_data && $request_data[0]->conclusion == 'approved') : ?>
				<div class="already_sent_request approved">
					<p>
						You request approved!
						<br>
						Your account will get new privileges very soon.
					</p>
				</div>
			<?php else : ?>
				<div class="already_sent_request">
					<p>
						You already sent request. Please wait for response.
						<br>
						Request ID: <strong>#<?php echo $request_data[0]->public_id; ?></strong>
						<br>
						Status: <strong><?php echo ucfirst($request_data[0]->status); ?></strong>
					</p>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<span class="manu_badge">
				<img src="<?php echo THEME_URI . '/assets/images/ico-alert.svg' ?>" alt="Alert Icon">
				Manufacturer
			</span>
		<?php endif; ?>
	</div>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
