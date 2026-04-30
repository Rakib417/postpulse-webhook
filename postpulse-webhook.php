<?php
/**
 * Plugin Name: PostPulse Webhook
 * Plugin URI: https://wordpress.org/plugins/postpulse-webhook/
 * Description: Trigger API requests automatically when WordPress content is created, updated, deleted, or changed. Supports rules, post types, HTTP methods, and dynamic tag (post slug).
 * Version: 1.0.0
 * Author: Md. Rakib Ullah
 * Author URI: https://www.linkedin.com/in/rakib417/
 * Text Domain: postpulse-webhook
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit;

define('PPWH_PATH', plugin_dir_path(__FILE__));

require_once PPWH_PATH . 'includes/class-settings.php';
require_once PPWH_PATH . 'includes/class-hooks.php';
require_once PPWH_PATH . 'includes/class-webhook.php';

add_action('plugins_loaded', function () {
    new PPWH_Settings();
    new PPWH_Hooks();
});