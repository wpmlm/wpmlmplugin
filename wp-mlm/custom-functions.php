<?php
function wpmlm_admin_scripts() {
    wp_enqueue_style('wp-mlm-bootstrap-css', plugins_url('css/bootstrap.min.css', __FILE__));
    wp_enqueue_style('wp-mlm-font-awesome-css', plugins_url('css/font-awesome.min.css', __FILE__));
    wp_enqueue_style('wp-mlm-orgchart-style-css', plugins_url('css/orgchart-style.css', __FILE__));
    wp_enqueue_style('orgchart-css', plugins_url('css/jquery.orgchart.css', __FILE__));
    wp_enqueue_style('wp-mlm-datepicker', plugins_url('css/datepicker.css', __FILE__));
    wp_enqueue_style('wp-mlm-dataTables-css', plugins_url('css/dataTables.bootstrap.min.css', __FILE__));    
    wp_enqueue_script('wp-mlm-bootstrap-js', plugins_url('/js/bootstrap.min.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('wp-mlm-bootstrap-datepicker', plugins_url('/js/bootstrap-datepicker.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('wp-mlm-session-js', plugins_url('/js/jquery.session.min.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('wp-mlm-orgchart-js', plugins_url('/js/jquery.orgchart.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('wp-mlm-dataTables', plugins_url('/js/jquery.dataTables.min.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('wp-mlm-bootstrap-dataTables', plugins_url('/js/dataTables.bootstrap.min.js', __FILE__), array( 'jquery' ));

    wp_enqueue_script('wp-mlm-chart-js', plugins_url('/js/Chart.min.js', __FILE__), array( 'jquery' ));


    wp_enqueue_style('admin-wp-mlm-style', plugins_url('css/style.css', __FILE__));
    wp_register_script('wp-mlm-my-script', plugins_url('/js/custom.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('wp-mlm-my-script');
    wp_localize_script('wp-mlm-my-script', 'path', array('pluginsUrl' => plugins_url(WP_MLM_PLUGIN_NAME),));
    wp_localize_script("wp-mlm-my-script", "site", array("siteUrl" => site_url()));
}

function wpmlm_login_style() {
    echo '<style type="text/css">
    #login #nav a{
    background: #0073aa !important;
    padding: 10px !important;
    color:#fff !important;
    }
    .login #nav {text-align: center!important;}
        #login #nav a {    background: #2e85ba !important;
    border-radius: 4px;}
        #login #nav a:hover {background-color: #2e85ba !important;
    border: 1px solid #006799 !important;}
</style>';
}

function wpmlm_custom_loginlogo() {

    $result = wpmlm_get_general_information();
    if ($result->site_logo == 'active') {
        echo '<style type="text/css">
#login h1 a {background-image: url(' . plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/uploads/' . $result->company_logo . ') !important; }
    
</style>';
    }
}

function wpmlm_register_menu() {
    if (current_user_can('subscriber') || (current_user_can('contributor'))) {
        add_action('admin_menu', 'wpmlm_admin_actions_user');
    } else {
        add_action('admin_menu', 'wpmlm_admin_actions');
    }
}

function wpmlm_admin_settings() {
    include('wp-mlm-admin.php');
}

function wpmlm_user_settings() {
    include('wp-mlm-user.php');
}

function wpmlm_admin_actions() {
    $icon_url = plugins_url() . "/" . WP_MLM_PLUGIN_NAME . "/images/icon-01.png";
    add_menu_page('WP MLM ADMIN', 'WP MLM', 1, 'mlm-admin-settings', 'wpmlm_admin_settings', $icon_url);
    
}

function wpmlm_admin_actions_user() {
    $icon_url = plugins_url() . "/" . WP_MLM_PLUGIN_NAME . "/images/icon-01.png";
    add_menu_page('WP MLM ADMIN', 'WP MLM', 1, 'mlm-user-settings', 'wpmlm_user_settings', $icon_url);
}

add_action('admin_init', 'wpmlm_remove_menu_pages');

function wpmlm_remove_menu_pages() {

    global $user_ID;

    if (current_user_can('contributor') || (current_user_can('subscriber'))) {
        remove_menu_page('tools.php');
    }
}


function wpmlm_admin_notice() {
    global $pagenow;

    if (current_user_can('administrator')) {
        if ($pagenow == 'index.php') {

            echo '<div class="notice notice-info is-dismissible">
          <p>Click <a href="admin.php?page=mlm-admin-settings">here</a> to view the WP MLM Dashboard</p>
         </div>';
        }
    } else {

        if ($pagenow == 'index.php') {

            echo '<div class="notice notice-info is-dismissible">
          <p>Click <a href="admin.php?page=mlm-user-settings">here</a> to view the WP MLM Dashboard</p>
         </div>';
        }
    }
}

add_action('admin_notices', 'wpmlm_admin_notice');
add_filter('pre_option_default_role', function($default_role){
    return 'contributor'; 
});


add_action('wp_head', 'wpmlm_ajaxurl');

function wpmlm_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

add_action( 'wp_ajax_wpmlm_ajax_general_settings', 'wpmlm_ajax_general_settings' );
add_action( 'wp_ajax_wpmlm_ajax_ewallet_management', 'wpmlm_ajax_ewallet_management' );
add_action( 'wp_ajax_wpmlm_auto_fill_user', 'wpmlm_auto_fill_user' );
add_action( 'wp_ajax_wpmlm_level_bonus', 'wpmlm_level_bonus' );
add_action( 'wp_ajax_wpmlm_ajax_transaction_password', 'wpmlm_ajax_transaction_password' );
add_action( 'wp_ajax_wpmlm_ajax_payment_option', 'wpmlm_ajax_payment_option' );
add_action( 'wp_ajax_wpmlm_ajax_package_settings', 'wpmlm_ajax_package_settings' );
add_action( 'wp_ajax_wpmlm_ajax_profile_report', 'wpmlm_ajax_profile_report' );
add_action( 'wp_ajax_wpmlm_ajax_joining_report', 'wpmlm_ajax_joining_report' );
add_action( 'wp_ajax_wpmlm_ajax_bonus_report', 'wpmlm_ajax_bonus_report' );
add_action( 'wp_ajax_wpmlm_ajax_user_details', 'wpmlm_ajax_user_details' );
add_action( 'wp_ajax_wpmlm_ajax_user_profile', 'wpmlm_ajax_user_profile' );
add_action( 'wp_ajax_wpmlm_ajax_session', 'wpmlm_ajax_session' );
add_action( 'wp_ajax_wpmlm_ajax_user_check', 'wpmlm_ajax_user_check' );