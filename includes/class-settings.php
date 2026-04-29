<?php

if (!defined('ABSPATH')) exit;

class PPWH_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'save']);
    }

    public function menu() {
        add_options_page(
            'PostPulse Webhook',
            'PostPulse Webhook',
            'manage_options',
            'ppwh-settings',
            [$this, 'page']
        );
    }

    public function save() {
        register_setting('ppwh_group', 'ppwh_rules');
    }

    public function page() {
        $rules = get_option('ppwh_rules', []);
        ?>

        <div class="wrap">
            <h1>PostPulse Webhook Rules</h1>

            <form method="post" action="options.php">
                <?php settings_fields('ppwh_group'); ?>

                <table class="form-table" id="ppwh-rules-table">
                    <tbody>

                    <?php foreach ($rules as $i => $rule): ?>
                        <?php $this->render_row($i, $rule); ?>
                    <?php endforeach; ?>

                    </tbody>
                </table>

                <button type="button" class="button" onclick="ppwhAddRow()">+ Add Rule</button>

                <?php submit_button(); ?>
            </form>
        </div>

        <script>
        function ppwhAddRow() {
            let index = document.querySelectorAll('#ppwh-rules-table tr').length;

            let html = `
            <tr>
                <td>
                    <select name="ppwh_rules[${index}][post_type]">
                        <option value="post">Post</option>
                        <option value="page">Page</option>
                        <option value="product">Product</option>
                        <option value="attachment">Media</option>
                    </select>

                    <select name="ppwh_rules[${index}][event]">
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                    </select>

                    <input type="text" name="ppwh_rules[${index}][api_url]" placeholder="API URL" />

                    <select name="ppwh_rules[${index}][method]">
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="GET">GET</option>
                        <option value="DELETE">DELETE</option>
                    </select>

                    <input type="text" name="ppwh_rules[${index}][secret]" placeholder="Secret" />

                    <input type="text" name="ppwh_rules[${index}][tag]" placeholder="Tag (e.g homepage)" />

                    <label>
                        <input type="checkbox" name="ppwh_rules[${index}][enabled]" value="1"> Enable
                    </label>
                </td>
            </tr>`;
            
            document.querySelector('#ppwh-rules-table tbody').insertAdjacentHTML('beforeend', html);
        }
        </script>

        <?php
    }

    private function render_row($i, $rule) {
        ?>
        <tr>
            <td>
                <select name="ppwh_rules[<?php echo $i ?>][post_type]">
                    <option value="post" <?php selected($rule['post_type'], 'post'); ?>>Post</option>
                    <option value="page" <?php selected($rule['post_type'], 'page'); ?>>Page</option>
                    <option value="product" <?php selected($rule['post_type'], 'product'); ?>>Product</option>
                    <option value="attachment" <?php selected($rule['post_type'], 'attachment'); ?>>Media</option>
                </select>

                <select name="ppwh_rules[<?php echo $i ?>][event]">
                    <option value="create" <?php selected($rule['event'], 'create'); ?>>Create</option>
                    <option value="update" <?php selected($rule['event'], 'update'); ?>>Update</option>
                    <option value="delete" <?php selected($rule['event'], 'delete'); ?>>Delete</option>
                </select>

                <input type="text" name="ppwh_rules[<?php echo $i ?>][api_url]" value="<?php echo esc_attr($rule['api_url']); ?>" />

                <select name="ppwh_rules[<?php echo $i ?>][method]">
                    <option value="POST" <?php selected($rule['method'], 'POST'); ?>>POST</option>
                    <option value="PUT" <?php selected($rule['method'], 'PUT'); ?>>PUT</option>
                    <option value="GET" <?php selected($rule['method'], 'GET'); ?>>GET</option>
                    <option value="DELETE" <?php selected($rule['method'], 'DELETE'); ?>>DELETE</option>
                </select>

                <input type="text" name="ppwh_rules[<?php echo $i ?>][secret]" value="<?php echo esc_attr($rule['secret']); ?>" />

                <input type="text" name="ppwh_rules[<?php echo $i ?>][tag]" value="<?php echo esc_attr($rule['tag']); ?>" />

                <label>
                    <input type="checkbox" name="ppwh_rules[<?php echo $i ?>][enabled]" value="1" <?php checked($rule['enabled'], 1); ?>>
                    Enable
                </label>
            </td>
        </tr>
        <?php
    }
}