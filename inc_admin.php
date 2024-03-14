<?php
/**
 * Functions used for the WordPress Admin Settings page
 */

function cdevroe_tootfaves_add_admin_menu() {
    if ( !is_admin() ) return;

    add_options_page(__('Favorite Toots','favorite-toots'), __('Favorite Toots','favorite-toots'), 'manage_options', 'favorite-toots', 'cdevroe_tootfaves_settings_page');
}
add_action( 'admin_menu', 'cdevroe_tootfaves_add_admin_menu' );

function cdevroe_tootfaves_settings_page() {
    ?>
    <div class="wrap">
        <h1>Mastodon Favorites Settings</h1>
        <p>Please enter your Mastodon Instance URL and Access Token to enable the Mastodon Favorites plugin. Without doing so, the Block will show "Mastodon Favorites currently unavailable.".</p>
        
        <form method="post" action="options.php">
            <?php
            settings_fields("cdevroe_tootfaves_options");
            do_settings_sections("cdevroe_tootfaves_options");
            submit_button();
            ?>
        </form>

        <h2 id="faq">Frequently Asked Questions</h2>

        <h3>How do I determine my Mastodon instance URL?</h3>
        <p>Your Mastodon instance URL is usually the domain name that appears in your username. For example, my Mastodon username is <a href="https://mastodon.social/@cdevroe" target="_blank">@cdevroe@mastodon.social</a> so my instance URL is mastodon.social.</p>

        <h3>Where do I get an Mastodon API key?</h3>
        <ol>
            <li>Log into your Mastodon instance.</li>
            <li>Click Preferences > Development</li>
            <li>Choose "New application"</li>
            <li>Application name: Mastodon Favorites WordPress</li>
            <li>Application Website: Your website URL</li>
            <li>Redirect URI: (leave as-is)</li>
            <li>Scopes: read:bookmarks read:favourites read:statuses</li>
            <li>Click Save.</li>
            <li>Copy and paste your "Access Token" into the settings of your Mastodon Favorites plugin.</li>
        </ol>
    </div>
    <?php
}

function cdevroe_tootfaves_settings_init(){
    register_setting("cdevroe_tootfaves_options", "cdevroe_tootfaves_access_token");
    register_setting("cdevroe_tootfaves_options", "cdevroe_tootfaves_instance_url");

    add_settings_section("cdevroe_tootfaves_section", "", null, "cdevroe_tootfaves_options");

    add_settings_field("cdevroe_tootfaves_instance_url", "Mastodon Instance URL", "cdevroe_tootfaves_display_instance_url", "cdevroe_tootfaves_options", "cdevroe_tootfaves_section");
    add_settings_field("cdevroe_tootfaves_access_token", "Mastodon Access Token", "cdevroe_tootfaves_display_access_token", "cdevroe_tootfaves_options", "cdevroe_tootfaves_section");
    
}
add_action('admin_init', 'cdevroe_tootfaves_settings_init');

function cdevroe_tootfaves_display_access_token() {
    ?>
    <input type="text" name="cdevroe_tootfaves_access_token" id="cdevroe_tootfaves_access_token" value="<?php echo get_option('cdevroe_tootfaves_access_token'); ?>" />
    <?php
}

function cdevroe_tootfaves_display_instance_url() {
    ?>
    <input type="text" placeholder="social.lol" name="cdevroe_tootfaves_instance_url" id="cdevroe_tootfaves_instance_url" value="<?php echo get_option('cdevroe_tootfaves_instance_url'); ?>" />
    <?php
}

// TODO: Can this be removed? Isn't the build process supposed to do this automatically since this file is reference in block.json?
function cdevroe_tootfaves_add_editor_styles() {
	global $pagenow;

	if ($pagenow != 'post.php') {
		return;
	}

    $cdevroe_tootfaves_data = get_plugin_data( __FILE__ );
	
	// loading css
    wp_register_style( 'favorite-toots-editor-style', plugin_dir_url( __FILE__ ) . '/assets/css/editor.css', false, $cdevroe_tootfaves_data['Version'] );
    wp_enqueue_style( 'favorite-toots-editor-style' );
}
add_action( 'admin_enqueue_scripts', 'cdevroe_tootfaves_add_editor_styles' );