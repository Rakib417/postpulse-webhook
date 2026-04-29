<?php

if (!defined('WP_UNINSTALL_PLUGIN')) exit;

delete_option('ppwh_api_url');
delete_option('ppwh_secret_key');