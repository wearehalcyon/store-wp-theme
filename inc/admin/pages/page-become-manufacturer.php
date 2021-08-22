<?php
global $wpdb;

$table_name = $wpdb->prefix . 'become_manufacturer_requests';

$requests = $wpdb->get_results("SELECT * FROM $table_name");

$count = $wpdb->num_rows;
?>
<style>
    #the-list td.NaN strong{
        display: inline-block;
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 4px;
        color: #000;
        background-color: orange;
    }
    #the-list td.approved strong{
        display: inline-block;
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 4px;
        color: #fff;
        background-color: green;
    }
    #the-list td.rejected strong{
        display: inline-block;
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 4px;
        color: #fff;
        background-color: red;
    }
</style>
<div class="wrap">
    <h1 class="wp-heading-inline">Become Manufacturer Requests / Total requests: <?php echo $count; ?></h1>
    <table class="wp-list-table widefat fixed striped table-view-list posts" style="margin-top: 20px;">
        <thead>
            <tr>
                <th style="width: 20px;"><strong>#</strong></th>
                <th style="width: 40px;"><strong>ID</strong></th>
                <th><strong>Name</strong></th>
                <th><strong>Email</strong></th>
                <th><strong>Message</strong></th>
                <th style="width: 60px;"><strong>Type</strong></th>
                <th><strong>Demo Link</strong></th>
                <th style="width: 65px;"><strong>Status</strong></th>
                <th style="width: 80px;"><strong>Conclusion</strong></th>
                <th style="width: 140px;"><strong>Date</strong></th>
                <th style="width: 60px;"><strong>Actions</strong></th>
            </tr>
        </thead>

        <tbody id="the-list">
            <?php $i = 1; foreach ($requests as $request) : ?>
                <tr id="post-<?php echo $request->id; ?>" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                    <td>
                        <?php echo $i++; ?>
                    </td>
                    <td><?php echo $request->public_id; ?></td>
                    <td><strong><a href="/wp-admin/user-edit.php?user_id=<?php echo $request->user_id; ?>"><?php echo $request->name; ?></a></strong></td>
                    <td><a href="mailt:<?php echo $request->email; ?>"><?php echo $request->email; ?></a></td>
                    <td><?php echo wp_trim_words($request->message, 10, '...'); ?></td>
                    <td><em><strong><?php echo ucfirst($request->type); ?></strong></em></td>
                    <td><a href="<?php echo $request->demo_link; ?>" target="_blank"><?php echo $request->demo_link; ?></a></td>
                    <td><strong><?php echo ucfirst($request->status); ?></strong></td>
                    <td class="<?php echo $request->conclusion; ?>"><strong><?php echo $request->conclusion; ?></strong></td>
                    <td><?php echo date('F d, Y', strtotime($request->date)); ?></td>
                    <td><a href="/wp-admin/admin.php?page=market-tools&review=<?php echo $request->public_id; ?>"><strong>Review</strong></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot></tfoot>

    </table>
</div>