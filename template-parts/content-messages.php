<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package INTAKE_DIgital
 */
global $post, $current_user;
$messages = get_messenger_data();
$current_userid = $current_user->ID;

// Messenger
function get_messenger_data(){
	global $wpdb, $current_user;

	$table_name = $wpdb->prefix . 'user_messages';

	$id = $current_user->ID;

	$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`user_id` = $id AND `deleted` = 0) ORDER BY `date` DESC");

	return $request;
}

function get_messenger_message($id = null, $hash = null, $user){
	global $wpdb, $current_user;

	$current_userid = $current_user->ID;

	if ( $user != $current_userid && !isset($_GET['area']) ) {
		return false;
	}

	$table_name = $wpdb->prefix . 'user_messages';

	$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`id` = $id AND `hash` = '$hash' AND `user_id` = $user)");

	return $request;
}

// Detect if message is read
add_action('wp_footer', 'is_messanger_ite_is_read', 99999);
function is_messanger_ite_is_read(){
	global $wpdb, $current_user;

	$current_userid = $current_user->ID;
	$user = $_GET['user'];
	$hash = $_GET['hash'];
	$msid = $_GET['msid'];

	if ( $user != $current_userid ) {
		return false;
	}

	$table_name = $wpdb->prefix . 'user_messages';

	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE (`id` = $msid AND `hash` = '$hash' AND `user_id` = $user)");

	$wpdb->update( $table_name,
		[ 'viewed' => 1 ],
		[ 'ID' => $results[0]->id ]
	);
}

function get_sent_messages(){
    global $wpdb, $current_user;

	$table_name = $wpdb->prefix . 'user_messages';

	$id = $current_user->ID;

	$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`sender_id` = $id AND `deleted` = 0) ORDER BY `date` DESC");

	return $request;
}

$sent_messages = get_sent_messages();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header messenger_header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">← Back to my account</a>
	</header><!-- .entry-header -->
    <div class="mailbox_menu">
        <ul>
            <li><a href="<?php echo get_the_permalink($post->ID); ?>"<?php echo !isset($_GET['area']) ? ' class="active"' : false; ?>>Inbox</a></li>
            <li><a href="<?php echo get_the_permalink($post->ID) . '?area=sent'; ?>"<?php echo isset($_GET['area']) == 'sent' ? ' class="active"' : false; ?>>Sent</a></li>
        </ul>
        <a href="<?php echo wc_get_page_permalink( 'myaccount' ) . 'msg/compose/'; ?>" class="compose_message button">Compose</a>
    </div>
    <div class="messenger_row">
        <div class="senderlist">
            <?php if (!isset($_GET['area'])) : ?>
                <!-- INBOX -->
                    <?php if ($messages) : ?>
                        <ul>
                            <?php
                                $i = 1;
                                $msid = 1;
                                $msidget = 1;
                                foreach($messages as $sender) :
                            ?>
                                <li class="message <?php echo $sender->deleted == 0 ? 'live' : 'deleted'; ?> message-<?php echo $sender->id; ?>">
                                    <?php if ($sender->deleted == 0) : ?>
                                        <?php
                                            if ( $sender->viewed == 0 ) {
                                                echo '<span class="new_message"></span>';
                                            }
                                        ?>
                                        <a href="<?php echo get_the_permalink($post->ID) . '?msid=' . $sender->id . '&hash=' . md5($sender->date) . '&user=' . $current_userid; ?>" class="<?php echo 'message_open_item msid-item msid-' . $sender->id;  ?>">
                                            <?php
                                                $sender_name = get_userdata($sender->sender_id);
                                                echo $sender_name->data->display_name;
                                            ?>
                                            <span><?php echo date('F d, Y - H:i', strtotime($sender->date)); ?></span>
                                        </a>
                                    <?php else : ?>
                                        <p class="deleted_message">
                                            This message was deleted by <strong><?php echo $current_userid == $sender->deleted_by ? 'you' : 'sender'; ?></strong>.
                                            <a href="#" data-id="<?php echo $sender->id; ?>" class="close_deleted_notiify">×</a>
                                        </p>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>No messages in your box</p>
                    <?php endif; ?>
                <!-- END INBOX -->
            <?php elseif (isset($_GET['area']) == 'sent') : ?>
                <!-- SENT -->
                <?php if ($sent_messages) : ?>
                    <ul>
                        <?php
                            $i = 1;
                            $msid = 1;
                            $msidget = 1;
                            foreach($sent_messages as $sender) :
                        ?>
                            <li class="message <?php echo $sender->deleted == 0 ? 'live' : 'deleted'; ?> message-<?php echo $sender->id; ?>">
                                <?php if ($sender->deleted == 0) : ?>
                                    <?php
                                        if ( $sender->viewed == 0 ) {
                                            echo '<span class="new_message unread"></span>';
                                        } else {
                                            echo '<span class="new_message read"></span>';
                                        }
                                    ?>
                                    <a href="<?php echo get_the_permalink($post->ID) . '?area=sent&msid=' . $sender->id . '&hash=' . md5($sender->date) . '&user=' . $sender->user_id; ?>" class="<?php echo $i++ . ' msid-item msid-' . $sender->id;  ?>">
                                        <?php
                                            $sender_name = get_userdata($sender->user_id);
                                            echo $sender_name->data->display_name;
                                        ?>
                                        <span><?php echo date('F d, Y - H:i', strtotime($sender->date)); ?></span>
                                    </a>
                                <?php else : ?>
                                    <p class="deleted_message">
                                        This message was deleted by <strong><?php echo $current_userid == $sender->deleted_by ? 'you' : 'sender'; ?></strong>.
                                        <a href="#" data-id="<?php echo $sender->id; ?>" class="close_deleted_notiify">×</a>
                                    </p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No messages in your box</p>
                <?php endif; ?>
                <!-- END SENT -->
            <?php endif; ?>
        </div>
        <div class="messenger_win">
            <?php
                $message = get_messenger_message($_GET['msid'], $_GET['hash'], $_GET['user']);
            ?>
            <div class="message_body">
                <?php if ($message && $message[0]->deleted == 0) : ?>
                    <div class="message_head">
                        <div class="message_info">
                            <div class="sender_name">
                                <?php
                                    $sender_name = get_userdata($message[0]->sender_id);
                                    echo '<strong>Sender: <span class="sender_name">' . $sender_name->data->display_name . '</span> at </strong><span class="sender_date">' . date('F d, Y - H:i:s', strtotime($message[0]->date)) . '</span>';
                                ?>
                            </div>
                            <div class="delete_message">
                                <a href="#" data-id="<?php echo $message[0]->id; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                                        <path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/>
                                        <path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="message_content">
                            <?php esc_html_e($message[0]->message); ?>
                        </div>
                    </div>
                    <?php if (!isset($_GET['area'])) : ?>
                        <div class="message_footer">
                            <strong><?php esc_html_e('Respond:'); ?></strong><?php esc_html_e('(Emoji unsupported)'); ?>
                            <form id="messenger_form" action="" method="post" class="respond">
                                <input class="messenger_sender_id" type="hidden" name="sender_id" value="<?php echo $current_userid; ?>">
                                <input class="messenger_user_id" type="hidden" name="user_id" value="<?php echo $message[0]->sender_id; ?>">
                                <div class="respcontrol textarea">
                                    <span class="sending_message_badge"><?php esc_html_e('Sending message...'); ?></span>
                                    <textarea name="respond" cols="30" rows="3" class="respond_txtarea" placeholder="Type your message..." required></textarea>
                                </div>
                                <div class="respcontrol send_button">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 448 448" style="enable-background:new 0 0 448 448;" xml:space="preserve">
                                            <polygon points="0.213,32 0,181.333 320,224 0,266.667 0.213,416 448,224   "/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="message_head">
                        <div class="message_content">
                            <?php esc_html_e('Select message to read.'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
