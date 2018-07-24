<?php

function wpmlm_password_settings() {
    ?>
    <div class="panel-border-heading">
        <h4><i class="fa fa-cog" aria-hidden="true"></i> Password Settings</h4>
    </div>
    <div id="general-settings">
        <div class="panel-border col-md-12">
            <div   id="exTab4">
                <div class="col-md-3 ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left">



                        <li class="active"><a href="#change-password" data-toggle="tab">Change User Password</a></li>

                        <li><a href="#send-tran-pass" data-toggle="tab">Send Transaction Password</a></li>
                        <li><a href="#change-tran-pass" data-toggle="tab">Change Admin Transaction<br> Password</a></li>
                    </ul>
                </div>

                <div class="col-md-9">
                    <!-- Tab panes -->
                    <div class="tab-content">


                        <div class="tab-pane active" id="change-password">
                                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square"></i> <span> Change User Password</span></h4>
                    
                </div>
                            <div id="user-password-form-message"></div>
                            <div class="panel-border">


                                <form id="user-password-form" class="form-horizontal " method="post">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="user_name">Username:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="password-input form-control" name="username_pwd" id="username_pwd" autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="password_user">New Password:</label>
                                        <div class="col-md-6">
                                            <input type="password" class="password-input form-control" name="password_user" id="password_user">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="confirm_password">Confirm Password:</label>
                                        <div class="col-md-6">
                                            <input type="password" class="password-input form-control confirm_password" name="confirm_password_user" id="confirm_password_user">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <?php wp_nonce_field('user_password_admin', 'user_password_admin_nonce'); ?>
                                            <button class="btn btn-danger user_password_save" type="submit" name="user_password_save" id="user_password_save">
                                                Save 
                                            </button>
                                        </div>

                                    </div>                        
                                </form> 
                            </div>   
                        </div> 
                    </div>



                        <div class="tab-pane" id="send-tran-pass">
                                       <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square"></i> <span> Send Transaction Password</span></h4>
                    
                </div>
                            <div class="panel-border">
                                <div class="submit_message"></div>
                                <p style="color: #31afde">Note : Transaction password will be sent to user's Registered Email id</p>
                                <form id="send-tran-pass-form" class="form-horizontal " method="post">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="tran_user_name">User Name:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="tran_user_name" id="tran_user_name">
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <?php wp_nonce_field('send_tran_pass', 'send_tran_pass_nonce'); ?>

                                            <button id="send-tran-pass-button" type="submit" class="btn btn-danger send-tran-pass-button" > Send Password</button>

                                        </div>
                                    </div>
                                </form>  

                            </div>
                        </div>
                    </div>

                        <!-- Tab 2 Content-->
                        <div class="tab-pane" id="change-tran-pass">
           <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square"></i> <span> Change Admin Transaction Password</span></h4>
                    
                </div>
                            <div class="panel-border">
                                <div class="submit_message"></div>

                                <form id="change-tran-pass-form" class="form-horizontal " method="post">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="current_tran_pass">Current Password:</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control admin_tran_input" name="current_tran_pass" id="current_tran_pass">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="new_tran_pass">New Password:</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control admin_tran_input" name="new_tran_pass" id="new_tran_pass" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 user-dt" for="confirm_tran_pass">Confirm New Password:</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control admin_tran_input" name="confirm_tran_pass" id="confirm_tran_pass">
                                        </div>
                                    </div>



                                    <div class="form-group"> 
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <?php wp_nonce_field('change_tran_pass', 'change_tran_pass_nonce'); ?>

                                            <button id="change-tran-pass-button" type="submit" class="btn btn-danger change-tran-pass-button"> Update</button>

                                        </div>
                                    </div>
                                </form>   
                            </div>

</div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div> 

    <script>
        jQuery(document).ready(function ($) {

            // Send transaction password

            
            $("#send-tran-pass-form").submit(function () {
                $(".submit_message").html('');
                $(".submit_message").show();
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_transaction_password');
                isValid = true;
                if ($("#tran_user_name").val()== '' ) {
                    $("#tran_user_name").addClass("invalid");
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
                            //alert(data);

                            if ($.trim(data) === "1") {
                                $(".submit_message").html('<div class="alert alert-info">Transaction Password Sent Successfully</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();
                                    $("#change-tran-pass-form")[0].reset();

                                }, 3000);

                            } else {

                                $(".submit_message").html('<div class="alert alert-danger">' + data + '</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();

                                }, 3000);
                            }

                        }
                    });
                }
                return false;
            });



            // Admin transaction password change

           
            $("#change-tran-pass-form").submit(function () {
                $(".submit_message").html('');
                $(".submit_message").show();
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_transaction_password');
                isValid = true;
                $(".admin_tran_input").each(function () {
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

                            if ($.trim(data) === "1") {
                                $(".submit_message").html('<div class="alert alert-info">Transaction Password Updated</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();
                                    $("#change-tran-pass-form")[0].reset();

                                }, 3000);

                            } else {

                                $(".submit_message").html('<div class="alert alert-danger">' + data + '</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();

                                }, 3000);
                            }

                        }
                    });
                }
                return false;
            });
            $(".admin_tran_input,.user_tran_input,#tran_user_name").focus(function () {
                $(this).removeClass("invalid");
            });

            // User transaction password change

            
            
            $("#change-user-tran-pass-form").submit(function () {
                $(".submit_message").html('');
                $(".submit_message").show();
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_transaction_password');
                isValid = true;
                $(".user_tran_input").each(function () {
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

                            if ($.trim(data) === "1") {
                                $(".submit_message").html('<div class="alert alert-info">Transaction Password Updated</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();
                                    $("#change-user-tran-pass-form")[0].reset();

                                }, 3000);

                            } else {

                                $(".submit_message").html('<div class="alert alert-danger">' + data + '</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();

                                }, 3000);
                            }
                        }
                    });
                }
                return false;
            });



            $(document).on('submit', '#user-password-form', function () {
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_transaction_password');
                isValid = true;
                $(".password-input").each(function () {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });
                
                var pass = $("#password_user").val();
                var confirm_password = $("#confirm_password_user").val();
                if (pass.length < 6) {
                  isValid = false;
                }
                
                
                if (confirm_password != pass && confirm_password != '') {
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

                            $("#user-password-form")[0].reset();
                            $("#user-password-form-message").show();
                            $("#user-password-form-message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $("#user-password-form-message").hide();
                                //window.location.href = site.siteUrl + '/user-login/';
                            }, 1000);

                        }

                    });
                }
                return false;
            });

            $(".user-input").focus(function () {
                $(this).removeClass("invalid");
            });
            $(".password-input").focus(function () {
                $(this).removeClass("invalid");
            });


        });
    </script>
    
    <?php
}
