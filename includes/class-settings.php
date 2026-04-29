<?php

if (!defined('ABSPATH')) exit;

class PPWH_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_menu() {
        add_options_page(
            'PostPulse Webhook',
            'PostPulse Webhook',
            'manage_options',
            'ppwh-settings',
            [$this, 'render_page']
        );
    }

    public function register_settings() {
        register_setting('ppwh_group', 'ppwh_api_url');
        register_setting('ppwh_group', 'ppwh_secret_key');
    }

    public function render_page() {
        ?>
        <div class="wrap">
            <h1>PostPulse Webhook Settings</h1>

            <form method="post" action="options.php">
                <?php settings_fields('ppwh_group'); ?>

                <table class="form-table">
                    <tr>
                        <th>API URL</th>
                        <td>
                            <input type="text" name="ppwh_api_url"
                                value="<?php echo esc_attr(get_option('ppwh_api_url')); ?>"
                                class="regular-text" required>
                        </td>
                    </tr>

                    <tr>
                        <th>Secret Key</th>
                        <td>
                            <input type="text" name="ppwh_secret_key"
                                value="<?php echo esc_attr(get_option('ppwh_secret_key')); ?>"
                                class="regular-text" required>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}