<?php

function wpmlm_ewallet_management() {
    ?>
    <div class="panel-border-heading">
        <h4><i class="fa fa-suitcase" aria-hidden="true"></i> E-Wallet Management</h4>
    </div>
    <div id="all-reports">
        <div class="panel-border col-md-12">
            <div id="exTab4">
                <div class="col-md-3">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left">
                        <li class="active"><a href="#fund-management" data-toggle="tab" class="fund_management">Fund Management</a></li>
                        <li><a href="#fund-transfer" data-toggle="tab" class="fund-transfer">Fund Transfer</a></li>
                        <li><a href="#transfer-details" data-toggle="tab" class="transfer-details">Transfer Details</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="fund-management">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h4><i class="fa fa-external-link-square"></i> <span> Fund Management</span></h4>

                                </div>
                                <div class="panel-border">
                                    <div class="submit_message"></div>
                                    <form id="fund-management-form" class="form-horizontal " method="post">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 user-dt" for="ewallet_user_name">User Name:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control fund_input" name="ewallet_user_name" id="ewallet_user_name" placeholder="Enter User Name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 user-dt" for="fund_amount">Amount:</label>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control fund_input" name="fund_amount" id="fund_amount" placeholder="Enter Amount">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 user-dt" for="transaction_note">Transaction Note:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control fund_input" name="transaction_note" id="transaction_note" placeholder="Enter Transaction Note">
                                            </div>
                                        </div>



                                        <div class="form-group"> 
                                            <div class="col-sm-offset-3 col-lg-6 col-sm-6 col-md-6 col-xs-6 fund-manage-btn">
                                                <?php wp_nonce_field('fund_management_add', 'fund_management_add_nonce'); ?>
                                                <input type="hidden" name="fund_action" class="fund-action" value="">
                                                <button id="fund-management-add" type="submit" class="btn btn-danger fund-management-button" data-title="admin_credit"> Add</button>
                                                <button id="fund-management-deduct" type="submit" class="btn btn-danger fund-management-button" data-title="admin_debit"> Deduct</button>
                                            </div>
                                        </div>
                                    </form>  
                                </div>
                            </div>
                        </div>
                        <!-- Tab 2 Content-->
                        <div class="tab-pane" id="fund-transfer">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4><i class="fa fa-external-link-square"></i> <span> Fund Transfer</span></h4>

                                </div>
                                <div class="panel-border">
                                    <div class="submit_message"></div>
                                    <form id="fund-transfer-form" class="form-horizontal " method="post">
                                        <div id="fund-step-1">
                                            <div class="form-group">
                                                <label class="control-label  col-md-4 user-dt">Step 1 :</label><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 user-dt" for="ewallet_user_name1">User Name:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control fund_transfer_input" name="ewallet_user_name" id="ewallet_user_name1" placeholder="Enter Username" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group balance_amount_div" style="display: none">
                                                <label class="control-label col-md-3 user-dt" for="balance_amount">Balance Amount:</label>
                                                <div class="col-md-6">
                                                    <label class="control-label  balance_amount" for="balance_amount" style="float:left;"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 user-dt" for="ewallet_user_name_to">Transfer To (User Name):</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control fund_transfer_input" name="ewallet_user_name_to" id="ewallet_user_name_to" placeholder="Enter transfer to" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 user-dt" for="fund_amount">Amount:</label>
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control fund_transfer_input" name="fund_transfer_amount" id="fund_transfer_amount" placeholder="Enter Amount">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 user-dt" for="transaction_note">Transaction Note:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control fund_transfer_input" name="transaction_note1" id="transaction_note1" placeholder="Enter Transaction Note">
                                                </div>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="col-sm-offset-3 col-sm-6 fund-transfer-btn">
                                                    <input type="hidden" name="fund_action" class="fund-action" value="">
                                                    <button id="fund-transfer-continue"  class="btn btn-danger fund-transfer-continue" > Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="fund-step-2" style="display: none"> 
                                            <div class="form-group">
                                                <label class="control-label  col-md-4">Step 2</label><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 user-dt" for="ewallet_balance">Ewallet Balance :</label><label class="control-label col-md-2 ewallet_balance" style="text-align:left;"></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 user-dt" for="ewallet_user_name_to">Receiver:</label><label class="control-label col-md-2 ewallet_user_name_to" style="text-align:left;"></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 user-dt" for="amount_to_transfer">Amount to transfer :</label><label class="control-label col-md-2 amount_to_transfer" style="text-align:left;"></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 user-dt" for="transaction_note">Transaction Note :</label><label class="control-label col-md-8 transaction_note" style="text-align:left;"></label></div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4 user-dt" for="transaction_password">Transaction Password:</label>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" name="transaction_password" id="transaction_password" placeholder="Enter Transaction Password">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group"> 
                                                <div class="col-sm-offset-4 col-sm-6">                                                
                                                    <button id="fund-transfer-send" type="submit" class="btn btn-danger fund-transfer-send" > Send</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php wp_nonce_field('fund_transfer_add', 'fund_transfer_add_nonce'); ?>   
                                    </form> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="transfer-details">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4><i class="fa fa-external-link-square"></i> <span> Transfer Details</span></h4>

                                </div>
                                <div class="panel-border">
                                    <form name="transfer-details-form" id="transfer-details-form">
                                        <div id="transfer-date-error"></div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 user-dt" for="search1">User Name:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="transfer_input form-control typeahead" name="search1" id="search1" placeholder="search" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"><div class="form-group ewallet-date">
                                                <label class="control-label col-md-3 user-dt" for="start_date1">
                                                    From Date: <span class="symbol required"></span>
                                                </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker transfer_input" name="start_date1" id="start_date1" type="text" tabindex="3" size="20" maxlength="10" value="">
                                                        <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                                    </div>                       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><div class="form-group ewallet-date" style="margin-top: 0px !important;">
                                                <label class="control-label col-md-3 user-dt" for="end_date1">
                                                    To Date:<span class="symbol required"></span>
                                                </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker transfer_input" name="end_date1" id="end_date1" type="text" tabindex="4" size="20" maxlength="10" value="">
                                                        <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                                    </div>                        
                                                </div>
                                            </div>                        
                                        </div>
                                        <div class="row"><div class="form-group"> 
                                                <div class="col-sm-offset-3 col-sm-6 transfer-details-btn"> 
                                                    <?php wp_nonce_field('transfer_details', 'transfer_details_nonce'); ?>
                                                    <button class="btn btn btn-danger" tabindex="5" name="weekdate" type="submit" value="Submit"> Submit</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Transfer Details Ajax Data Start-->
                <div class="clearfix"></div>
                <div class="row" style="margin-top:20px;display:none;" id="tranfer-detail-main-div">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square"></i> <span class="tranfer-detail-caption"></span></h4>

                            </div>
                            <div class="no-data"></div>
                            <div  id="profile_print_area" style="overflow: auto; padding: 10px;" class="transfer-details-data" >
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Transfer Details Ajax Data End-->
            </div>
        </div>
    </div>
    <script>
        jQuery("#start_date1").datepicker({
            autoclose: true
        });
        jQuery("#end_date1").datepicker({
            autoclose: true
        });
        jQuery(document).ready(function ($) {

            $("#exTab4 li").click(function () {
                $("#tranfer-detail-main-div").hide();
            });
            

            $("#ewallet_user_name,#ewallet_user_name1,#ewallet_user_name_to").change(function () {

                var id = $(this).attr('id');
                $(".err_msg").remove();

                var ewallet_user_name = $(this).val();
                if (id == 'ewallet_user_name1') {

                    $.ajax({
                        type: "post",
                        url: ajaxurl,
                        data: {'ewallet_user_balance': ewallet_user_name,'action':'wpmlm_ajax_ewallet_management'},
                        success: function (data) {
                            if ($.trim(data) != "no-data") {
                                $(".balance_amount_div").show();
                                $(".balance_amount").html(data);
                            } else {
                                $(".balance_amount_div").hide();
                            }

                        }
                    });
                }
            });

            $('.fund-transfer-continue').click(function () {
                isValid = true;
                $(".submit_message").show();
                $(".submit_message").html('');
                var ewallet_user_name1 = $("#ewallet_user_name1").val();
                var ewallet_user_name_to = $("#ewallet_user_name_to").val();

                $(".fund_transfer_input").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        $(this).addClass("invalid");
                        isValid = false;
                    }

                });


                var amount = parseInt($("#fund_transfer_amount").val());
                var bal_amount = parseInt($(".balance_amount").html());
                if (bal_amount < amount) {
                    $("#fund_transfer_amount").addClass("invalid");
                    isValid = false;
                }

                if (bal_amount == 0) {
                    $(".submit_message").html('<div class="alert alert-danger">Insufficient Balance</div>');
                    setTimeout(function () {
                        $(".submit_message").hide();
                    }, 2000);
                    isValid = false;
                }
                if (($("#ewallet_user_name1").val() != '') && ($("#ewallet_user_name1").val() == $("#ewallet_user_name_to").val())) {
                    $(".submit_message").html('<div class="alert alert-danger">OOPS! Wrong receiver </div>');
                    setTimeout(function () {
                        $(".submit_message").hide();
                    }, 2000);
                    isValid = false;
                }

                if (isValid) {
                    $("#fund-step-1").hide();
                    $("#fund-step-2").show();
                    $('.ewallet_balance').html($(".balance_amount").html());
                    $('.ewallet_user_name_to').html($("#ewallet_user_name_to").val());
                    $('.amount_to_transfer').html($("#fund_transfer_amount").val());
                    $('.transaction_note').html($("#transaction_note1").val());

                }
                return false;
            });


            $(".fund_transfer_input").focus(function () {
                $(this).removeClass("invalid");
            })

            $('.fund-management-button').click(function () {
                var action = $(this).attr("data-title");
                $(".fund-action").val(action);
            });


            // Fund Management Ajax Function

            
            $("#fund-management-form").submit(function () {
                $(".submit_message").html('');
                $(".submit_message").show();
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_ewallet_management');
                isValid = true;
                $(".fund_input").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });

                if (isValid) {
                    $('#fund-management-add').prop('disabled', true);
                    $('#fund-management-deduct').prop('disabled', true);
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {


                            $(".submit_message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $(".submit_message").hide();
                                $("#fund-management-form")[0].reset();
                                $('#fund-management-add').prop('disabled', false);
                                $('#fund-management-deduct').prop('disabled', false);

                            }, 2000);
                        }
                    });
                }
                return false;
            })
            $(".fund_input").focus(function () {
                $(this).removeClass("invalid");
            })


            // Fund Transfer Ajax Function

            
            $("#fund-transfer-form").submit(function () {
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_ewallet_management');
                isValid = true;

                if ($("#transaction_password").val() == '') {
                    $("#transaction_password").addClass("invalid");
                    isValid = false;
                }
                if (isValid) {
                    $('#fund-transfer-send').prop('disabled', true);
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if ($.trim(data) === "0") {
                                $(".submit_message").html('<div class="alert alert-danger">Incorrect Transaction Password</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();

                                }, 2000);

                            } else {

                                $(".submit_message").show();
                                $(".submit_message").html('<div class="alert alert-info">' + data + '</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();
                                    $("#fund-transfer-form")[0].reset();
                                    $("#fund-step-1").show();
                                    $("#fund-step-2").hide();
                                    $(".balance_amount_div").hide();


                                }, 2000);

                            }
                            $('#fund-transfer-send').prop('disabled', false);
                        }
                    });
                }
                return false;
            })

            $("#transaction_password").focus(function () {
                $(this).removeClass("invalid");
            })



            // Fund Transfer Details Ajax Function

            
            $("#transfer-details-form").submit(function () {

                //$(".submit_message").show();
                $("#transfer-date-error").html('');

                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_ewallet_management');
                isValid = true;

                $(".transfer_input").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });


                var startDate = new Date($('#start_date1').val());
                var endDate = new Date($('#end_date1').val());

                if (startDate > endDate) {
                    $("#transfer-date-error").html('<p style="color:red">You must select an end date greater than start date</p>');
                    $("#tranfer-detail-main-div").hide();
                    return false;
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

                            $("#tranfer-detail-main-div").show();
                            $(".tranfer-detail-caption").html('Transfer Details');
                            $(".transfer-details-data").html(data);
                            $("#transfer-details-form")[0].reset();

                        }
                    });
                }
                return false;
            })

            $(".transfer_input").focus(function () {
                $(this).removeClass("invalid");
            });

        });

    </script>    
    <?php
}
