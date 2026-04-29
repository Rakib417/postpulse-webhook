<?php

if (!defined('ABSPATH')) exit;

class PPWH_Webhook {

    public function send($post_id, $action) {

        $api_url = get_option('ppwh_api_url');
        $secret  = get_option('ppwh_secret_key');

        if (!$api_url || !$secret) return;

        $post = get_post($post_id);

        if (!$post) return;

        $data = [
            'id'        => $post->ID,
            'title'     => $post->post_title,
            'content'   => $post->post_content,
            'excerpt'   => $post->post_excerpt,
            'status'    => $post->post_status,
            'type'      => $post->post_type,
            'author'    => $post->post_author,
            'date'      => $post->post_date,
            'modified'  => $post->post_modified,
            'action'    => $action,
            'permalink' => get_permalink($post->ID)
        ];

        $response = wp_remote_post($api_url, [
            'method'  => 'POST',
            'headers' => [
                'Content-Type' => 'application/json',
                'X-SECRET-KEY' => $secret
            ],
            'body'    => wp_json_encode($data),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            error_log('PostPulse Webhook Error: ' . $response->get_error_message());
        }
    }
}