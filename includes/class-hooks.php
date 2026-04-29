<?php

if (!defined('ABSPATH')) exit;

class PPWH_Hooks {

    public function __construct() {
        add_action('save_post', [$this, 'handle_save'], 10, 3);
        add_action('before_delete_post', [$this, 'handle_delete']);
    }

    public function handle_save($post_id, $post, $update) {

        if (wp_is_post_autosave($post_id)) return;
        if (wp_is_post_revision($post_id)) return;
        if ($post->post_status !== 'publish') return;

        $event = $update ? 'update' : 'create';

        $this->process_rules($post_id, $post, $event);
    }

    public function handle_delete($post_id) {
        $post = get_post($post_id);
        if (!$post) return;

        $this->process_rules($post_id, $post, 'delete');
    }

    private function process_rules($post_id, $post, $event) {

        $rules = get_option('ppwh_rules', []);

        foreach ($rules as $rule) {

            if (empty($rule['enabled'])) continue;

            if ($rule['post_type'] !== $post->post_type) continue;

            if ($rule['event'] !== $event) continue;

            $webhook = new PPWH_Webhook();
            $webhook->send($rule);
        }
    }
}