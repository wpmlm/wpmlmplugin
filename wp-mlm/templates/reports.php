<?php

function wpmlm_all_reports() {
    $user = get_user_by('id', $user_id);
    ?>
    <div class="panel-border-heading">
        <h4><i class="fa fa-file-text-o" aria-hidden="true"></i> Reports</h4>
    </div>
    <div id="all-reports">
        <div class="panel-border col-md-12">

            <div  class="reports" id="exTab4">
                <div class="col-md-3 ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left report_ul">
                        <li class="active "><a href="#profile" data-toggle="tab" id="profile_report">Profile Report</a></li>
                        <li><a href="#joining" data-toggle="tab" id="joining_report">Joining Report</a></li>
                        <li><a href="#commission" data-toggle="tab" id="commission_report">Bonus Report</a></li>
                    </ul>
                </div>


                <div class="col-md-9">
                    <!-- Tab panes -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-external-link-square"></i> <span class="report-caption"> Profile Report</span></h4>

                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="profile">


                                <div class="panel-border">
                                    <div class="submit_message"></div>

                                    <form id="profile-report-search" name="profile-report-search" class="search-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="radio" name="profile_report_sel" checked value="user_name"><label style="margin: 10px">User Name</label>
                                                <input name="profile_report_sel" type="radio" value="all"><label style="margin: 10px">All</label>
                                            </div>


                                            <div class="col-md-4">

                                                <input type="text" class="search_input form-control typeahead" name="search" id="search" placeholder="search" autocomplete="off">
                                            </div>
                                            <div class="col-md-2"> 
                                                <button type="submit" class="btn btn-danger">Search</button>


                                            </div>

                                        </div>

                                    </form>

                                </div>
                            </div>

                            <!-- Tab 2 Content-->
                            <div class="tab-pane" id="joining">

                                <div class="panel-border">
                                    <div class="row">
                                        <form name="joining-report-search" id="joining-report-search">
                                            <div id="date-error"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="week_date1">
                                                    From Date: <span class="symbol required"></span>
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker date_input" name="start_date" id="start_date" type="text" tabindex="3" size="20" maxlength="10" value="">
                                                        <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                                    </div>                        </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="week_date2">
                                                    To Date:<span class="symbol required"></span>
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker date_input" name="end_date" id="end_date" type="text" tabindex="4" size="20" maxlength="10" value="">
                                                        <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                                    </div>                        </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2 ">
                                                    <?php wp_nonce_field('joining_report', 'joining_report_nonce'); ?>
                                                    <button class="btn btn btn-danger" tabindex="5" name="weekdate" type="submit" value="Submit"> Submit</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>



                            </div>
                            <div class="tab-pane" id="commission">

                                <div class="panel-border">
                                    <div class="row">
                                        <form name="commission-report-search" id="commission-report-search">
                                            <div id="commission-date-error"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="week_date1">
                                                    From Date: <span class="symbol required"></span>
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker commission_date_input" name="commission_start_date" id="commission_start_date" type="text" tabindex="3" size="20" maxlength="10" value="">
                                                        <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                                    </div>                        </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="week_date2">
                                                    To Date:<span class="symbol required"></span>
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker commission_date_input" name="commission_end_date" id="commission_end_date" type="text" tabindex="4" size="20" maxlength="10" value="">
                                                        <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                                    </div>                        </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-2 ">
                                                    <?php wp_nonce_field('commission_report', 'commission_report_nonce'); ?>
                                                    <button class="btn btn btn-danger" tabindex="5" name="commission" type="submit" value="Submit"> Submit</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row" style="margin-top:20px; display: none" id="report-main-div">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i><span class="report-caption"></span> <div id = "frame" >
                                                                        

                                </div>

                            </div>
                            <div style="overflow: auto; padding: 10px;"><div class="no-data"></div></div>
                            <div  id="print_area" style="overflow: auto; padding: 10px;" class="report-data" >
                            </div>

                        </div>
                    </div>
                </div>





            </div>

        </div>
    </div>

    <script>

        default_profile_data();


        function default_profile_data() {

            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action: 'wpmlm_ajax_profile_report', default_profile: "profile_report_all"},
                cache: false,
                success: function (data) {


                    jQuery("#date-error").html('');
                    jQuery("#report-main-div").show();
                    jQuery(".report-caption").html(' Profile Report');
                    if (jQuery.trim(data) === "0") {
                        jQuery(".no-data").show();
                        jQuery(".report-data").html('');
                        jQuery(".print-div").hide();
                        jQuery(".no-data").html('No Data');


                    } else {
                        jQuery("#report-main-div").show();
                        jQuery(".report-data").html(data);
                        jQuery(".print-div").show();
                        jQuery(".no-data").hide();
                    }
                }


            });

        }


        function default_joining_data() {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action: 'wpmlm_ajax_joining_report', default_joining: "joining_report_all"},
                cache: false,
                success: function (data) {


                    jQuery("#date-error").html('');
                    jQuery("#report-main-div").show();
                    jQuery(".report-caption").html(' Joining Report');
                    if (jQuery.trim(data) === "0") {
                        jQuery(".no-data").show();
                        jQuery(".report-data").html('');
                        jQuery(".print-div").hide();
                        jQuery(".no-data").html('No Data');


                    } else {
                        jQuery("#report-main-div").show();
                        jQuery(".report-data").html(data);
                        jQuery(".print-div").show();
                        jQuery(".no-data").hide();
                    }
                }


            });

        }



        function default_commission_data() {

            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action: "wpmlm_ajax_bonus_report", default_commission: 'commission_report_all'},
                cache: false,
                success: function (data) {
                    jQuery("#date-error").html('');
                    jQuery("#report-main-div").show();
                    jQuery(".report-caption").html(' Bonus Report');
                    if (jQuery.trim(data) === "0") {
                        jQuery(".no-data").show();
                        jQuery(".report-data").html('');
                        jQuery(".print-div").hide();
                        jQuery(".no-data").html('No Data');


                    } else {
                        jQuery("#report-main-div").show();
                        jQuery(".report-data").html(data);
                        jQuery(".print-div").show();
                        jQuery(".no-data").hide();
                    }
                }


            });

        }


        jQuery(document).ready(function ($) {


            $(document).on("click", "#profile_report", function () {
                default_profile_data();
            });

            $(document).on("click", "#joining_report", function () {
                default_joining_data();
            });

            $(document).on("click", "#commission_report", function () {
                default_commission_data();
            });



            $(".reports li").on("click", function () {
                $("#report-main-div").hide();
            })



            $("#profile-report-search").submit(function () {
                $(".submit_message").html('');
                $(".submit_message").show();
                var search_type = $('input[name=profile_report_sel]:checked').val();
                var search = $('#search').val();
                isValid = true;
                if (search_type == 'user_name') {
                    if (search == "") {
                        $('#search').addClass("invalid");
                        isValid = false;
                    }

                }

                if (isValid) {
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: {search: search, search_type: search_type, action: 'wpmlm_ajax_profile_report'},
                        cache: false,
                        success: function (data) {
                            $("#search").val('');
                            $("#date-error").html('');
                            $("#report-main-div").show();
                            $(".report-caption").html(' Profile Report');
                            if ($.trim(data) === "0") {
                                $(".no-data").show();
                                $(".report-data").html('');
                                $(".print-div").hide();
                                $(".no-data").html('No Data');


                            } else if ($.trim(data) === "no-user") {
                                $("#report-main-div").hide();
                                $(".submit_message").html('<div class="alert alert-danger">User name not exists</div>');
                                setTimeout(function () {
                                    $(".submit_message").hide();


                                }, 3000);
                            } else {
                                $("#report-main-div").show();
                                $(".report-data").html(data);
                                $(".print-div").show();
                                $(".no-data").hide();
                            }
                        }


                    });
                }
                return false;
            })


            // Joining Report Ajax


            $("#joining-report-search").submit(function () {


                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());

                if (startDate > endDate) {
                    $("#date-error").html('<p style="color:red">You must select an end date greater than start date</p>');
                    $("#report-main-div").hide();
                    return false;
                }

                isValid = true;
                $(".date_input").each(function () {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });


                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_joining_report');

                if (isValid) {
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#date-error").html('');
                            $("#report-main-div").show();
                            $(".report-caption").html(' Joining Report');
                            if ($.trim(data) === "0") {
                                $(".no-data").show();
                                $(".report-data").html('');
                                $(".print-div").hide();
                                $(".no-data").html('No Data');


                            } else {

                                $(".report-data").html(data);
                                $(".print-div").show();
                                $(".no-data").hide();
                            }
                        }
                    });
                }
                return false;
            })


            //Commission Report Ajax


            $("#commission-report-search").submit(function () {


                var startDate = new Date($('#commission_start_date').val());
                var endDate = new Date($('#commission_end_date').val());

                if (startDate > endDate) {
                    $("#commission-date-error").html('<p style="color:red">You must select an end date greater than start date</p>');
                    $("#report-main-div").hide();
                    return false;
                }

                isValid = true;
                $(".commission_date_input").each(function () {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });

                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_bonus_report');

                if (isValid) {
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#commission-date-error").html('');
                            $("#report-main-div").show();
                            $(".report-caption").html(' Bonus Report');
                            if ($.trim(data) === "0") {
                                $(".no-data").show();
                                $(".report-data").html('');
                                $(".print-div").hide();
                                $(".no-data").html('No Data');


                            } else {

                                $(".report-data").html(data);
                                $(".print-div").show();
                                $(".no-data").hide();
                            }
                        }
                    });
                }
                return false;
            })


            $(".search_input,.date_input,.commission_date_input").focus(function () {
                $(this).removeClass("invalid");
            })
        });
    </script>




    <script>

        function print_report() {

            var divToPrint = document.getElementById('print_area');
            var htmlToPrint = '' +
                    '<style type="text/css">' +
                    '.table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th{' +
                    'border: 1px solid #727272;' +
                    '}' +
                    '.table-bordered>tbody>tr>td{' +
                    'padding: 0px 2px 0px 2px;' +
                    '}' +
                    '.report-header-right{' +
                    'float: none; margin: auto;' +
                    '}' +
                    '.row-bottom{margin-bottom:10px}' +
                    '</style>';
            htmlToPrint += divToPrint.outerHTML;
            var newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
            return false;
        }


        jQuery("#start_date").datepicker({
            autoclose: true
        });
        jQuery("#end_date").datepicker({
            autoclose: true
        });

        jQuery("#commission_start_date").datepicker({
            autoclose: true
        });
        jQuery("#commission_end_date").datepicker({
            autoclose: true
        });

    </script>

    <?php
}
