<?php
error_reporting(0);
header("Content-type: text/javascript");
if (file_exists("./wp-config.php")){include("./wp-config.php");}
elseif (file_exists("../wp-config.php")){include("../wp-config.php");}
elseif (file_exists("../../wp-config.php")){include("../../wp-config.php");}
elseif (file_exists("../../../wp-config.php")){include("../../../wp-config.php");}
elseif (file_exists("../../../../wp-config.php")){include("../../../../wp-config.php");}
elseif (file_exists("../../../../../wp-config.php")){include("../../../../../wp-config.php");}
elseif (file_exists("../../../../../../wp-config.php")){include("../../../../../../wp-config.php");}
elseif (file_exists("../../../../../../../wp-config.php")){include("../../../../../../../wp-config.php");}
elseif (file_exists("../../../../../../../../wp-config.php")){include("../../../../../../../../wp-config.php");}

$options = get_option("upprev-settings-group");
$offset = floatval($options['upprev_offset'] == "" ? 100 : $options['upprev_offset']);
$offset_element = $options['upprev_offset_element'];
$element_selector = $options['upprev_element_selector'];
$animation = $options['upprev_animation'] == "fade" ? "fade" : "flyout";
$position = $options['upprev_position'] != 'left' ? "right" : "left";

print 'function getScrollY() {
    scrOfY = 0;
    if( typeof( window.pageYOffset ) == "number" ) {
        scrOfY = window.pageYOffset;
    } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
        scrOfY = document.body.scrollTop;
    } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
        scrOfY = document.documentElement.scrollTop;
    }
    return scrOfY;
}

jQuery(function($){
    var upprev_closed = false;
    var upprev_hidden = true;
    $(window).scroll(function() {
        ';

if ($offset_element) {
    print 'var lastScreen;
        if ($("'. $element_selector .'").length > 0)
            lastScreen = getScrollY() + $(window).height() < $("'. $element_selector .'").offset().top * '. $offset / 100 .' ? false : true;
        else
            lastScreen = getScrollY() + $(window).height() < $(document).height() * '. $offset / 100 .' ? false : true;';
} else {
    print 'var lastScreen = getScrollY() + $(window).height() < $(document).height() * '. $offset / 100 .' ? false : true;';
}
    print '
        if (lastScreen && !upprev_closed) {
            ';
if ($animation == "fade")
    print '$("#upprev_box").fadeIn("slow");';
else
    print '$("#upprev_box").stop().animate({'.$position.':"0px"});';
print '
            upprev_hidden = false;
        }
        else if (upprev_closed && getScrollY() == 0) {
            upprev_closed = false;
        }
        else if (!upprev_hidden) {
            upprev_hidden = true;
            ';
if ($animation == "fade")
    print '$("#upprev_box").fadeOut("slow");';
else
    print '$("#upprev_box").stop().animate({'.$position.':"-400px"});';
print '
        }
    });
    $("#upprev_close").click(function() {
        ';
if ($animation == "fade")
    print'$("#upprev_box").fadeOut("slow");';
else
    print'$("#upprev_box").stop().animate({'.$position.':"-400px"});';
print '
        upprev_closed = true;
        upprev_hidden = true;
    });
});';

?>
