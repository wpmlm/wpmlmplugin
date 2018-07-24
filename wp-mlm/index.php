<?php
/*
Plugin Name: WP MLM
Plugin URI: http://wpmlmsoftware.com
Description: MLM Unilevel plugin for Wordpress.
Version: 1.0
Author: IOSS
Author URI: http://wpmlmsoftware.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
 
WP MLM is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WP MLM is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with WP MLM. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 
 */
if (!defined('ABSPATH'))
    exit;

// Path and URL
if (!defined('WP_MLM_PLUGIN_DIR'))
    define('WP_MLM_PLUGIN_DIR', WP_PLUGIN_DIR . '/wp-mlm');

if (!defined('WP_MLM_PLUGIN_NAME'))
    define('WP_MLM_PLUGIN_NAME', 'wp-mlm');
require_once(WP_MLM_PLUGIN_DIR . '/wp-mlm-constant.php');
require_once(WP_MLM_PLUGIN_DIR . '/custom-functions.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/wp-mlm-registration-page.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-income-details.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-referrals.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-ewallet-details.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-ewallet-management.php');
require_once(WP_MLM_PLUGIN_DIR . '/core_functions/db-functions.php');
require_once(WP_MLM_PLUGIN_DIR . '/functions/mlm-db-functions.php');
require_once(WP_MLM_PLUGIN_DIR . '/functions/ajax-functions.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/admin-area.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/admin-dashboard.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-dashboard.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-area.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/registration-package-settings.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/level-commission-settings.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/payment-options.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/genealogy-tree.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-details-admin.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/user-profile-admin.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/wp-mlm-settings.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/password-settings.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/general-settings.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/reports.php');
require_once(WP_MLM_PLUGIN_DIR . '/templates/ewallet-management.php');
register_activation_hook(__FILE__, 'wpmlm_install');
register_uninstall_hook(__FILE__, 'wpmlm_uninstall');
register_deactivation_hook(__FILE__, 'wpmlm_deactivate');


function wpmlm_install() {
    create_wpmlm_users_table();
    create_wpmlm_registration_packages_table();
    create_wpmlm_configuration_table();
    create_wpmlm_level_table();
    create_wpmlm_leg_amount_table();
    create_wpmlm_reg_type_table();
    create_wpmlm_paypal_table();
    create_wpmlm_general_information_table();
    create_wpmlm_fund_transfer_table();
    create_wpmlm_ewallet_history_table();
    create_wpmlm_transaction_id_table();
    create_wpmlm_tran_password_table();
    create_wpmlm_country_table();
    create_wpmlm_user_balance_amount_table();
    insert_wpmlm_first_user();
    insert_wpmlm_country_data();
    insert_wpmlm_general_information();
    insert_wpmlm_configuration_information();
    insert_wpmlm_reg_type();
}

function wpmlm_uninstall() {
    wpmlm_delete_user_data();
    wpmlm_drop_tables();
}


add_action('init', 'wpmlm_register_menu');
add_action('login_head', 'wpmlm_login_style');
add_action('login_head', 'wpmlm_custom_loginlogo');

// load the scripts on only the plugin admin page 
if (isset($_GET['page']) && (($_GET['page'] == 'mlm-admin-settings') || ($_GET['page'] == 'mlm-user-settings'))){        
    wpmlm_admin_scripts();        
}