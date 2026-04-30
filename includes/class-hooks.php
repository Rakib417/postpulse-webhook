<?php

if (!defined('ABSPATH')) exit;

class PPWH_Hooks {

    public function __construct() {
        add_action('save_post', [$this, 'save'], 10, 3);
        add_action('before_delete_post', [$this, 'delete']);
    }

    public function save($post_id, $post, $update) {

        if (wp_is_post_autosave($post_id)) return;
        if (wp_is_post_revision($post_id)) return;
        if ($post->post_status !== 'publish') return;

        $event = $update ? 'update' : 'create';

        $this->run($post, $event);
    }

    public function delete($post_id) {
        $post = get_post($post_id);
        if (!$post) return;

        $this->run($post, 'delete');
    }

    private function run($post, $event) {

        $rules = get_option('ppwh_rules', []);

        foreach ($rules as $rule) {

            if (empty($rule['enabled'])) continue;
            if (empty($rule['api_url'])) continue;

            if ($rule['post_type'] !== $post->post_type) continue;

            if ($rule['event'] !== 'any' && $rule['event'] !== $event) continue;

            (new PPWH_Webhook())->send($rule, $post);
        }
    }
}