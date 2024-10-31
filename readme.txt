=== Postmark Test Settings ===
Contributors: chexwarrior
Tags: postmark, testing
Requires at least: 4.5
Requires PHP: 5.6
Tested up to: 5.0.2
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin enables testing functionality on the official Postmark WordPress plugin.

== Description ==

This is a WordPress plugin that is meant to add test functionality to the [official Postmark WordPress plugin](https://wordpress.org/plugins/postmark-approved-wordpress-plugin/).  Currently, the plugin allows a site owner to override the default recipient of any email sent through wp-mail (and therefore Postmark). This allows safe testing of staging and development sites where email functionality may be expected to work, but not send emails to any real users.

== Installation ==

1. Download the plugin from this page.
2. Move the `postmark-test-settings` directory to your sites `wp-content/plugins` directory.
3. Activate the plugin through your Plugins admin page.

== Frequently Asked Questions ==

= Why not just add this functionality to a site's functions.php file? =

Because most WordPress sites are hacky enough as it is! At my job I manage a lot of WordPress sites and the last thing I want to do is add a hard-coded hack to each one, this plugin allows me to safely test each site in an automated fashion.

== Changelog ==

= 0.1.0 =
Initial plugin release.
