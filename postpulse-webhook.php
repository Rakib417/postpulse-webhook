<?php
/**
 * Plugin Name: PostPulse Webhook
 * Plugin URI: https://wordpress.org/plugins/postpulse-webhook/
 * Description: Send real-time webhooks when posts are published or updated.
 * Version: 1.0.0
 * Author: Md. Rakib Ullah
 * Author URI: https://www.linkedin.com/in/rakib417/
 * Text Domain: postpulse-webhook
 * Domain Path: /languages
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) exit;

// Constants
define('PPWH_PATH', plugin_dir_path(__FILE__));
define('PPWH_URL', plugin_dir_url(__FILE__));
define('PPWH_VERSION', '1.0.0');

// Includes
require_once PPWH_PATH . 'includes/class-settings.php';
require_once PPWH_PATH . 'includes/class-hooks.php';
require_once PPWH_PATH . 'includes/class-webhook.php';

// Init
function ppwh_init() {
    new PPWH_Settings();
    new PPWH_Hooks();
}
add_action('plugins_loaded', 'ppwh_init');