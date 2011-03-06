=== Plugin Name ===

Contributors:      jpelker, gkrzyminski
Plugin Name:       upPrev Previous Post Animated Notification
Plugin URI:        http://item-9.com/upPrev/
Tags:              NYTimes, New York Times, Next Post, Previous Post, Notification, Box, jQuery, Animation, Animated, Featured
Author URI:        http://item-9.com/upPrev/
Author:            Grzegorz Krzyminski
Donate link:       http://gkrzyminski.pl/
Requires at least: 2.7 
Tested up to:      3.1
Stable tag:        1.4.0
Version:           1.4.0

== Description ==

We've created a WordPress Plugin to emulate the “Next Post” buttons you see once you scroll to the bottom of New York Times web articles.

Video: http://www.youtube.com/watch?v=ZTrQGhWhCKs

Just like the NYTimes button, upPrev allows WordPress site admins to provide the same functionality for their readers. When a reader scrolls to the bottom of a single post, a button animates in the page’s bottom right corner, allowing the reader to select the next available post in the single post’s category (the category is also clickable to access an archive page). If no next post exists, no button is displayed.

== Installation ==

1. Upload upPrev to your plugins directory, then activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1. screenshot-1.png

== Changelog ==

= 1.0 =
First release.

= 1.1 =
Bug fixes. Animation option menu.

= 1.2 =
Fix to allow folder to be renamed.

= 1.3 =
Bug fixes. Option to bring out the animation higher on the page added.

= 1.3.2 =
Option to bring out the animation before specified HTML element.

= 1.3.3 =
Bug fixes. Make the plugin to work even if the HTML element was not found.

= 1.3.4 =

Bug fixes. Resolved jQuery incompatibility issue and corrected number of posts in categories.

= 1.4.0 =

- Fixed incorrectly shown number of posts (incorrect mysql query),
- Resolved jQuery compatibility issue,
- Improved stylesheet mechanism. One external global stylesheet + embedded one for a custom animation. Additional css selectors for easier modification.
- Modified settings page,
- Ability to add thumbnails and excerpt,
- Custom notification for pages with a shortcode [upprev]Sample Text[/upprev],
- Disabled PHP errors notification for a javascript file.

== Frequently Asked Questions ==

= Where can I customize fonts, colors, etc.? =

You can modify all css properties by edditing upprev.css

= How to add some space after upPrev? =

You can edit upprev.css and change bottom:0px; to different value, e.g. bottom:30px;

= How to add upPrev for pages? =

You can display a custom text by adding a shortcode to your page: [upprev]Sample HTML Text[/upprev]. When added to post it will replace a default content.