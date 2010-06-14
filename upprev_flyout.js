function getScrollY() {
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
        var lastScreen = getScrollY() + $j(window).height() < $j(document).height() ? false : true;
        if (lastScreen && !upprev_closed) {
            $j("#upprev_box").stop().animate({right:"0px"});
            upprev_hidden = false;
        }
        else if (upprev_closed && getScrollY() == 0) {
            upprev_closed = false;
        }
        else if (!upprev_hidden) {
            upprev_hidden = true;
            $j("#upprev_box").stop().animate({right:"-400px"});
        }
    });
    $j("#upprev_close").click(function() {
        $j("#upprev_box").stop().animate({right:"-400px"});
        upprev_closed = true;
        upprev_hidden = true;
    });
});