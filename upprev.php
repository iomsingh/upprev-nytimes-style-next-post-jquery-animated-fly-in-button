<?php
/*
Plugin Name: upPrev: NYTimes Style "Next Post" Animated Button
Plugin URI: http://item-9.com/upPrev/
Description: When scrolling upPrev will display a flyout box with a link to the previous post from the same category. <a href="options-general.php?page=upprev">Options configuration panel</a>
Author: Jason Pelker, Grzegorz Krzyminski
Version: 1.3.4
Author URI: http://item-9.com/
*/

global $upprev_currentPostID, $upprev_is_single;

include('upprev_settings.php');

function upprev_box() {
    //rewind_posts();
    global $post, $upprev_currentPostID, $upprev_is_single;
    $post = get_post($upprev_currentPostID);
    setup_postdata(get_post($upprev_currentPostID));
    if ($upprev_is_single && get_adjacent_post(true, '', true)) {
        $catIDs = "";
        foreach((get_the_category()) as $category) {
            $catIDs .= $category->cat_ID . ",";
        }
        $catIDs = substr($catIDs,0,-1);
        global $wpdb;
        $postIDs = $wpdb->get_results(
            "SELECT DISTINCT ID FROM
            $wpdb->term_relationships JOIN $wpdb->posts ON object_id = ID
            WHERE post_type = 'post' AND term_taxonomy_id IN ($catIDs)
            ORDER BY post_date DESC"
            );
        $i = 0;
        foreach($postIDs as $row){
            $i++;
            if ($row->ID == get_the_ID())
                break;
        }

        echo '<div id="upprev_box"><h6>More in ';
        the_category(', ');
        echo '<span class="num"> ('. $i . ' of ' . count($postIDs) . ' articles)</span></h6>';
        previous_post_link('%link','%title', true);
        echo '<button id="upprev_close" type="button">Close</button></div>';
    }
}
add_action('wp_footer', 'upprev_box');

function upprev_head() {
    unset($upprev_currentPostID);
    unset($upprev_is_single);
    $plugin_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
    $options = get_option("upprev-settings-group");
    $sufix = $options['upprev_animation'] == "fade" ? "fade" : "flyout";
    echo '<link rel="stylesheet" type="text/css" href="'. $plugin_path .'upprev_'. $sufix .'.css" />
    <script type="text/javascript" language="javascript" src="'. $plugin_path .'upprev_js.php"></script>';
}
add_action('wp_head', 'upprev_head');

function upprev_cache() {
    global $upprev_currentPostID, $upprev_is_single;
    if (is_single() && !isset($upprev_currentPostID)) {
        $upprev_currentPostID = get_the_ID();
        $upprev_is_single = is_single();
    }
}
add_action('the_post', 'upprev_cache');

function upprev_jquery() {
    wp_enqueue_script("jquery");
}
add_action('plugins_loaded', 'upprev_jquery');

?>
