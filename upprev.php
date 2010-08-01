<?php
/*
Plugin Name: upPrev: NYTimes Style "Next Post" Animated Button
Plugin URI: http://item-9.com/upPrev/
Description: When scrolling upPrev will display a flyout box with a link to the previous post from the same category. <a href="options-general.php?page=upprev">Options configuration panel</a>
Author: Jason Pelker, Grzegorz Krzyminski
Version: 1.3.3
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
        $all_posts = array();
        $all_posts_str;
        // checking the order of the post in post's categories
        foreach((get_the_category()) as $category) {
            $posts = get_posts('category='.$category->cat_ID);
            foreach($posts as $post){
                if (!in_array($post->ID, $all_posts)) {
                    $all_posts[] = $post->ID;
                    $all_posts_str .= $post->ID . ' ';
                }
            }
        }
        $all_posts_str = trim($all_posts_str);
        $posts_desc = get_posts('include='.$all_posts_str.',orderby=date,order=DESC');
        $i = 0;
        foreach($posts_desc as $post){
            $i++;
            if ($post->ID == get_the_ID())
                break;
        }

        echo '<div id="upprev_box"><h6>More in ';
        the_category(',');
        echo '<span class="num"> ('. $i . ' of ' . count($posts_desc) . ' articles)</span></h6>';
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
