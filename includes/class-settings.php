<?php

if (!defined('ABSPATH')) exit;

class PPWH_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'register']);
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

    public function register() {
        register_setting('ppwh_group', 'ppwh_rules');
    }

    public function page() {
        $rules = get_option('ppwh_rules', []);
        ?>

        <div class="wrap">
            <h1>PostPulse Webhook Rules</h1>

            <form method="post" action="options.php">
                <?php settings_fields('ppwh_group'); ?>

                <table id="ppwh-rules-table">
                    <tbody>
                        <?php foreach ($rules as $i => $rule): ?>
                            <?php $this->row($i, $rule); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <br>
                <button type="button" class="button button-primary" onclick="ppwhAddRow()">+ Add Rule</button>

                <?php submit_button(); ?>
            </form>
        </div>

        <script>
        function ppwhAddRow() {
            let table = document.querySelector('#ppwh-rules-table tbody');
            let i = table.querySelectorAll('tr').length;

            let html = `
            <tr>
                <td>
                    <select name="ppwh_rules[${i}][post_type]">
                        <option value="post">Post</option>
                        <option value="page">Page</option>
                        <option value="product">Product</option>
                        <option value="attachment">Media</option>
                    </select>

                    <select name="ppwh_rules[${i}][event]">
                        <option value="any">Any Change</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                    </select>

                    <input type="text" name="ppwh_rules[${i}][api_url]" placeholder="API URL" />

                    <select name="ppwh_rules[${i}][method]">
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="GET">GET</option>
                        <option value="DELETE">DELETE</option>
                    </select>

                    <input type="text" name="ppwh_rules[${i}][secret]" placeholder="Secret" />
                    <input type="text" name="ppwh_rules[${i}][tag]" placeholder="Tag (optional → auto slug)" />

                    <label>
                        <input type="checkbox" name="ppwh_rules[${i}][enabled]" value="1"> Enable
                    </label>

                    <button type="button" onclick="this.closest('tr').remove()">Delete</button>
                </td>
            </tr>`;

            table.insertAdjacentHTML('beforeend', html);
        }
        </script>

        <?php
    }

    private function row($i, $r) {
        ?>
        <tr>
            <td>
                <select name="ppwh_rules[<?php echo $i ?>][post_type]">
                    <option value="post" <?php selected($r['post_type'], 'post'); ?>>Post</option>
                    <option value="page" <?php selected($r['post_type'], 'page'); ?>>Page</option>
                    <option value="product" <?php selected($r['post_type'], 'product'); ?>>Product</option>
                    <option value="attachment" <?php selected($r['post_type'], 'attachment'); ?>>Media</option>
                </select>

                <select name="ppwh_rules[<?php echo $i ?>][event]">
                    <option value="any" <?php selected($r['event'], 'any'); ?>>Any Change</option>
                    <option value="create" <?php selected($r['event'], 'create'); ?>>Create</option>
                    <option value="update" <?php selected($r['event'], 'update'); ?>>Update</option>
                    <option value="delete" <?php selected($r['event'], 'delete'); ?>>Delete</option>
                </select>

                <input type="text" name="ppwh_rules[<?php echo $i ?>][api_url]" value="<?php echo esc_attr($r['api_url']); ?>" />

                <select name="ppwh_rules[<?php echo $i ?>][method]">
                    <option value="POST" <?php selected($r['method'], 'POST'); ?>>POST</option>
                    <option value="PUT" <?php selected($r['method'], 'PUT'); ?>>PUT</option>
                    <option value="GET" <?php selected($r['method'], 'GET'); ?>>GET</option>
                    <option value="DELETE" <?php selected($r['method'], 'DELETE'); ?>>DELETE</option>
                </select>

                <input type="text" name="ppwh_rules[<?php echo $i ?>][secret]" value="<?php echo esc_attr($r['secret']); ?>" />
                <input type="text" name="ppwh_rules[<?php echo $i ?>][tag]" value="<?php echo esc_attr($r['tag']); ?>" />

                <label>
                    <input type="checkbox" name="ppwh_rules[<?php echo $i ?>][enabled]" value="1" <?php checked($r['enabled'], 1); ?>>
                    Enable
                </label>

                <button type="button" onclick="this.closest('tr').remove()">Delete</button>
            </td>
        </tr>
        <?php
    }
}