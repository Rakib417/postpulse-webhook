<?php

if (!defined('ABSPATH')) exit;

class PPWH_Webhook {

    public function send($rule, $post = null) {

        if (empty($rule['api_url'])) return;

        $method = strtoupper($rule['method'] ?? 'POST');

        $body = [];

        // Secret (always fixed)
        if (!empty($rule['secret'])) {
            $body['secret'] = $rule['secret'];
        }

        // Tag logic
        if (!empty($rule['tag'])) {
            $body['tag'] = $rule['tag'];
        } elseif ($post) {
            $body['tag'] = $post->post_name; // dynamic slug
        }

        $args = [
            'method'  => $method,
            'timeout' => 10,
        ];

        if (!empty($body)) {
            $args['headers'] = [
                'Content-Type' => 'application/json'
            ];
            $args['body'] = wp_json_encode($body);
        }

        if ($method === 'GET') {
            $url = !empty($body)
                ? add_query_arg($body, $rule['api_url'])
                : $rule['api_url'];

            wp_remote_get($url);
        } else {
            wp_remote_request($rule['api_url'], $args);
        }
    }
}