<?php
function user_voting_form() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $device = get_device_type();
    $voted = check_if_voted($ip, $device);

    if ($voted) {
        echo 'You have already voted from this device and IP address.';
    } else {
        echo '
        <form action="" method="post">
            <input type="submit" name="vote" value="Vote">
        </form>
        ';

        if (isset($_POST['vote'])) {
            add_vote($ip, $device);
            echo 'Thank you for your vote!';
        }
    }
}

function get_device_type() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($user_agent, 'Mobile') !== false) {
        return 'Mobile';
    } elseif (strpos($user_agent, 'Tablet') !== false) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}

function check_if_voted($ip, $device) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_voting';
    $voted = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE ip = '$ip' AND device = '$device'");

    return $voted > 0;
}

function add_vote($ip, $device) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_voting';
    $wpdb->insert($table_name, array('ip' => $ip, 'device' => $device));
}

add_shortcode('user_voting', 'user_voting_form');

register_activation_hook(__FILE__, 'user_voting_install');

function user_voting_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_voting';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        ip varchar(50) NOT NULL,
        device varchar(20) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function user_voting_menu_page(){
	add_menu_page( 
		'Voting System',
		'Voting System',
		'manage_options',
		'voting-system',
		'voting_system_menu_page_func',
		'dashicons-thumbs-up',
		6
	); 
}
add_action( 'admin_menu', 'user_voting_menu_page' );


function voting_system_menu_page_func(){
    echo '
    <h3>Voting System</h3>
    <h4>You can use the shortcode [user_voting] in any post or page to display the users information</h4>
    ';
}

?>
