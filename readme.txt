=== Favorite Toots ===
Contributors:      cdevroe
Tags:              block, mastodon, shortcode
Tested up to:      6.4
Stable tag:        0.2.2
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

**This plugin should be considered beta.**

Add a list of your favorite toots on Mastodon to any page on your website using a block.

== Description ==

Add a list of your favorite toots on Mastodon to any page on your website using a block.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cdevroe-favorite-toots` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= How do I determine my Mastodon instance URL? =

Your Mastodon instance URL is usually the domain name that appears in your username. For example, my Mastodon username is [@cdevroe@mastodon.social](https://mastodon.social/@cdevroe) so my instance URL is mastodon.social.

= Where do I get an Mastodon API key? =

1. Log into your Mastodon instance.
2. Click Preferences > Development
3. Choose "New application"
4. Application name: Favorite Toots WordPress
5. Application Website: Your website URL
6. Redirect URI: (leave as-is)
7. Scopes: read:bookmarks read:favourites read:statuses
8. Click Save.
9. Copy and paste your "Access Token" into the settings of your Mastodon Favorites plugin.

= Where can I provide feedback? =

I welcome feedback, code, and feature suggestions! You can submit a thread to the WordPress Support Forums or on GitHub has an issue.

== Screenshots ==

1. Coming soon

== Changelog ==

= 0.2.2 =
* Renamed to Favorite Toots

= 0.2.1 =
* Added nonce check to cache buster during Block settings update

= 0.2.0 =
* Multiple instances of the block will now cache independently
* Updating a Mastodon Favorites Block's settings will destroy that instance of the Block's cache
* Updated the text-domain per WordPress.org "Plugin Check" test results.
* Fixed temporary Editor Block icon SVG
* New styling for Editor Block in the Editor

= 0.1.0 =
* Release

== About this Plugin ==

One of the primary ways I find new accounts to follow on social media is by eavesdropping on
other people’s favorites. Many social networks make each account’s favorites public but
Mastodon does not (yet?). So I wanted a way to show my favorites publicly so that others can
look through them. And I’m hoping others make theirs available too. - [Colin Devroe](https://cdevroe.com/)
