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
$offset_comments = $options['upprev_offset_comments'];
$comments_id = $options['upprev_comments_id'];
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

//$j(document).ready(function() {
    //document.write("bleh");
    //document.getElementById("comments").innerHTML = "bleh " + $j("#comments").offset().top;
//});

$j(function(){
    var upprev_closed = false;
    var upprev_hidden = true;
    $j(window).scroll(function() {
        ';

if ($offset_comments) {
    print 'var lastScreen = getScrollY() + $j(window).height() < $("#'. $comments_id .'").offset().top * '. $offset / 100 .' ? false : true;';
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
