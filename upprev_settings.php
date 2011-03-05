<?php

// Admin Panel
function upprev_add_pages() {
    add_options_page(__('upPrev','upprev'), __('upPrev','upprev'), 'manage_options', 'upprev', 'upprev_settings_page');
}
add_action('admin_menu', 'upprev_add_pages');


function upprev_settings_page() {
    if (isset($_POST['info_update'])) {
	$options = array(
		"upprev_animation" => $_POST["upprev_animation"],
                "upprev_offset" => $_POST["upprev_offset"],
                "upprev_offset_element" => $_POST["upprev_offset_element"],
                "upprev_element_selector" => $_POST["upprev_element_selector"],
                "upprev_position" => $_POST["upprev_position"],
                "upprev_content_excerpt" => $_POST["upprev_content_excerpt"],
                "upprev_content_thumb" => $_POST["upprev_content_thumb"],
                "upprev_excerpt_length" => $_POST["upprev_excerpt_length"]
		);
	update_option("upprev-settings-group", $options);
	echo '<div id="message" class="updated fade"><p>upPrev options saved.</p></div>';
    } else {
        $options = get_option("upprev-settings-group");
    }
	// Configuration Page
?>

<div class="wrap">
    <style type="text/css">
        #upprev-tabs-nav {
            overflow: hidden;
            border-bottom: 2px solid #aaa;
        }
        #upprev-tabs-nav li {
            float:left;
            display:inline;
            padding: 5px 10px;
            margin: 0 5px 0 0;
            cursor: pointer;
            font-weight: bold;
        }
        #upprev-tabs-nav li.current {
            background: #aaa;
            color:#fff;
        }
    </style>
    <script type="text/javascript">
        jQuery(function($){
            $("#upprev-tabs li:not(.current)").hide();
            $("#upprev-tabs-nav li").each(function(index,element) {
                $(element).click(function(){
                    $("#upprev-tabs li.current").removeClass("current").hide();
                    $("#upprev-tabs-nav li.current").removeClass("current");
                    $("#upprev-tabs li:eq("+index+")").addClass("current").show();
                    $("#upprev-tabs-nav li:eq("+index+")").addClass("current").show();
                })
            })
        })
    </script>
    <h2>upPrev<span style="font-size:0.8em; margin-left:10px; font-variant: small-caps">Previous Post Animated Notification</span></h2>
    <form method="post" action="">
        <p>Just like the NYTimes button, upPrev allows WordPress site admins to provide the same functionality for their readers. When a reader scrolls to the bottom of a single post, a button animates in the page’s bottom right corner, allowing the reader to select the next available post in the single post’s category (the category is also clickable to access an archive page). If no next post exists, no button is displayed.</p>
        <?php settings_fields( 'upprev-settings-group' ); ?>
        <ul id="upprev-tabs-nav">
            <li class="current">Settings</li>
            <li>FAQs</li>
        </ul>
        <ul id="upprev-tabs">
        <li class="current">
        <table class="form-table">
            <tr>
                <th colspan="2"><h3 style="margin:0">Appearance</h3></th>
            </tr>
            <tr valign="top">
                <th scope="row">Animation Style:</th>
                <td>
                    <input type="radio" id="flyout" name="upprev_animation" value="flyout" <?php if($options['upprev_animation'] != "fade") { echo 'checked="checked"';} ?>/>
                    <label for="flyout">Flyout</label><br/>
                    <input type="radio" id="fade" name="upprev_animation" value="fade" <?php if($options['upprev_animation'] == "fade") { echo 'checked="checked"';} ?>/>
                    <label for="fade">Fade In/Out</label>
                </td>                
            </tr>
            <tr>
                <th scope="row">
                    <label for="offset">Offset:</label>
                </th>
                <td>
                    <div style="margin-bottom:5px;">
                        <input type="text" id="offset" name="upprev_offset" value="<?php echo $options['upprev_offset'] == "" ? '100' : $options['upprev_offset']; ?>" maxlength="3" size="3" />%
                        <span class="description" style="margin-left:15px;">Percentage of the page required to be scrolled to display a box.</span>
                    </div>
                    <div>
                        <input type="checkbox" id="offset_element" name="upprev_offset_element" <?php echo $options['upprev_offset_element'] != true ? "" : 'checked="checked"'; ?> />
                        <label for="offset_element">Before HTML element.</label>
                        <label for="element_selector" >Element selector: </label><input type="text" id="element_selector" name="upprev_element_selector" value="<?php echo $options['upprev_element_selector'] == "" ? '#comments' : $options['upprev_element_selector']; ?>" /><br/>
                        <span class="description" >If not selected, all page length is taken for calculation. If selected, make sure to use the ID or class of an existing element. Put # "hash" before the ID, or . "dot" before a class name.</span>
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Position:</th>
                <td>
                    <input type="radio" id="upprev_position_right" name="upprev_position" value="right" <?php if($options['upprev_position'] != "left") { echo 'checked="checked"';} ?>/>
                    <label for="upprev_position_right">Right</label><br/>
                    <input type="radio" id="upprev_position_left" name="upprev_position" value="left" <?php if($options['upprev_position'] == "left") { echo 'checked="checked"';} ?>/>
                    <label for="upprev_position_left">Left</label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="offset"><h3 style="margin:0">Content</h3></label>
                </th>
                <td>
                    <div>
                        <input type="checkbox" id="upprev_content_excerpt" name="upprev_content_excerpt" <?php echo $options['upprev_content_excerpt'] != false ? 'checked="checked"' : ""; ?> />
                        <label for="upprev_content_excerpt">Excerpt.</label> <label for="upprev_excerpt_length" >Word limit: </label><input type="text" id="upprev_excerpt_length" name="upprev_excerpt_length" value="<?php echo $options['upprev_excerpt_length'] == "" ? '20' : $options['upprev_excerpt_length']; ?>" /><br/>
                        <input type="checkbox" id="upprev_content_thumb" name="upprev_content_thumb" <?php echo $options['upprev_content_thumb'] != false ? 'checked="checked"' : ""; ?> />
                        <label for="upprev_content_thumb">Thumbnail</label><br/>
                    </div>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" name="info_update" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
        </li>
        <li>
            <h4>Where can I customize fonts, colors, etc.?</h4>
            You can modify all css properties by edditing <a href="plugin-editor.php?file=<?php echo str_replace(basename( __FILE__),"",plugin_basename(__FILE__))."upprev.css" ?>">upprev.css</a>
            <h4>How to add some space after upPrev?</h4>
            You can edit <a href="plugin-editor.php?file=<?php echo str_replace(basename( __FILE__),"",plugin_basename(__FILE__))."upprev.css" ?>">upprev.css</a> and change bottom:0px; to different value, e.g. bottom:30px;
            <h4>How to add upPrev for pages?</h4>
            You can display a custom text by adding a shortcode to your page: <em>[upprev]Sample HTML Text[/upprev]</em>. When added to post it will replace a default content.
        </li>
        </ul>

    </form>
</div>
<?php } ?>