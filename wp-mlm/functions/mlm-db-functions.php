<?php
function wpmlm_get_level_depth() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql1 = "SELECT COUNT(*) FROM {$table_prefix}wpmlm_level_commission";
    return $count = $wpdb->get_var($sql1);
}

function wpmlm_setLevel($depth) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;


    $level_depth = wpmlm_get_level_depth();
    if ($level_depth < $depth) {

        for ($j = $level_depth + 1; $j <= $depth; $j++) {
            $sql1 = "INSERT INTO {$table_prefix}wpmlm_level_commission(level_no,level_percentage) VALUES('" . $j . "',0)";
            $wpdb->query($sql1);
        }
    } else {
        $limit = $level_depth - $depth;
        $sql2 = "DELETE FROM {$table_prefix}wpmlm_level_commission order by id DESC LIMIT $limit";
        $wpdb->query($sql2);
    }
}

function wpmlm_setLevel1($depth) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql1 = "TRUNCATE TABLE {$table_prefix}wpmlm_level_commission";
    $wpdb->query($sql1);

    for ($j = 1, $i = $depth; $j <= $depth; $j++, $i--) {
        $sql2 = "INSERT INTO {$table_prefix}wpmlm_level_commission(level_no,level_percentage) VALUES('" . $j . "','" . $i . "')";
        $wpdb->query($sql2);
    }
}

function wpmlm_update_level_commission($level_commission) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql1 = "TRUNCATE TABLE {$table_prefix}wpmlm_level_commission";
    $wpdb->query($sql1);
    $j = 0;
    foreach ($level_commission as $com) {
        $j++;
        $sql2 = "INSERT INTO {$table_prefix}wpmlm_level_commission(level_no,level_percentage) VALUES('" . $j . "','" . $com . "')";
        $wpdb->query($sql2);
    }
}

function wpmlm_get_level_commission() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql1 = "SELECT * FROM {$table_prefix}wpmlm_level_commission";
    return $results = $wpdb->get_results($sql1);
}

function wpmlm_update_level_commission_type($level_type) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_configuration";
    $sql = "UPDATE {$table_name} SET  `level_commission_type`= '" . $level_type . "' where `id`= 1  ";
    $wpdb->query($sql);
}

function wpmlm_get_commission_level_type() {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_configuration";
    $sql = "SELECT level_commission_type FROM {$table_name} where `id`= 1  ";
    return $result = $wpdb->get_row($sql);
}

/* get all user details of a particular level */

function wpmlm_get_user_details_by_level($level) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_users WHERE user_level = '" . $level . "'";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* insert user registration details */

function wpmlm_insert_user_registration_details($user_details) {

    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_users";
    $result = $wpdb->insert($table_name, $user_details);


    if ($result) {
        return true;
    } else {
        return false;
    }
}

/* get userlevel by parent id */

function wpmlm_get_user_level_by_parent_id($user_parent_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_level FROM {$table_prefix}wpmlm_users WHERE user_ref_id = '" . $user_parent_id . "'";
    $user_level = $wpdb->get_var($sql);
    return $user_level + 1;
}

/* get user details by user id */

function wpmlm_get_user_details($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_users WHERE user_ref_id = '" . $user_id . "'";
    $results = $wpdb->get_row($sql);
    return $results;
}

/* get bonus percentage of a paricular level */

function wpmlm_get_level_percentage($level) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT level_percentage FROM {$table_prefix}wpmlm_level_commission WHERE level_no = '" . $level . "'";
    $result = $wpdb->get_var($sql);
    return $result;
}

/* get all registration packages */

function wpmlm_select_all_packages() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_registration_packages";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* registration package name duplication checking */

function wpmlm_package_name_check($package_name) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT count(*) FROM {$table_prefix}wpmlm_registration_packages where package_name='" . $package_name . "'";
    $result = $wpdb->get_var($sql);
    return $result;
}

/* get registration package by package id */

function wpmlm_select_package_by_id($package_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_registration_packages WHERE id='" . $package_id . "'";
    $results = $wpdb->get_row($sql);
    return $results;
}

/* delete package by package id */

function wpmlm_delete_package_by_id($package_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $results1 = wpmlm_select_package_by_id($package_id);
    $filepath = IOSS_MLM_PLUGIN_DIR . '/uploads/' . $results1->package_image;

    if ($results1->package_image != 'no-image.png') {
        unlink($filepath);
    }
    $sql = "DELETE FROM {$table_prefix}wpmlm_registration_packages WHERE id='" . $package_id . "'";
    $results = $wpdb->query($sql);
    return $results;
}

/* insert registration type paid or free or both */

function wpmlm_insert_reg_type($type) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_reg_type";
    $sql1 = "TRUNCATE TABLE {$table_name}";
    $wpdb->query($sql1);

    foreach ($type as $ty) {
        $sql2 = "INSERT INTO {$table_name}(reg_type) VALUES('" . $ty . "')";
        $wpdb->query($sql2);
    }
}

/* get registration type */

function wpmlm_select_reg_type() {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_reg_type";
    $sql = "SELECT * FROM {$table_name}";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get registration type name */

function wpmlm_select_reg_type_name() {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_reg_type";
    $sql = "SELECT GROUP_CONCAT(reg_type) as reg_type FROM {$table_name}";
    $results = $wpdb->get_row($sql);
    return $results;
}

/* get paypal details */

function wpmlm_get_paypal_details() {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_paypal";
    $sql = "SELECT * FROM {$table_name} where id=1";
    $results = $wpdb->get_row($sql);
    return $results;
}

/* get all country list */

function wpmlm_getAllCountry() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_country";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get all children of a particular parent by parent id */

function wpmlm_display_children($parent_id, $level) {
    $count = 0;
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_ref_id FROM {$table_prefix}wpmlm_users WHERE user_parent_id='" . $parent_id . "'";
    $results = $wpdb->get_results($sql);

    foreach ($results as $res) {
        $var = str_repeat(' ', $level) . $res->user_ref_id . "\n";
        $count += 1 + wpmlm_display_children($res->user_ref_id, $level + 1);
    }

    return $var;
}

/* get all user details */

function wpmlm_getUserDetails() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_id,user_ref_id,user_parent_id,user_first_name,user_email FROM {$table_prefix}wpmlm_users";
    $results = $wpdb->get_results($sql);
    return $results;
}

//changed
/* get all userdetails by parent id */
function wpmlm_getUserDetailsByParent($parent_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_id,user_ref_id,user_parent_id,user_first_name,user_email FROM {$table_prefix}wpmlm_users where user_parent_id='" . $parent_id . "'";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get user details by user id */

function wpmlm_get_user_details_by_id($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_users WHERE user_ref_id = '" . $user_id . "'";
    $results = $wpdb->get_row($sql);
    return $results;
}

/* get user details by joining with wordpress users by user id */

function wpmlm_get_user_details_by_id_join($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id AND b.user_ref_id = '" . $user_id . "'";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get all user details between two dates */

function wpmlm_get_all_user_details_by_date_join($start_date, $end_date) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id WHERE b.join_date BETWEEN '" . $start_date . "'  AND '" . $end_date . "'  ORDER BY b.join_date ";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get all user details by joing */

function wpmlm_get_all_user_details_join() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id ";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get recently joined users details under admin */

function wpmlm_get_recently_joined_users_under_admin($user_id, $num) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id WHERE a.`ID`!= $user_id  ORDER BY a.ID DESC LIMIT 0,$num";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get recently joined users details */

function wpmlm_get_recently_joined_users($num) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id   ORDER BY a.ID DESC LIMIT 0,$num";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get recently joined users details of a particular parent */

function wpmlm_get_recently_joined_users_by_parent($user_id, $num) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id  where b.`user_parent_id`='$user_id' ORDER BY a.ID DESC LIMIT 0,$num";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* username serch */

function wpmlm_get_all_user_like($keyword) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_login FROM {$table_prefix}users WHERE user_login LIKE '{$keyword}%' ";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* username serch except the current user */

function wpmlm_get_all_user_like_except_current($keyword, $username) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_login FROM {$table_prefix}users WHERE user_login LIKE '{$keyword}%' AND user_login !='$username' ";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* get all username */

function wpmlm_get_all_user_login() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT user_login FROM {$table_prefix}users order by user_login ASC ";
    $results = $wpdb->get_results($sql);
    return $results;
}

/* tree function */

function wpmlm_buildTree(array $elements, $parentId) {
    static $counter = 0;
    ++$counter;
    $tree = array();
    foreach ($elements as $element) {
        if ($element->user_ref_id == $parentId) {
            if ($counter == 1) {
                $tree[] = wpmlm_get_user_details_by_id_join($parentId);
            }
        }
        if ($element->user_parent_id == $parentId) {
            $children = wpmlm_buildTree($elements, $element->user_ref_id);
            if ($children) {
                $tree[] = $children;
            }

            $tree[] = $element;
        }
    }


    return $tree;
}

function wpmlm_treeData($id) {
    $res = array();
    $res[] = wpmlm_get_user_details_by_id($id);
    $res[]['children'] = wpmlm_getUserDetailsByParent($id);
    return $res;
}

function wpmlm_makeNested($source) {
    $nested = array();

    foreach ($source as &$s) {
        if (is_null($s['parent_id'])) {
            // no parent_id so we put it in the root of the array
            $nested[] = &$s;
        } else {
            $pid = $s['parent_id'];
            if (isset($source[$pid])) {

                if (!isset($source[$pid]['children'])) {
                    $source[$pid]['children'] = array();
                }

                $source[$pid]['children'][] = &$s;
            }
        }
    }
    return $nested;
}

function wpmlm_get_leg_amount_details_all() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.user_id, ROUND(SUM(a.total_amount),2) as total_amount, b.user_first_name,b.user_second_name,a.amount_type,a.date_of_submission,c.user_login FROM {$table_prefix}wpmlm_leg_amount a INNER JOIN {$table_prefix}wpmlm_users b ON a.user_id=b.user_ref_id INNER JOIN {$table_prefix}users c ON a.user_id = c.ID GROUP BY a.user_id ";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_leg_amount_details($start_date, $end_date) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.user_id, ROUND(SUM(a.total_amount),2) as total_amount, b.user_first_name,b.user_second_name,a.amount_type,a.date_of_submission,c.user_login FROM {$table_prefix}wpmlm_leg_amount a INNER JOIN {$table_prefix}wpmlm_users b ON a.user_id=b.user_ref_id INNER JOIN {$table_prefix}users c ON a.user_id = c.ID WHERE a.date_of_submission BETWEEN '" . $start_date . "'  AND '" . $end_date . "'  GROUP BY a.user_id ";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_leg_amount_details_by_user_id($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.user_login, b.total_amount, b.amount_type,b.date_of_submission FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_leg_amount b ON a.ID=b.from_id WHERE b.user_id='" . $user_id . "' order by b.date_of_submission";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_user_details_by_parent_id_join($parent_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT a.*,b.* FROM {$table_prefix}users a INNER JOIN {$table_prefix}wpmlm_users b ON a.ID=b.user_ref_id WHERE b.user_parent_id = '" . $parent_id . "' order by b.join_date";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_by_user_id($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT ROUND(SUM(total_amount),2) as total_amount FROM {$table_prefix}wpmlm_leg_amount WHERE user_id='" . $user_id . "' ";
    $results = $wpdb->get_row($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_by_user_id_today($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $date = date('Y-m-d');
    $sql = "SELECT ROUND(SUM(total_amount),2) as total_amount FROM {$table_prefix}wpmlm_leg_amount WHERE user_id='" . $user_id . "' AND DATE(`date_of_submission`) = '$date' ";
    $results = $wpdb->get_row($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_all() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT ROUND(SUM(total_amount),2) as total_amount FROM {$table_prefix}wpmlm_leg_amount";
    $results = $wpdb->get_row($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_all_by_user() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT ROUND(SUM(amt.`total_amount`),2) as total_amount ,u.`user_first_name` FROM {$table_prefix}wpmlm_leg_amount amt left join {$table_prefix}wpmlm_users  u ON amt.`user_id`=u.`user_id` group by amt.`user_id` LIMIT 0,5";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_all_users_under_admin($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT ROUND(SUM(amt.`total_amount`),2) as total_amount ,u.`user_first_name` FROM {$table_prefix}wpmlm_leg_amount amt left join {$table_prefix}wpmlm_users  u ON amt.`user_id`=u.`user_id` WHERE u.`user_parent_id`!='0' group by amt.`user_id` LIMIT 0,5";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_all_users_under_parent($user_id) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT ROUND(SUM(amt.`total_amount`),2) as total_amount ,u.`user_first_name` FROM {$table_prefix}wpmlm_leg_amount amt left join {$table_prefix}wpmlm_users  u ON amt.`user_id`=u.`user_id` where u.`user_parent_id`='$user_id' group by amt.`user_id` LIMIT 0,3";
    $results = $wpdb->get_results($sql);
    return $results;
}

function wpmlm_get_total_leg_amount_all_by_today() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $date = date('Y-m-d');
    $sql = "SELECT ROUND(SUM(total_amount),2) as total_amount FROM {$table_prefix}wpmlm_leg_amount where DATE(`date_of_submission`)= '$date' ";
    $results = $wpdb->get_row($sql);
    return $results;
}

function wpmlm_get_total_leg_amount($start_date, $end_date) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT ROUND(SUM(total_amount),2) as total_amount FROM {$table_prefix}wpmlm_leg_amount WHERE date_of_submission BETWEEN '" . $start_date . "'  AND '" . $end_date . "'  ";
    $results = $wpdb->get_row($sql);
    return $results;
}

function wpmlm_get_general_information() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $sql = "SELECT * FROM {$table_prefix}wpmlm_general_information WHERE id = 1 ";
    $results = $wpdb->get_row($sql);
    return $results;
}

//Ewallet Functions

function wpmlm_getRandTransPasscode($length) {
    global $wpdb;
    $table_prefix = $wpdb->prefix;

    $key = '';
    $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++)
        $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
    $randum_id = wp_hash_password($key);
    //$randum_id = $key;

    $sql = "SELECT * FROM {$table_prefix}wpmlm_tran_password WHERE tran_password = '" . $randum_id . "'  ";
    $wpdb->get_row($sql);
    $count = $wpdb->num_rows;
    if (!$count)
        return $key;
    else
        wpmlm_getRandTransPasscode($length);
}

function wpmlm_insert_tran_password($tran_pass_details) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_tran_password";
    $wpdb->insert($table_name, $tran_pass_details);
}

function wpmlm_update_tran_password($tran_pass, $user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_tran_password";
    $sql = "UPDATE {$table_name} SET  `tran_password`= '" . $tran_pass . "' where `user_id`= '" . $user_id . "'  ";
    $result = $wpdb->query($sql);
    return $result;
}

function wpmlm_getUserPasscode($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_tran_password";
    $sql = "SELECT tran_password FROM {$table_name} WHERE user_id = '" . $user_id . "'  ";
    $result = $wpdb->get_row($sql);
    return $result;
}

function wpmlm_getUniqueTransactionId() {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_transaction_id";

    $date = date('Y-m-d H:i:s');
    $code = getRandStr(9, 9);
    $data = array(
        'transaction_id' => $code,
        'added_date' => $date
    );

    $wpdb->insert($table_name, $data);
    return $code;
}

function wpmlm_getRandStr() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;

    $key = "";
    $charset = "0123456789";
    $length = 10;
    for ($i = 0; $i < $length; $i++)
        $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];

    $randum_number = $key;

    $sql = "SELECT * FROM {$table_prefix}wpmlm_transaction_id WHERE transaction_id = '" . $randum_number . "'  ";
    $wpdb->get_row($sql);
    $count = $wpdb->num_rows;
    if (!$count)
        return $key;
    else
        wpmlm_getRandStr();
}

function wpmlm_getRandStrPassword() {

    $key = "";
    $charset = "0123456789";
    $length = 8;
    for ($i = 0; $i < $length; $i++)
        $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
    return $key;
}

function wpmlm_insert_fund_transfer_details($fund_details) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_fund_transfer_details";
    $result = $wpdb->insert($table_name, $fund_details);
    return $result;
}

function wpmlm_insertBalanceAmount($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_user_balance_amount";
    $data = array(
        'balance_amount' => 0,
        'user_id' => $user_id
    );
    $wpdb->insert($table_name, $data);
}

function wpmlm_getEwalletHistory($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_ewallet_history";
    $sql = "SELECT * FROM {$table_name} WHERE user_id = '" . $user_id . "'  ";
    $result = $wpdb->get_results($sql);
    return $result;
}

function wpmlm_addEwalletHistory($ewallet_details) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_ewallet_history";
    $result = $wpdb->insert($table_name, $ewallet_details);
    return $result;
}

function wpmlm_updateBalanceAmountDetailsFrom($from_user_id, $fund_amount) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_user_balance_amount";
    $sql = "UPDATE {$table_name} SET  `balance_amount`= balance_amount - {$fund_amount} where `user_id`= '" . $from_user_id . "'  ";
    $wpdb->query($sql);
}

function wpmlm_updateBalanceAmountDetailsTo($to_user_id, $fund_amount) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_user_balance_amount";
    $sql = "UPDATE {$table_name} SET  `balance_amount`= balance_amount + {$fund_amount} where `user_id`= '" . $to_user_id . "'  ";
    $wpdb->query($sql);
}

function wpmlm_getBalanceAmount($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_user_balance_amount";
    $sql = "SELECT ROUND(`balance_amount`,2) as balance_amount  FROM {$table_name} WHERE user_id = '" . $user_id . "'  ";
    $result = $wpdb->get_row($sql);
    return $result;
}

function wpmlm_getTransferDetails($user_id, $start_date, $end_date) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_fund_transfer_details";
    $sql = "SELECT * FROM {$table_name} WHERE to_user_id = '" . $user_id . "' AND (date BETWEEN '" . $start_date . "'  AND '" . $end_date . "')  ORDER BY date ";
    $result = $wpdb->get_results($sql);
    return $result;
}

function wpmlm_sendMailTransactionPass($to_mail, $tran_pass) {
    $res = wpmlm_get_general_information();
    $subject = 'Your new transaction password';
    $message = 'Your new password is: ' . $tran_pass;
    $headers[] = 'MIME-Version: 1.0' . "\r\n";
    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: ' . $res->company_name . ' < ' . $res->company_email . '>' . "\r\n";
    $mail = wp_mail($to_mail, $subject, $message, $headers);
    return $mail;
}

function wpmlm_sendMailRegistrationKey($to_mail, $key) {
    $current_user = wp_get_current_user();
    $subject = 'WP MLM Activation Key';
    $message = 'WP MLM activation Key is: ' . $key;
    $headers[] = 'MIME-Version: 1.0' . "\r\n";
    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: ' . $current_user->user_login . ' < ' . $current_user->user_email . '>' . "\r\n";
    $mail = wp_mail($to_mail, $subject, $message, $headers);
    return $mail;
}

function wpmlm_sendMailRegistration($to_mail, $username, $password, $user_first_name, $user_second_name) {
    $res = wpmlm_get_general_information();
    $subject = "Registration Completed Succesfully!";
    $message = "
    <p></p><br>
    Hi " . $user_first_name . ' ' . $user_second_name . "<br>
   Thank you for registering with us.<br><br>
   Your Username is " . $username . "<br> and,
   your password : " . $password . "<br><br>";

    $headers[] = 'MIME-Version: 1.0' . "\r\n";
    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: ' . $res->company_name . ' < ' . $res->company_email . '>' . "\r\n";
    $mail = wp_mail($to_mail, $subject, $message, $headers);
    return $mail;
}

function wpmlm_insert_leg_amount($user_id, $package_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_leg_amount";

    $user_details = wpmlm_get_user_details($user_id);
    $parent_level = $user_details->user_level - 1;
    $depth = wpmlm_get_level_depth();
    $level_from = $parent_level - $depth + 1;

    $general = wpmlm_get_general_information();
    $reg_amt = $general->registration_amt;

    if ($package_id !== NULL) {
        $package_details = wpmlm_select_package_by_id($package_id);


        $package_amount = $package_details->package_price;
        $package_id = $package_details->id;
    } else {
        $package_amount = $reg_amt;
    }
    $result1 = wpmlm_get_commission_level_type();
    $result = wpmlm_getAllParents($user_details->user_parent_id, $level_from);
    $i = 0;
    foreach ($result as $res) {
        $i++;
        $level_percentage = wpmlm_get_level_percentage($i);
        $flat = $level_percentage;
        $percentage = $package_amount * ($level_percentage / 100);
        $depth = $depth - 1;
        $commission_amount = ($result1->level_commission_type == 'percentage') ? $percentage : $flat;

        $data = array(
            'user_id' => $res->user_ref_id,
            'from_id' => $user_id,
            'amount_type' => 'level_bonus',
            'total_amount' => $commission_amount,
            'product_id' => $package_id,
            'product_value' => $package_amount,
            'user_level' => $i,
            'date_of_submission' => date("Y-m-d H:i:s")
        );

        $wpdb->insert($table_name, $data);

        $ewallet_id = $wpdb->insert_id;

        $ewallet_details = array(
            'from_id' => $user_id,
            'user_id' => $res->user_ref_id,
            'ewallet_id' => $ewallet_id,
            'ewallet_type' => 'commission',
            'amount' => $commission_amount,
            'amount_type' => 'level_bonus',
            'type' => 'credit',
            'date_added' => $date
        );
        wpmlm_addEwalletHistory($ewallet_details);
        wpmlm_updateBalanceAmountDetailsTo($res->user_ref_id, $commission_amount);
    }
}

function wpmlm_getAllParents($user_id = NULL, $level_from) {
    if ($user_id == NULL) {
        return false;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_users";
    $depth = wpmlm_get_level_depth();
    $sql = "SELECT * FROM {$table_name} WHERE user_ref_id = '" . $user_id . "' AND `user_level` >=$level_from ";
    $result = $wpdb->get_row($sql);

    $res[] = $result;
    if ($result->user_parent_id != 0) {

        $result = wpmlm_getAllParents($result->user_parent_id, $level_from);
        $res = array_merge($res, $result);
    }
    return $res;
}

function wpmlm_deleteUser($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "users";
    $sql = "DELETE FROM {$table_name} WHERE ID='" . $id . "'";
    $wpdb->query($sql);
}

function wpmlm_getJoiningDetailsByMonth($year, $user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_users";
    $sql = "SELECT  MONTH(`join_date`) as month,count(`user_id`) as count FROM {$table_name} where YEAR(`join_date`)='$year' AND `user_id`!='$user_id' GROUP BY  MONTH(`join_date`)";

    $result = $wpdb->get_results($sql);
    return $result;
}

function wpmlm_getJoiningDetailsUsersByMonth($user_id, $year) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_users";
    $sql = "SELECT  MONTH(`join_date`) as month,count(`user_id`) as count FROM {$table_name} where `user_parent_id`='$user_id' AND YEAR(`join_date`)='$year' GROUP BY  MONTH(`join_date`)";

    $result = $wpdb->get_results($sql);
    return $result;
}

function wpmlm_getJoiningByTodayCount($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_users";
    $date = date('Y-m-d');
    $sql = "SELECT count(`user_id`) as count FROM {$table_name} where DATE(`join_date`) = '$date' AND `user_ref_id`!='$user_id' ";

    $result = $wpdb->get_row($sql);
    return $result;
}

function wpmlm_getJoiningByTodayCountByUser($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_users";
    $date = date('Y-m-d');
    $sql = "SELECT count(`user_id`) as count FROM {$table_name} where DATE(`join_date`) = '$date' AND `user_parent_id`='$user_id' ";

    $result = $wpdb->get_row($sql);
    return $result;
}

function wpmlm_getEwalletAmount($type) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_ewallet_history";
    $sql = "SELECT SUM(`amount`) as sum FROM {$table_name} where `type` = '$type' ";
    $result = $wpdb->get_row($sql);
    return $result;
}

function wpmlm_getEwalletAmountByUser($type, $user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "wpmlm_ewallet_history";
    $sql = "SELECT SUM(`amount`) as sum FROM {$table_name} where `type` = '$type' AND `user_id`='$user_id' ";
    $result = $wpdb->get_row($sql);
    return $result;
}

function wpmlm_check_wpmlm_license() {

    $wpmlm_license_key = get_option('wpmlm_license_key');
    $status = wpmlm_check_license_status($wpmlm_license_key);
    if ($status['status'] == 'active') {
        return true;
    } else {
        return false;
    }
}
