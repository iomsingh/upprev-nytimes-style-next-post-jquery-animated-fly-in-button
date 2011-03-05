<?php
/*
Plugin Name: upPrev Previous Post Animated Notification
Plugin URI: http://item-9.com/upPrev/
Description: When scrolling post down upPrev will display a flyout box with a link to the previous post from the same category. <a href="options-general.php?page=upprev">Options configuration panel</a>
Author: Jason Pelker, Grzegorz Krzyminski
Version: 1.4.0
Author URI: http://item-9.com/
*/

global $upprev_currentPostID, $upprev_is_single, $upprev_added;

include('upprev_settings.php');

function upprev_box() {
    //rewind posts;
    global $post, $upprev_currentPostID, $upprev_is_single, $upprev_added;
    $post = get_post($upprev_currentPostID);
    setup_postdata(get_post($upprev_currentPostID));
    if (!$upprev_added && $upprev_is_single && get_adjacent_post(true, '', true)) {
        $options = get_option("upprev-settings-group");
        $excerpt_length = $options["upprev_excerpt_length"] != '' ? $options["upprev_excerpt_length"] : 20;
        $display_excerpt = $options['upprev_content_excerpt'];
        $display_thumb = $options['upprev_content_thumb'];
        $catIDs = array();
        foreach((get_the_category()) as $category) {
            $catIDs[] = $category->cat_ID;
        }       
        $args = array(
            "numberposts" => -1,
            "category" => implode(',',$catIDs),
            "orderby" => "date",
            "order" => "DESC"
        );
        $posts = get_posts($args);
        $i = 0;
        foreach($posts as $row){
            $i++;
            if ($row->ID == get_the_ID())
                break;
        }

        echo "<div id='upprev_box'>\n\t<h6>\n\t\tMore in ";
        the_category(', ');
        echo "<span class='num'> ($i of " . count($posts) . " articles)</span>\n\t</h6>\n\t";
        echo "<div class='upprev_excerpt'>\n\t\t";
        if ($display_thumb)
            echo "<a href='".get_permalink($posts[$i]->ID)."' title='".$posts[$i]->post_title."'>". get_the_post_thumbnail($posts[$i]->ID,array(48,48),array('title'=>$posts[$i]->post_title,'class'=>'upprev_thumb')) . "</a>\n\t\t";
        echo "<p>\n\t\t\t";
        previous_post_link('%link','%title', true);
        if ($display_excerpt) {
            $content = preg_replace('/<[^>]*>/s','',$posts[$i]->post_content);
            $all_words = preg_split("/\s+/", $content);
            $content = implode(' ', array_slice($all_words, 0, $excerpt_length))." ...";
            echo "<br/>\n\t\t\t$content";
        }
        echo "\n\t\t</p>\n\t</div>\n\t";
        echo "<button id='upprev_close' type='button'>Close</button>\n</div><!-- #upprev_box -->\n";
    }
}
add_action('wp_footer', 'upprev_box');

function upprev_shortcode( $atts, $content = null ) {
    global $upprev_added;
    $upprev_added = true;
    return '<div id="upprev_box">'.$content.'<button id="upprev_close" type="button">Close</button></div>';
}
add_shortcode( 'upprev', 'upprev_shortcode' );

function upprev_cache() {
    global $upprev_currentPostID, $upprev_is_single;
    if (is_single()) {
        $upprev_currentPostID = get_the_ID();
        $upprev_is_single = is_single();
    }
}
add_action('the_post', 'upprev_cache');

function upprev_init() {
    $plugin_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
    wp_enqueue_script("jquery");
    wp_enqueue_script("upprev-js",$plugin_path.'upprev_js.php');
    wp_enqueue_style("upprev-css",$plugin_path.'upprev.css');
}
add_action('init', 'upprev_init');

function upprev_styles() {
    $options = get_option("upprev-settings-group");
    $position = $options['upprev_position'] != 'left' ? "right" : "left";
    if ($options['upprev_animation'] == "fade") {
        echo "<style type='text/css'>#upprev_box {display:none;$position: 0px;}</style>\n";
    } else {
        echo "<style type='text/css'>#upprev_box {display:block;$position: -400px;}</style>\n";
    }
}
add_action('wp_print_styles', 'upprev_styles')

?>
