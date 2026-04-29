<?php
/**
 * Plugin Name: PostPulse Webhook
 * Plugin URI: https://wordpress.org/plugins/postpulse-webhook/
 * Description: Trigger revalidation API when posts are created, updated, or deleted.
 * Version: 1.0.0
 * Author: Md. Rakib Ullah
 * Author URI: https://www.linkedin.com/in/rakib417/
 * Text Domain: postpulse-webhook
 * License: GPLv2 or later
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