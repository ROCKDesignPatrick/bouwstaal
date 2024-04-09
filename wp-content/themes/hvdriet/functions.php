<?php
// Functions generating assets files main.css and main.js
require "functions/generate_files.php";

/* ========Uitzetten Gutenberg======== */
add_filter('use_block_editor_for_post', '__return_false', 10);
// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
// Disables the block editor from managing widgets.
add_filter('use_widgets_block_editor', '__return_false');

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
}
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

// ADD MENU
add_action('init', 'rockdesign_custom_menus');
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

function rockdesign_custom_menus()
{
    register_nav_menus(array(
        'mainnav'   => 'Hoofdmenu',
        'usernav'   => 'Gebruikermenu',
    ));
}

// ADD WOOCOMMERCE SUPPORT
add_theme_support('woocommerce');

add_action('wp_ajax_increment_post_views', 'increment_post_views');

// Function to increment post views count
function increment_post_views($post_id)
{
    if (wp_doing_ajax()) {
        $post_id = $_POST['data'];
        message_status($_POST['data']);
    }

    // Get current user ID
    $iCurrentUserID = get_current_user_id();

    // Get data form post
    $sPostViewsByUserID = get_post_meta($post_id, 'post_views_by_user_id', true);

    $aUserIDs = explode(',', $sPostViewsByUserID);

    if (!in_array($iCurrentUserID, $aUserIDs)) {
        $aUserIDs[] .= $iCurrentUserID;
    }

    $sPostViewsByUserIDNew = implode(',', $aUserIDs);

    // Update post meta with updated user IDs
    update_post_meta($post_id, 'post_views_by_user_id', $sPostViewsByUserIDNew);
}

// Hook to increment post views count when the post is viewed
function track_post_views()
{
    if (is_single()) {
        global $post;
        if ($post) {
            increment_post_views($post->ID);
        }
    }
}
add_action('wp_head', 'track_post_views');

// Function to get unread messages for current user
function get_unread_messages_counter($type)
{
    // Get current user ID
    $iCurrentUserID = get_current_user_id();

    $args = array(
        'post_type' => $type,
        'posts_per_page' => -1,
        'fields' => 'ids'
    );

    // Fetch all posts
    $query = new WP_Query($args);

    if ($query->posts) {
        // Counter for unread posts
        $unread_posts_count = 0;

        foreach ($query->posts as $iPostID) {
            $post_views_by_user_id = get_post_meta($iPostID, 'post_views_by_user_id', true);
            if (empty($post_views_by_user_id) || !in_array($iCurrentUserID, explode(',', $post_views_by_user_id))) {
                // If the user has not read the post, increment the unread posts count
                $unread_posts_count++;
            }
        }

        return $unread_posts_count;
    }
}


// Function to determine if user has read message
function message_status($post_id)
{
    // Get current user ID
    $iCurrentUserID = get_current_user_id();

    $sPostViewsByUserID = get_post_meta($post_id, 'post_views_by_user_id', true);

    $aUserIDs = explode(',', $sPostViewsByUserID);

    if (!in_array($iCurrentUserID, $aUserIDs)) {
        $sMessageStatus = 'unread';
    } else {
        $sMessageStatus = 'read';
    }

    return $sMessageStatus;
}

add_action('publish_post', 'send_email_on_post_publish', 10, 2);

// Function to send mail to predefined recipients
function send_email_on_post_publish($ID, $post)
{
    $post_title = $post->post_title;
    $post_permalink = get_permalink($ID);

    // Email subject
    $subject = 'New post published: ' . $post_title;

    // Email body
    $message = 'A new post has been published on our site:' . "\n\n";
    $message .= 'Title: ' . $post_title . "\n\n";
    $message .= 'Read it here: ' . $post_permalink;

    $recipient = get_field('ontvangers', $ID);
    $specificRecipients = get_field('medewerkers', $ID);

    if ($recipient == 'employees') {
        $users = get_users([
            'role' => 'subscriber',
        ]);
    }
    if ($recipient == 'employee') {
        $users = get_users([
            'role' => 'subscriber',
            'include' => $specificRecipients
        ]);
    }

    foreach ($users as $user) {
        //wp_mail($user->data->user_email, $subject, $message);
        wp_mail('info@rockdesign.nl', $subject, $message);
    }
}


remove_role('editor');
remove_role('contributor');
remove_role('author');

// Change role name
function change_role_name()
{
    global $wp_roles;

    if (!isset($wp_roles)) {
        $wp_roles = new WP_Roles();
    }

    $wp_roles->roles['subscriber']['name'] = 'Medewerker';
    $wp_roles->role_names['subscriber'] = 'Medewerker';
}
add_action('init', 'change_role_name');



add_action('template_redirect', 'redirect_to_specific_page');
function redirect_to_specific_page()
{
    if (!is_user_logged_in()) {
        auth_redirect();
        exit;
    }
}

add_filter('login_redirect', 'custom_redirect_after_login_subscriber', 10, 3);
function custom_redirect_after_login_subscriber($redirect_to)
{
    if (!current_user_can('subscriber') && !is_admin()) {
        $redirect_to = '/';
    }

    return $redirect_to;
}



add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
