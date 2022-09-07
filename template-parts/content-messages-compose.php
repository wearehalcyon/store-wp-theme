<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package INTAKE_DIgital
 */
global $post, $current_user;

$args = array(
    'role__in'    => ['manufacturer', 'customer'],
    'orderby' => 'display_name',
    'order'   => 'ASC',
    'exclude' => [$current_user->ID]
);
$users_list = get_users( $args );

if (isset($_GET['manu'])) {
    if (get_author_name( $_GET['manu'] )) {
        $manu_name = '<span style="font-weight: 600;">' . get_author_name( $_GET['manu'] ) . '</span>';
    } else {
        $manu_name = '<span style="color: #f00; font-weight: 600;">ERROR - ACCOUNT WITH THIS ID IS NOT FOUND!</span>';
    }

    if ($_GET['manu'] != 1) {
        $manu_id = $_GET['manu'];
    } else {
        $manu_id = false;
    }
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header messenger_header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">← Back to my account</a>
	</header><!-- .entry-header -->
    <div class="messenger_row compose">
        <div class="compose_message_form">
            <div class="loading_spiner">
                <img src="<?php echo THEME_URI . '/assets/images/loading-spiner.svg' ?>" alt="Spiner">
            </div>
            <div class="messages_alerts">
                <span class="message sent">Success! Your message was sent. <a href="<?php echo home_url('/account/msg/?area=sent'); ?>">Check your sent messages</a>.</span>
                <span class="message notsent">Error! Your message was not sent. Please check form data and try again.</span>
            </div>
            <form action="" method="post" class="compose_message_form_container">
                <p class="formcontrol">
                    <input type="hidden" value="<?php echo $current_user->ID; ?>" class="sender_id">
                    <label>
                        <strong>User ID<?php echo $manu_id ? ' <span style="display: block; font-size: 14px; font-weight: 400; margin-bottom: 10px;">Added automatically from redirect request. Current ID is ' . $manu_id . ' and you will send message to ' . $manu_name . '</span>' : null; ?></strong>
                        <input type="user_id" name="user_id" placeholder="Example: 110" class="user_id" value="<?php echo $manu_id; ?>" required>
                    </label>
                </p>
                <div class="compose_user_list">
                    <h5>Or choose from list</h5>
                    <div class="compose_user_items">
                        <input type="text" name="find_account" class="find_account" placeholder="Type to search...">
                        <ul>
                            <?php foreach($users_list as $users_item): ?>
                                <li>
                                    <a href="#" data-id="<?php echo $users_item->ID; ?>" data-name="<?php echo $users_item->display_name; ?>" ><?php echo $users_item->display_name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <p class="formcontrol">
                    <textarea name="message"rows="5" placeholder="Your message..." class="message" required></textarea>
                </p>
                <p class="formcontrol submit">
                    <a href="<?php echo wc_get_page_permalink( 'myaccount' ) . 'msg/'; ?>" class="button cancel">Back to messages</a>
                    <button type="submit" class="button">Send Message</button>
                </p>
            </form>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
