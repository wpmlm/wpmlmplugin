<?php
function wpmlm_payment_options() {
    $result = wpmlm_get_paypal_details();    
    $result1 = wpmlm_select_reg_type_name();
    $arr = explode(',', $result1->reg_type);
    $result2 = wpmlm_get_general_information();
    ?>
    <div id="registration-type-settings">
        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square"></i> <span> Payment Settings</span></h4>
                             
                         </div>

        <div class="panel-border">
            <h5>Registration Type</h5>
            <div class="submit-message1"></div>
            <form id="registration-type-settings-form" class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-2">
                        <input class="form-control reg_type reg_type_checkbox" name="reg_type[]" type="checkbox" <?php
                        if (in_array('free_join', $arr)) {
                            echo 'checked';
                        }
                        ?> value="free_join">
                        <label class="control-label" for="free_join">Free Join</label>

                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-2">
                        <input class="form-control reg_type reg_type_checkbox" name="reg_type[]"  type="checkbox"value="paid_join" id="paid_join" <?php
                        if (in_array('paid_join', $arr)) {
                            echo 'checked';
                        }
                        ?>>
                        <label class="control-label" for="paid_join">Paid Join</label>

                    </div>

                </div>
                <div class="form-group"> 
                    <div class="col-sm-2">
                        <button  name="reg-type-submit" class="btn btn-danger" id="reg-type-submit">Save</button>
                    </div>
                </div>
    <?php wp_nonce_field('register_action', 'reg_submit'); ?>
            </form>
        </div>

    
    <?php if (in_array('paid_join', $arr)) {
        $style="display:block;";       
        }else{
           $style="display:none;";
        } ?>
<div id="paypal-settings" style=<?php echo $style;?> >
            <div class="panel-border">
                <h3><img src=<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/gateway/paypal/paypal.png'; ?>></h3>
                         <h5>PayPal API Credentials</h5>
                         <div class="submit-message"></div>
                    <form id="payment-type-settings-form" class="form-horizontal " method="post">


                        <div class="form-group">
                            <div class="col-md-2"><label class="control-label" for="paypal_username">API Username</label></div>

                            <div class="col-md-6">
                                <input class="paypal_input form-control reg_type" name="paypal_username"  type="text"placeholder="API Username" value="<?php echo $result->paypal_api_username; ?>">
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-2"><label class="control-label" for="paypal_Password">API Password</label></div>

                            <div class="col-md-6">
                                <input class="paypal_input form-control reg_type" name="paypal_password"  type="text"placeholder="API Password" value="<?php echo $result->paypal_api_password; ?>">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-2"><label class="control-label" for="paypal_signature">API Signature</label></div>

                            <div class="col-md-6">

                                <input class="paypal_input form-control reg_type" name="paypal_signature"  type="text"placeholder="API Signature" value="<?php echo $result->paypal_api_signature; ?>" >
                            </div>

                        </div>



                        <div class="form-group">
                            <div class="col-md-2"><label class="control-label" for="paypal_currency">Currency</label></div>

                            <div class="col-md-2">

                                <input readonly="" class=" form-control" name="paypal_currency"  type="text"  value="USD ($)" style="background-color: #eaeaea;">
                            </div>

                        </div>



                        <div class="form-group">
                            <div class="col-md-2"><label class="control-label" for="paypal_mode">Paypal Mode</label></div>
                            <div class="col-md-2">
                                <input class="form-control reg_type" name="paypal_mode" type="radio" <?php
        if ($result->paypal_mode == 'sandbox') {
            echo 'checked';
        }
        ?> checked value="sandbox"  ><label class="control-label" for="test">&nbsp;Sandbox</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control reg_type" name="paypal_mode" type="radio"  value="live" <?php
                               if ($result->paypal_mode == 'live') {
                                   echo 'checked';
                               }
                               ?> ><label class="control-label" for="live">&nbsp;Live</label>
                            </div>


                        </div>


                        <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-2">
                                <button  name="payment-type-submit" class="btn btn-danger" id="payment-type-submit">Save</button>
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $result2->registration_type;?>" id="reg_type">
        <?php wp_nonce_field('payment_action', 'payment_submit'); ?>
                    </form>
            </div>
        </div>

        </div>
    </div>
    
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click','#paid_join',function () {
                
                if ($("#paid_join").is(':checked')) {                                       
                    $("#paypal-settings").show();
                } else {
                    $("#paypal-settings").hide();
                }
            });          

            
            var plugin_url = path.pluginsUrl;
            
            
            
            $("#registration-type-settings-form").submit(function () {
                $(".submit-message1").show(); 
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_payment_option');
                
                isValid = true;
                
                if ($('.reg_type:checkbox:checked').length == 0) {
                    $(".submit-message1").html('<div class="alert alert-danger">Please select atleast one registration type</div>');
                    setTimeout(function () {
                             $(".submit-message1").hide('slow');   

                            }, 3000);
                    
                    isValid = false;
                }                      

                if (isValid) {
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $(".submit-message1").show();
                            $(".submit-message1").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $(".submit-message1").hide();
                            }, 2000);
                        }
                    });
                }
                return false;
            });
            
            $("#payment-type-settings-form").submit(function () {
                isValid = true;
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_payment_option');
                $(".paypal_input").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });

                if (isValid) {
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $(".submit-message").show();
                            $(".submit-message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $(".submit-message").hide();
                            }, 2000);
                        }
                    });
                }
                return false;
            })

        });

    </script>
<?php
}
