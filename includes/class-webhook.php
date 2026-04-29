<?php

if (!defined('ABSPATH')) exit;

class PPWH_Webhook {

    public function send($rule) {

        if (empty($rule['api_url']) || empty($rule['secret']) || empty($rule['tag'])) return;

        $body = [
            'secret' => $rule['secret'],
            'tag'    => $rule['tag']
        ];

        $args = [
            'method'  => $rule['method'] ?? 'POST',
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body'    => wp_json_encode($body),
            'timeout' => 10
        ];

        if ($rule['method'] === 'GET') {
            $url = add_query_arg($body, $rule['api_url']);
            wp_remote_get($url);
        } else {
            wp_remote_post($rule['api_url'], $args);
        }
    }
}