<?php
/**
 * Plugin Name:     Postmark Test Settings
 * Plugin URI:      https://github.com/ChexWarrior/postmark-test-settings
 * Description:     Enables easier testing of Postmark emails
 * Author:          Andrew Lehman <aplehm@gmail.com>
 * Version:         0.1.0
 *
 */

// Name of official postmark plugin
define('POSTMARK_PLUGIN_FILE', 'postmark-approved-wordpress-plugin/postmark.php');

function activate_postmark_test_settings() {
	add_option('pm_test_settings_enabled', '');
	add_option('pm_test_settings_default_recipient', '');
}

register_activation_hook(__FILE__, 'activate_postmark_test_settings');

function deactivate_postmark_test_settings() {
	update_option('pm_test_settings_enabled', false);
}

register_deactivation_hook(__FILE__, 'deactivate_postmark_test_settings');

function uninstall_postmark_test_settings() {
	delete_option('pm_test_settings_enabled');
	delete_option('pm_test_settings_default_recipient');
}

register_uninstall_hook(__FILE__, 'uninstall_postmark_test_settings');

function postmark_test_settings_render_enable_field() {
	$checked = !empty(get_option('pm_test_settings_enabled')) ? 'checked' : '';
	?>
	<input type="checkbox" name="pm_test_settings_enabled"
		<?php echo esc_html($checked); ?>>
	<?php
}

function postmark_test_settings_render_default_recipient_field() {
	$default = get_option('pm_test_settings_default_recipient', '');
	?>
	<input type="email" name="pm_test_settings_default_recipient"
		value="<?php echo esc_html($default); ?>">
	<?php
}

function postmark_test_settings_init() {
	// Create settings and options
	$settings_group = 'pm_test_settings';
	$page_slug = 'postmark_test_settings';
	register_setting($settings_group, 'pm_test_settings_enabled');
	register_setting($settings_group, 'pm_test_settings_default_recipient');

	// Create page section
	$settings_section = 'pm_test_settings_main';
	add_settings_section(
		$settings_section,
		'All Settings',
		'',
		$page_slug
	);

	// Add fields to that section
	add_settings_field(
		'enable',
		'Enable',
		'postmark_test_settings_render_enable_field',
		$page_slug,
		$settings_section
	);

	add_settings_field(
		'default_recipient',
		'Default Recipient',
		'postmark_test_settings_render_default_recipient_field',
		$page_slug,
		$settings_section
	);
}

add_action('admin_init', 'postmark_test_settings_init');

function postmark_test_settings_build_options_page() {
	if (!current_user_can('manage_options')) {
		return;
	}

	wp_enqueue_script(
		'postmark_test_settings_js',
		plugins_url('assets/js/settings.js', __FILE__),
		null,
		null,
		true
	);
	?>
	<div class="wrap">
		<h1>Postmark Test Settings</h1>
		<form method="post" action="options.php">
			<?php
			settings_fields('pm_test_settings');
			do_settings_sections('postmark_test_settings');
			submit_button('Save Settings');
			?>
		</form>
	</div>
	<?php
}

function postmark_test_settings_create_options_page() {
	add_options_page(
		__('Postmark Test Settings'),
		__('Postmark Test Settings'),
		'manage_options',
		'postmark_test_settings',
		'postmark_test_settings_build_options_page'
	);
}

add_action('admin_menu', 'postmark_test_settings_create_options_page');

function postmark_test_settings_show_postmark_not_active_warning() {
	if (!is_plugin_active(POSTMARK_PLUGIN_FILE)) {
		printf('<div class="notice notice-error is-dismissible">The <a href="https://wordpress.org/plugins/postmark-approved-wordpress-plugin/"> Official Postmark Plugin</a> is not currently activated! The Postmark Test Settings plugin is not meant to be used unless the official postmark plugin is active, unintended side-effects may occur!</div>');
	}
}

add_action('admin_notices', 'postmark_test_settings_show_postmark_not_active_warning');

function postmark_test_settings_override_email_recipients($args) {
	if (!empty(get_option('pm_test_settings_enabled'))) {
		$default_recipient = get_option('pm_test_settings_default_recipient');

		if (!empty($default_recipient) && is_email($default_recipient)) {
			$args['to'] = sanitize_email($default_recipient);
		}
	}

	return $args;
}

add_filter('wp_mail', 'postmark_test_settings_override_email_recipients');
