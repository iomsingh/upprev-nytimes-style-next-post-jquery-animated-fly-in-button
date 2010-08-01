<?php
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

var $j = jQuery.noConflict();

$j(function(){
    var upprev_closed = false;
    var upprev_hidden = true;
    $j(window).scroll(function() {
        ';

if ($offset_element) {
    print 'var lastScreen;
        if ($j("'. $element_selector .'").length > 0)
            lastScreen = getScrollY() + $j(window).height() < $j("'. $element_selector .'").offset().top * '. $offset / 100 .' ? false : true;
        else
            lastScreen = getScrollY() + $j(window).height() < $j(document).height() * '. $offset / 100 .' ? false : true;';
} else {
    print 'var lastScreen = getScrollY() + $j(window).height() < $j(document).height() * '. $offset / 100 .' ? false : true;';
}
    print '
        if (lastScreen && !upprev_closed) {
            ';
if ($animation == "fade")
    print '$j("#upprev_box").fadeIn("slow");';
else
    print '$j("#upprev_box").stop().animate({right:"0px"});';
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
    print '$j("#upprev_box").fadeOut("slow");';
else
    print '$j("#upprev_box").stop().animate({right:"-400px"});';
print '
        }
    });
    $j("#upprev_close").click(function() {
        ';
if ($animation == "fade")
    print'$j("#upprev_box").fadeOut("slow");';
else
    print'$j("#upprev_box").stop().animate({right:"-400px"});';
print '
        upprev_closed = true;
        upprev_hidden = true;
    });
});';

?>
