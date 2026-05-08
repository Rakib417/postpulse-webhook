<?php

if (!defined('ABSPATH')) exit;

class PPWH_Webhook {

    public function send($rule, $post = null) {

        // API required
        if (empty($rule['api_url'])) return;

        $method = strtoupper($rule['method'] ?? 'POST');

        // Build payload
        $payload = [];

        // Secret (fixed)
        if (!empty($rule['secret'])) {
            $payload['secret'] = $rule['secret'];
        }

        // Tag logic (ALWAYS array: tags[])
        $tag = '';

        // Manual tag
        if (!empty($rule['tag'])) {
            $tag = $rule['tag'];
        }
        // Dynamic tag (post slug)
        elseif ($post && !empty($post->post_name)) {
            $tag = $post->post_name;
        }

        // Add tags array
        if (!empty($tag)) {
            $payload['tags'] = ["posts", $tag]; // IMPORTANT: must be array
        }

        // Request args
        $args = [
            'method'  => $method,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'timeout' => 10,
            'body'    => wp_json_encode($payload),
        ];

        // GET support (optional)
        if ($method === 'GET') {
            $url = add_query_arg($payload, $rule['api_url']);
            wp_remote_get($url);
        } else {
            wp_remote_request($rule['api_url'], $args);
        }
    }
}