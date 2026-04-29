<?php

if (!defined('ABSPATH')) exit;

class PPWH_Hooks {

    public function __construct() {
        add_action('save_post', [$this, 'handle_post'], 10, 3);
    }

    public function handle_post($post_id, $post, $update) {

        // Prevent garbage triggers
        if (wp_is_post_autosave($post_id)) return;
        if (wp_is_post_revision($post_id)) return;

        // Only published posts
        if ($post->post_status !== 'publish') return;

        // Optional: only post type = post
        if ($post->post_type !== 'post') return;

        $action = $update ? 'updated' : 'created';

        $webhook = new PPWH_Webhook();
        $webhook->send($post_id, $action);
    }
}