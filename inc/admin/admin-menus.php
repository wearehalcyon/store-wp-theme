<?php
add_action('admin_menu', 'become_manufacturer_adminpage');
function become_manufacturer_adminpage()
{
    add_menu_page(
        'Become Manufacturer Requests',
        'Market Tools',
        'manage_options',
        'market-tools',
        'become_manufacturer_adminpage_callback',
        'dashicons-admin-site-alt3',
        2
    );
}

// add_action('admin_menu', 'become_manufacturer_submenu_adminpage');
// function become_manufacturer_submenu_adminpage() {
// 	add_submenu_page(
// 		'market-tools',
// 		'Become Manufacturer Requests',
// 		'Become Manufacturer Requests',
// 		'manage_options',
// 		'become-manufacturer-requests',
// 		'my_custom_submenu_page_callback'
// 	);
// }

function become_manufacturer_adminpage_callback()
{
    global $wpdb;

    $id = $_GET['review'];
    $delid = $_GET['delete'];

    $table_name = $wpdb->prefix . 'become_manufacturer_requests';

    if (isset($_GET['page']) == 'market-tools' && !isset($_GET['review']) && !isset($_GET['delete'])) {
        require 'pages/page-become-manufacturer.php';
    } elseif (isset($_GET['delete'])) {
        $wpdb->delete( $table_name, [
                'public_id' => $delid
            ],
            [ '%d' ]
        );
        return wp_safe_redirect('/wp-admin/admin.php?page=market-tools', 301);
    } elseif (isset($_GET['review']) && isset($_GET['action'])) {
        $wpdb->update(
            $table_name,
            [
                'status' => $_POST['status'],
                'conclusion' => $_POST['conclusion']
            ],
            [
                'public_id' => $id
            ]
        );
        return wp_safe_redirect('/wp-admin/admin.php?page=market-tools', 301);
    } elseif (isset($_GET['page']) == 'market-tools' && isset($_GET['review'])) {
        require 'pages/page-become-manufacturer-review.php';
    }
}
