<?php
global $wpdb;

$id = $_GET['review'];

$table_name = $wpdb->prefix . 'become_manufacturer_requests';

$request = $wpdb->get_results("SELECT * FROM $table_name WHERE (`public_id` = $id)");

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo 'Review request #' . $request[0]->public_id; ?></h1>
    <h2><?php echo $request[0]->name; ?></h2>
    <p style="color: #999;"><?php echo date('F d, Y - H:i:s', strtotime($request[0]->date)); ?></p>
    <h4>Type: <?php echo $request[0]->type; ?></h4>
    <p style="font-size: 16px;"><?php echo $request[0]->message; ?></p>
    <h4>Demo Link: <a href="<?php echo $request[0]->demo_link; ?>" target="_blank"><?php echo $request[0]->demo_link; ?></a></h4>
    <form action="/wp-admin/admin.php?page=market-tools&uid=<?php echo $request[0]->user_id; ?>&review=<?php echo $request[0]->public_id; ?>&action=update" method="POST">
        <p>
            <h4>Reviewing Status</h4>
            <select name="status">
                <option value="pending" <?php echo $request[0]->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="reviewed" <?php echo $request[0]->status == 'reviewed' ? 'selected' : ''; ?>>Reviewed</option>
            </select>
        </p>
        <p>
            <h4>Conclusion</h4>
            <select name="conclusion">
                <option value="NaN" <?php echo $request[0]->conclusion == 'NaN' ? 'selected' : ''; ?>>Not Conclused</option>
                <option value="approved" <?php echo $request[0]->conclusion == 'approved' ? 'selected' : ''; ?>>Approved</option>
                <option value="rejected" <?php echo $request[0]->conclusion == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
            </select>
        </p>
        <p>
            <button type="submit" class="button button-primary">Update Review</button>
        </p>
        <p><a href="/wp-admin/admin.php?page=market-tools&delete=<?php echo $request[0]->public_id; ?>" id="remove-post-thumbnail">Delete this request</a></p>
    </form>
</div>