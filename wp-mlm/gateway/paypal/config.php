<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
$result = wpmlm_get_paypal_details();

// sandbox or live
define('PPL_MODE', $result->paypal_mode);
define('PPL_API_USER', $result->paypal_api_username);
define('PPL_API_PASSWORD', $result->paypal_api_password);
define('PPL_API_SIGNATURE', $result->paypal_api_signature);
define('PPL_LANG', 'EN');

//define('PPL_LOGO_IMG', 'http://url/to/site/logo.png');

define('PPL_RETURN_URL', admin_url() . 'admin.php?page=mlm-user-settings');
define('PPL_CANCEL_URL', admin_url() . 'admin.php?page=mlm-user-settings');
define('PPL_CURRENCY_CODE', 'USD');