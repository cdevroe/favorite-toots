=== Mastodon Favorites ===
Contributors:      cdevroe
Tags:              block, mastodon, shortcode
Tested up to:      6.4
Stable tag:        0.1.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

This plugin should be considered beta. Please send bug reports, feedback, and questions to GitHub or on Mastodon.

Add a list of your favorite toots on Mastodon to any page on your website using a block or shortcode.

== Description ==

Add a list of your favorite toots on Mastodon to any page on your website using a block or shortcode.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cdevroe-mastodon-favorites` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= How do I determine my Mastodon instance URL? =

Your Mastodon instance URL is usually the domain name that appears in your username. For example, my Mastodon username is [@cdevroe@mastodon.social](https://mastodon.social/@cdevroe) so my instance URL is mastodon.social.

= Where do I get an Mastodon API key? =

1. Log into your Mastodon instance.
2. Click Preferences > Development
3. Choose "New application"
4. Application name: Mastodon Favorites WordPress
5. Application Website: Your website URL
6. Redirect URI: (leave as-is)
7. Scopes: read:bookmarks read:favourites read:statuses
8. Click Save.
9. Copy and paste your "Access Token" into the settings of your Mastodon Favorites plugin.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1.0 =
* Release

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above. This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation." Arbitrary sections will be shown below the built-in sections outlined above.
