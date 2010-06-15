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
                "upprev_offset" => $_POST["upprev_offset"]
		);
	update_option("upprev-settings-group", $options);
	echo '<div id="message" class="updated fade"><p>upPrev options saved.</p></div>';
    } else {
        $options = get_option("upprev-settings-group");
    }
	// Configuration Page
?>

<div class="wrap">
    <h2>upPrev</h2>
    <p>You can change the style of animation by choosing different option.</p>

    <form method="post" action="">
        <?php settings_fields( 'upprev-settings-group' ); ?>

        <table class="form-table">
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
                    <input type="text" id="offset" name="upprev_offset" value="<?php echo $options['upprev_offset'] == "" ? '100' : $options['upprev_offset']; ?>" maxlength="3" size="3" />%
                    <span class="description" style="margin-left:15px;">Percent of the page required to be scrolled to display a box.</span>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" name="info_update" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>

    </form>
</div>
<?php } ?>