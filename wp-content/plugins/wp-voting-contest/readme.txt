=== WP Voting Contest ===
Contributors: mvincik
Tags: gallery, voting, contest, likes, photo
Requires at least: 4.0
Tested up to: 5.4
Requires PHP: 5.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Let users cast votes on your images/photos.

== Description ==
Simply let users vote photos/images in your Contests.

Installing and activating this plugin will place a vote button and a vote count below each photo of all contestants images using the [showcontestants id='category id'] shortcode.

= Online Demo =

You can try out the <a href="https://demo.ohiowebtech.com/" target="_blank">Online demonstration</a> to see how the plugin works.

To login, go to the <a href="https://demo.ohiowebtech.com/" target="_blank">Demo dashboard</a> and login with <strong>demo</strong> / <strong>demo</strong>.

= Support & Help =

For support, you can access our <a href="https://plugins.ohiowebtech.com/forum/wordpress-voting-photo-contest-plugin-1/">support forums</a> and post a question or a problem there.


== Installation ==
This section describes how to install the plugin and get it working.

1. Upload `photo-voting` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the \'Plugins\' menu in WordPress
3. Go to the Contest Category and create the Contest and the shortcode in the page [showcontestants id='category id'] to vote for the contestants

== Frequently Asked Questions ==
= What is Category ID =

Created Contest Category term ID is the Category ID to be used in the shortcode.

= What contest it supports =

It only supports the Photo/Image Contest.

== Screenshots ==
1. 1. Sample of a Contest image/photo with the vote button and vote count below each photo.

== Changelog ==

= 1.0 =
* Initial release

= 1.1 =
* Fixed the Registration Issues.

= 1.2 =
* Guttenburg Editor in the Contestants.
* Removed the Voting menu in the Edit and Add Contestant area because it conflicts with the editor.
* Admin Ajax fix.
* Support with Wordpress 5.
* Admin end CSS issue fixes.
* Deprecated the shortcode attribute - onlyloggedinuser.

= 1.3 =
* Fixed the issues for the premium version compatibility
* Image Issues fixed 
* Added Appropriate Hooks for the current Wordpress versions

= 1.4 =
* Fixed the Deprecated functions

= 1.5 =
* Non-numeric value encountered warning in first time view of contestants
* Voting Logs pagination Filtes & styles issues
* Style issuses admin end
* Issue fix in the Contestant title
* Removed the Google Plus Sharing 

= 1.6 =
* Fixed Image issue in GRID & List view
* Fixed the undefined issue while voting
* Fixed the PHP warnings

= 1.7 =
* Fixed the undefined js conflicts issue while voting

= 1.8 =
* Fixed the Multilingual Supports in the Plugin 
* Added New Translated Strings

= 1.9 =
* Fixed the Rules & Prizes in addcontestant shortcode

= 2.0 =
* Fixed Datepicker Issue in the Contest Category Settings
* Fixed the Showform in the showcontestants and addcontestants shortcode
* Fixed Admin Styles

= 2.1 =
* Login and Registration Issues


== Upgrade Notice ==
= 1.1 =
Upgrading to latest version will fix the Registration issues.


