<?php
ob_start();
include (WP_MLM_PLUGIN_DIR . '/functions/php-validation.php');
include(WP_MLM_PLUGIN_DIR . '/functions/mlm-db-functions.php');

function wpmlm_register_user_html_page() {
   
    include_once(WP_MLM_PLUGIN_DIR . '/gateway/paypal/config.php');
    include_once(WP_MLM_PLUGIN_DIR . '/gateway/paypal/functions.php');
    include_once(WP_MLM_PLUGIN_DIR . '/gateway/paypal/paypal.class.php');
    
    $paypal = new MyPayPal();

    session_start();
    global $wpdb;
    global $current_user;
    $table_prefix = $wpdb->prefix;
    $success_msg = '';
    $form_style = '';
    $err_msg = '';
     

    $result = wpmlm_get_general_information();
    $reg_pack_type = $result->registration_type;
    $current_user_name = $current_user->user_login;
    $reg_amt = $result->registration_amt;
    


    if (isset($_POST['reg_submit']) && wp_verify_nonce($_POST['reg_submit'], 'register_action')) {
        $sponsor = sanitize_text_field($_POST['sname']);
        $user_first_name = sanitize_text_field($_POST['fname']);
        $user_second_name = sanitize_text_field($_POST['lname']);
        $user_address = sanitize_text_field($_POST['address1']);
        $user_city = sanitize_text_field($_POST['city']);
        $user_state = sanitize_text_field($_POST['state']);
        $user_country = sanitize_text_field($_POST['country']);
        $user_zip = sanitize_text_field($_POST['zip']);
        $user_mobile = sanitize_text_field($_POST['contact_no']);
        $user_dob = sanitize_text_field($_POST['date_of_birth']);
        $user_registration_type = sanitize_text_field($_POST['user_registration_type']);

        $the_user = get_user_by('login', $sponsor);
        $user_parent_id = $the_user->ID;

        $invalid_usernames = array('admin');
        $username = sanitize_user($username);

        $user_level = wpmlm_get_user_level_by_parent_id($user_parent_id);
        $user_ref = get_current_user_id();
        $_SESSION['user_ref'] = $user_ref;

        $user_info = get_userdata($user_ref);
        $user_email = $user_info->user_email;
        $_SESSION['user_email'] = $user_email;


        $user_details = array(
            'user_ref_id' => $user_ref,
            'user_parent_id' => $user_parent_id,
            'user_first_name' => $user_first_name,
            'user_second_name' => $user_second_name,
            'user_address' => $user_address,
            'user_city' => $user_city,
            'user_state' => $user_state,
            'user_country' => $user_country,
            'user_zip' => $user_zip,
            'user_mobile' => $user_mobile,
            'user_email' => $user_email,
            'user_dob' => $user_dob,
            'user_level' => $user_level,
            'user_registration_type' => $user_registration_type,
            'join_date' => date("Y-m-d H:i:s"),
            'user_status' => 1,
            'package_id' => $_SESSION['session_pkg_id']
        );


        $_SESSION['user_details'] = $user_details;
        if ($user_registration_type == 'free_join') {
            wp_update_user(array('ID' => $user_ref, 'role' => 'contributor'));
            $success_msg = wpmlm_insert_user_registration_details($user_details);

            if ($success_msg) {
                if ($reg_amt != 0) {
                    wpmlm_insert_leg_amount($user_ref, $_SESSION['session_pkg_id']);
                }
                $form_style = "display:none";
                $tran_pass = wpmlm_getRandTransPasscode(8);
                $hash_tran_pass = wp_hash_password($tran_pass);
                $tran_pass_details = array(
                    'user_id' => $user_ref,
                    'tran_password' => $hash_tran_pass
                );
                wpmlm_insert_tran_password($tran_pass_details);
                wpmlm_insertBalanceAmount($user_ref);
                //sendMailRegistration($user_email, $username, $password, $user_first_name, $user_second_name);
                //sendMailTransactionPass($user_email, $tran_pass);
                unset($_SESSION['session_pkg_id']);
                global $wp;
                $current_url = admin_url();

                $reg_msg = base64_encode('Registration Completed Successfully!');

                wp_redirect($current_url . 'admin.php?page=mlm-user-settings&reg_status=' . $reg_msg);
                exit();
            } else {
                $reg_msg = base64_encode('Sorry! Registration Failed, Please try again');
                wp_redirect($current_url . 'admin.php?page=mlm-user-settings&reg_failed=' . $reg_msg);
                exit();
            }
        }
    }



    if ($user_registration_type == 'paypal') {
        if (isset($_GET['paypal']) == 'checkout') {

            $products = [];

            $products[0]['ItemName'] = sanitize_text_field($_POST['itemname']);
            $products[0]['ItemPrice'] = sanitize_text_field($_POST['itemprice']);
            $products[0]['ItemQty'] = sanitize_text_field($_POST['itemQty']);

            $charges = [];

            //Other important variables like tax, shipping cost
            $charges['TotalTaxAmount'] = 0;
            $charges['HandalingCost'] = 0;
            $charges['InsuranceCost'] = 0;
            $charges['ShippinDiscount'] = 0;
            $charges['ShippinCost'] = 0;

            $paypal->SetExpressCheckOut($products, $charges);
        }
    }


    if ($_GET['token'] != '' && $_GET['PayerID'] != '') {


        $paypal_res = $paypal->DoExpressCheckoutPayment();
        $user_ref = $_SESSION['user_ref'];

        if ('Completed' == $paypal_res["PAYMENTINFO_0_PAYMENTSTATUS"]) {

            if ($_SESSION['user_details']) {

                wp_update_user(array('ID' => $user_ref, 'role' => 'contributor'));
                $success_msg = wpmlm_insert_user_registration_details($_SESSION['user_details']);

                if ($success_msg) {
                    wpmlm_insert_leg_amount($user_ref, $_SESSION['session_pkg_id']);

                    $tran_pass = wpmlm_getRandTransPasscode(8);
                    $hash_tran_pass = wp_hash_password($tran_pass);
                    $tran_pass_details = array(
                        'user_id' => $user_ref,
                        'tran_password' => $hash_tran_pass
                    );
                    wpmlm_insert_tran_password($tran_pass_details);
                    wpmlm_insertBalanceAmount($user_ref);
                    //sendMailRegistration($_SESSION['user_email'],$_SESSION['user_name'],$_SESSION['password'],$_SESSION['user_first_name'],$_SESSION['user_second_name']);                    
                    //sendMailTransactionPass($_SESSION['user_email'], $tran_pass);

                    unset($_SESSION['user_details']);
                    unset($_SESSION['session_pkg_id']);
                    unset($_SESSION['user_email']);

                    $current_url = admin_url();
                    $reg_msg = base64_encode('Registration Completed Successfully!');
                    wp_redirect($current_url . 'admin.php?page=mlm-user-settings&reg_status=' . $reg_msg);
                    exit();
                }
            }
        } else {
            deleteUser($user_ref);
            unset($_SESSION['user_details']);
            unset($_SESSION['session_pkg_id']);
            unset($_SESSION['user_email']);
        }
    } else if (_GET('token') != '') {
        $paypal_res = $paypal->DoExpressCheckoutPayment();
        if ('Failure' == $paypal_res["ACK"]) {

            deleteUser($_SESSION['user_ref']);

            unset($_SESSION['user_details']);
            unset($_SESSION['session_pkg_id']);
            unset($_SESSION['user_second_name']);
            unset($_SESSION['user_email']);
            $reg_msg = base64_encode('Sorry! Registration Failed, Please try again');
            wp_redirect($current_url . 'admin.php?page=mlm-user-settings&reg_failed=' . $reg_msg);
            exit();
        }
    }
    ?>

    <div class="panel-border-heading">
        <h3>WP MLM User Registration</h3>
    </div>
    <div class="ioss-mlm-menu panel-border">
        <input id="ioss-mlm-tab1" class="tab_class" type="radio" name="tabs" checked>
        <label class="tab_class" for="ioss-mlm-tab6">Dashboard</label> 

        <input id="ioss-mlm-tab2" class="tab_class" type="radio" name="tabs">
        <label class="tab_class" for="ioss-mlm-tab2">My Profile</label>      
        <input id="ioss-mlm-tab3" class="tab_class " type="radio" name="tabs">
        <label class="tab_class" for="ioss-mlm-tab3">Genealogy Tree</label>      
        <input id="ioss-mlm-tab4" class="tab_class" type="radio" name="tabs">
        <label class="tab_class" for="ioss-mlm-tab4">E-wallet Management</label>      
        <input id="ioss-mlm-tab5" class="tab_class" type="radio" name="tabs">
        <label class="tab_class" for="ioss-mlm-tab5">Bonus Details</label>
        <input id="ioss-mlm-tab6" class="tab_class" type="radio" name="tabs">
        <label class="tab_class" for="ioss-mlm-tab6">Referral Details</label>
    <!--    <section id="content1"></section>-->

        <div class="col-md-12 panel-border">
            <div class="col-md-6 regOuterDiv">
                <div class="col-md-12">

                    <h4 class="text-center">Please complete the registration to join the MLM network</h4>
                    <form id="regForm" method="post" action="" style="<?php echo $form_style; ?>">
                        <?php echo $success_msg; ?>
                        <?php echo $err_msg; ?>
                        <div class="alert alert-info selected-pkg-info"></div>


                        <?php
                        $step2 = 'STEP 1';
                        $step3 = 'STEP 2';
                        if ($reg_pack_type != 'with_out_package') {

                            $step1 = 'STEP 1';
                            $step2 = 'STEP 2';
                            $step3 = 'STEP 3';
                            ?>

                            <div class="tab"><h1><?php echo $step1; ?>: Select Package</h1>
                                <?php
                                $packages = wpmlm_select_all_packages();
                                if (count($packages) > 0) {
                                    $result2 = wpmlm_get_general_information();
                                    ?>
                                    <p><select name="package_select" oninput="this.className = ''" id="package_select">
                                            <option value="" tabindex="1">Select Package</option>
                                            <?php
                                            $results = wpmlm_select_all_packages();
                                            foreach ($results as $res) {
                                                ?>
                                                <option value="<?php echo $res->id; ?>"><?php echo $res->package_name . ' - ' . $result2->company_currency . $res->package_price; ?>
                                                </option>
                                            <?php } ?>
                                        </select></p>
                                <?php } ?>
                            </div>

                        <?php } ?>

                        <div class="tab"><h1><?php echo $step2; ?>: User Info</h1>
                            <p><input type="text" oninput="this.className = 'required-field'" name="sname" id="sname"  placeholder="* Enter Sponsor Name"  tabindex="2" class="required-field" ></p>                
                            <p><input type="text" oninput="this.className = 'required-field'" name="fname" id="fname" placeholder="* Enter First Name" tabindex="3" class="required-field" ></p>
                            <p><input type="text"  name="lname" id="lname" placeholder=" Enter Last Name" tabindex="4" ></p>

                            <p><input type="text" oninput="this.className = 'required-field'" name="address1" id="address1" placeholder="* Enter Address" tabindex="5" class="required-field"></p>

                            <p oninput="this.className = 'required-field'" name="dob" id="dob"  class="input-group date" data-date-format="yyyy-mm-dd">
                                <input class="form-control date_of_birth required-field" type="text" readonly name="date_of_birth" placeholder="* Enter DOB" tabindex="6"  />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </p>

                            <p><select oninput="this.className = 'required-field'" name="country" id="country" style="width:100%; background-color: #fff;" tabindex="7" class="required-field" >
                                    <?php
                                    $sql = "SELECT id, name FROM {$table_prefix}wpmlm_country  ORDER BY name";
                                    $results = $wpdb->get_results($sql);
                                    echo '<option value=""> * Choose Country</option>';
                                    foreach ($results as $res) {
                                        echo '<option value="' . $res->id . '">' . $res->name . '</option>';
                                    }
                                    ?>
                                </select></p>
                            <p><input type="text" oninput="this.className = ''" name="state" id="state" placeholder=" Enter State" tabindex="8"></p>


                            <p><input type="text" oninput="this.className = ''" name="city" id="city" placeholder=" Enter City" tabindex="9"></p>
                            <p><input type="number" oninput="this.className = ''" name="zip" id="zip" placeholder=" Enter Zip Code" onkeypress="return isNumberKey(event)" tabindex="8"></p>


                            <p><input type="number" oninput="this.className = 'required-field'" name="contact_no" id="contact_no" placeholder="* Enter Contact No" onkeypress="return isNumberKey(event)" tabindex="10" class="required-field"></p>



                        </div>
                        <div class="tab"><h1><?php echo $step3; ?>: Payment Mode</h1>

                            <div class="row" style="font-size:18px">
                                <?php
                                if ($reg_pack_type != 'with_out_package') {
                                    echo '<div class="col-sm-12"><p>Package Amount: ' . $result->company_currency . '<span id="amount_span"><span></p></div>';
                                } else {
                                    echo '<p>Registration Amount: ' . $result->company_currency . '<span id="amount_span">' . $result->registration_amt . '<span></p>';
                                }
                                ?>
                            </div>
                            <?php
                            $results = wpmlm_select_reg_type();
                            $ckd = 0;
                            $reg_type = 'paypal';
                            foreach ($results as $res) {
                                $ckd++;
                                if ($ckd == 1) {
                                    $ckd = 'checked';
                                } else {
                                    $ckd = '';
                                }
                                ?>




                                <div class="row">

                                    <?php if ($res->reg_type == 'free_join') { ?>
                                        <div class="col-md-1"><input <?php echo $ckd; ?> type="radio"   value="<?php echo $res->reg_type; ?>" name="user_registration_type" class="free_join radiobutton" tabindex="1"> </div>
                                        <div class="col-md-4"><label><?php echo ucwords(str_replace("_", " ", $res->reg_type)); ?></label></div>


                                        <?php
                                        $reg_type = '';
                                    } else {
                                        ?> 
                                        <div class="col-md-1" style="margin-top: 15px;"><input <?php echo $ckd; ?> type="radio"   value="paypal" name="user_registration_type" class="paid_join radiobutton" tabindex="2"> </div>
                                        <div class="col-md-4"><img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/gateway/paypal/paypal.png'; ?>"></div>

                                    <?php } ?>


                                    <div class="col-md-7"></div>
                                </div>
                            <?php } ?>

                        </div>

                        <div class="reg-next-prev-div-outer">
                            <div class="col-md-12 please-wait" ><img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/images/please-wait.gif'; ?>"></div>
                            <div class="reg-next-prev-div">
                                <button type="button"  class="btn" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button"  class="btn btn-danger" id="nextBtn"   onclick="nextPrev(1)" tabindex="18">Next</button>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        <div class="reg-steps-circle">
                            <span class="step"></span>
                            <span class="step"></span>
                            <?php if ($reg_pack_type == 'with_package') { ?>
                                <span class="step"></span>
                            <?php } ?>
                        </div>


                        <input type="hidden" id="payment_option" name="payment_option" value="<?php echo $reg_type; ?>" >
                        <input type="hidden" id="itemname" name="itemname" value="<?php echo ($reg_pack_type == 'with_out_package' ? 'Registration Fee' : ''); ?>" /> 
                        <input type="hidden" id="itemprice" name="itemprice" value="<?php echo ($reg_pack_type == 'with_out_package' ? $result->registration_amt : ''); ?>" />
                        <input type="hidden" name="itemQty" value="1" />
                        <input type="hidden" name="field_valid" id="field_valid" value="" />
                        <input type="hidden" name="admin-path" id="admin-path" value="<?php echo admin_url(); ?>">  

                        <?php wp_nonce_field('register_action', 'reg_submit'); ?> 
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>


        jQuery("#dob").datepicker({
            autoclose: true
        });

        //jQuery(document).ready(function ($) {
            jQuery(".paid_join").click(function () {
                if (jQuery(".paid_join").is(':checked')) {
                    jQuery("#payment_option").val(jQuery(this).val());

                }
            });


            jQuery(".free_join").click(function () {
                if (jQuery(".free_join").is(':checked')) {
                    jQuery("#payment_option").val('');

                }
            });
        //});

        var currentTab = 0;
        showTab(currentTab);
        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            fixStepIndicator(n)
        }

        function nextPrev(n) {

            var pkg_id = jQuery('#package_select').val();
            if (pkg_id) {
                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {action: 'wpmlm_ajax_session', session_pkg_id: pkg_id},
                    dataType: 'json',
                    success: function (data) {
                        jQuery(".selected-pkg-info").html("Selected Package is : " + data.package_name);
                        jQuery("#itemname").val(data.package_name);
                        jQuery("#itemprice").val(data.package_price);
                        jQuery("#amount_span").html(data.package_price);

                    }

                });

            } else {

                jQuery("#err_msg").html('Please select a package');
                jQuery(".selected-pkg-info").hide();
                jQuery(".selected-pkg-info").html("");
    <?php $_SESSION['session_pkg_id'] = NULL; ?>
            }

            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm1())
                //alert("sds");
                return false;

            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {

                var payment_option = jQuery('#payment_option').val();
                if (payment_option == 'paypal') {
                    var action = jQuery('#regForm').attr('action');
                    var admin_path = jQuery('#admin-path').val();
                    jQuery('#regForm').attr('action', admin_path + "admin.php?page=mlm-user-settings&paypal=checkout");

                }
                document.getElementById("regForm").submit();
                jQuery('.please-wait').show();
                return false;
            }
            showTab(currentTab);
        }

        function validateForm1() {
            //alert("sdsd");

            var x, y, z, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            z = x[currentTab].getElementsByTagName("select");


            for (i = 0; i < y.length; i++) {


                if (y[i].classList.contains('required-field')) {

                    if (y[i].value == '') {


                        y[i].className += " invalid";
                        valid = false;

                    }

                }
            }

            for (i = 0; i < z.length; i++) {
                if (z[i].value == '') {
                    z[i].className += " invalid";
                    valid = false;
                }
            }

            if (jQuery("#sname").hasClass("invalid")) {
                valid = false;
            }

            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }

            return valid;

        }

        function fixStepIndicator(n) {
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            x[n].className += " active";
        }

        jQuery('#package_select').on('change', function () {
            if (jQuery(this).val() == '') {
                jQuery(".selected-pkg-info").hide();
            }

        });




        jQuery(".required-field").focus(function () {
            jQuery(this).removeClass("invalid");
        })

    </script>   

    <?php
}
