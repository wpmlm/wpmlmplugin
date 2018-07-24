var plugin_url = path.pluginsUrl;
jQuery( document ).ready( function( $ ) {
    
    $("#sname").change(function () {
        $(".err_msg_sponsor").remove();

        var sname = $(this).val();
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',sponsor: sname},
            beforeSend: function () {
                $("#sname").parent().append('<div class="err_msg_sponsor"><img src=' + plugin_url + '/images/loader.gif></div>');
            },
            success: function (data) {
                $(".err_msg_sponsor").remove();
                if ($.trim(data) === "1") {
                    $("#sname").removeClass('invalid');

                } else {
                    $("#sname").parent().append('<div class="err_msg_sponsor">' + data + '</div>');
                    $("#sname").addClass('invalid');
                }

            }

        });
    });


    $("#username").blur(function () {
        $(".err_msg_user").remove();
        var username = $(this).val();
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',username: username},
            beforeSend: function () {
                $("#username").parent().append('<div class="err_msg_user"><img src=' + plugin_url + '/images/loader.gif></div>');
            },
            success: function (data) {
                $(".err_msg_user").remove();

                if ($.trim(data) === "1") {
                    $("#username").removeClass('invalid');

                } else {
                    $("#username").parent().append('<div class="err_msg_user">' + data + '</div>');
                    $("#username").addClass('invalid');

                }
            }

        });
    });

    $("#confirm_password").blur(function () {
        $(".err_msg_pass").remove();
        var confirm_password = $(this).val();
        var pass = $("#password").val();
        if (confirm_password != pass) {
            $("#confirm_password").addClass('invalid');
            $("#confirm_password").parent().append('<div class="err_msg_pass">Password mismatch</div>');
        } else {
            $(".err_msg_pass").remove();
        }
    });

    $("#password").blur(function () {
        $(".err_msg_pass").remove();
        var pass = $(this).val();
        var confirm_password = $("#confirm_password").val();

        if (pass.length < 6) {
            $("#password").addClass('invalid');
            $("#password").parent().append('<div class="err_msg_pass">Password should be at least 6 characters</div>');

        } else if (confirm_password != pass && confirm_password != '') {
            $("#confirm_password").addClass('invalid');
            $("#confirm_password").parent().append('<div class="err_msg_pass">Password mismatch</div>');
        } else {
            $(".err_msg_pass").remove();
            $("#confirm_password").removeClass('invalid');
        }
    });


    $(document).on("blur", "#confirm_password_admin", function () {
        $(".err_msg_pass").remove();
        var confirm_password = $(this).val();
        var pass = $("#password_admin").val();
        if (confirm_password != pass) {
            $("#confirm_password_admin").addClass('invalid');
            $("#confirm_password_admin").parent().append('<div class="err_msg_pass">Password mismatch</div>');
        } else {
            $(".err_msg_pass").remove();
        }
    });

    $(document).on("blur", "#password_admin", function () {
        $(".err_msg_pass").remove();
        var pass = $(this).val();
        var confirm_password = $("#confirm_password_admin").val();

        if (pass.length < 6) {
            $("#password_admin").addClass('invalid');
            $("#password_admin").parent().append('<div class="err_msg_pass">Password should be at least 6 characters</div>');

        } else if (confirm_password != pass && confirm_password != '') {
            $("#confirm_password_admin").addClass('invalid');
            $("#confirm_password_admin").parent().append('<div class="err_msg_pass">Password mismatch</div>');
        } else {
            $(".err_msg_pass").remove();
        }
    });
    
    
    
    
    $(document).on("blur", "#password_user", function () {
        $(".err_msg_pass").remove();
        var pass = $(this).val();
        var confirm_password = $("#confirm_password_user").val();

        if (pass.length < 6) {
            $("#password_user").addClass('invalid');
            $("#password_user").parent().append('<div class="err_msg_pass">Password should be at least 6 characters</div>');

        } else if (confirm_password != pass && confirm_password != '') {
            $("#confirm_password_user").addClass('invalid');
            $("#confirm_password_user").parent().append('<div class="err_msg_pass">Password mismatch</div>');
        } else {
            $(".err_msg_pass").remove();
        }
    });
    
    
    $(document).on("blur", "#confirm_password_user", function () {
        $(".err_msg_pass").remove();
        var confirm_password = $(this).val();
        var pass = $("#password_user").val();
        if (confirm_password != pass) {
            $("#confirm_password_user").addClass('invalid');
            $("#confirm_password_user").parent().append('<div class="err_msg_pass">Password mismatch</div>');
        } else {
            $(".err_msg_pass").remove();
        }
    });
    



    $("#email1").blur(function () {
        $(".err_msg_pass").remove();
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($("#email").val()))
        {
            $(".err_msg_pass").remove();
        } else {

            $("#email").addClass('invalid');
            $("#email").parent().append('<div class="err_msg_pass">Please enter the correct email Id</div>');
        }

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',email: $("#email").val()},
            beforeSend: function () {
                $("#email").parent().append('<div class="err_msg_pass"><img src=' + plugin_url + '/images/loader.gif></div>');
            },
            success: function (data) {
                $(".err_msg_pass").remove();

                if ($.trim(data) === "1") {
                    $("#email").removeClass('invalid');
                } else {

                    $("#email").parent().append('<div class="err_msg_pass">E-mail address is already in use</div>');
                    $("#email").addClass('invalid');

                }


            }

        });

    });

    $(document).on("blur", "#email", function () {
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',email: $("#email").val()},
            success: function (data) {
                //alert(data);
                $(".err_msg_pass").remove();

                if ($.trim(data) === "1") {
                    $("#email").removeClass('invalid');
                } else {

                    $("#email").parent().append('<div class="err_msg_pass">E-mail address is already in use</div>');
                    $("#email").addClass('invalid');

                }
            }

        });

    });

    $(document).on("keyup", "#email", function () {
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',email: $("#email").val()},
            success: function (data) {
                $(".err_msg_pass").remove();

                if ($.trim(data) === "1") {
                    $("#email").removeClass('invalid');
                } else {

                    $("#email").parent().append('<div class="err_msg_pass">E-mail address is already in use</div>');
                    $("#email").addClass('invalid');

                }
            }

        });

    });


    $(document).on("blur", "#user_email", function () {
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',user_email: $("#user_email").val(), user_id: $("#user_id").val()},
            success: function (data) {
                //alert(data);
                $(".err_msg_pass").remove();

                if ($.trim(data) === "1") {
                    $("#user_email").removeClass('invalid');
                } else {

                    $("#user_email").parent().append('<div class="err_msg_pass">E-mail address is already in use</div>');
                    $("#user_email").addClass('invalid');

                }
            }

        });

    });

    $(document).on("keyup", "#user_email", function () {
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_user_check',user_email: $("#user_email").val(), user_id: $("#user_id").val()},
            success: function (data) {
                //alert(data);
                $(".err_msg_pass").remove();

                if ($.trim(data) === "1") {
                    $("#user_email").removeClass('invalid');
                } else {

                    $("#user_email").parent().append('<div class="err_msg_pass">E-mail address is already in use</div>');
                    $("#user_email").addClass('invalid');

                }
            }

        });

    });



    $(document).on("click", ".package-settings", function () {
        $( ".please-wait" ).show();
        $("#package-settings").hide();
        $("#package-settings").show();
        $( ".please-wait" ).hide();
        $(".image-remove-package").hide();
        $("#package_name,#package_price,#image1,#package_id,#submit-action,#package_image").val('');
        $('.thumb-image').attr('src', plugin_url + '/uploads/no-image.png');
        $(".custom-file-upload").html('<i class="fa fa-cloud-upload"></i> Upload Image');
        

    });


    $(document).on("click", ".package_edit", function () {
        $( ".please-wait" ).show();
        $("#package-settings").hide();
        $("#package-form")[0].reset();
        var id = $(this).attr('edit-id');        
        $(".image-remove-package").hide();
        
        
        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: 'json',
            data: {action:'wpmlm_ajax_package_settings',package_id: id},
            success: function (data) {
                $( ".please-wait" ).hide( "slow" );
                $("#package-settings").show();
                $("#package_name").val(data.package_name);
                $("#package_price").val(data.package_price);
                $("#image1").val(data.package_image);
                $("#submit-action").val('update');
                $("#package_id").val(data.id);
                $('.thumb-image').attr('src', plugin_url + '/uploads/' + data.package_image);

                if (data.package_image == 'no-image.png') {
                    $(".image-remove-package").hide();
                    $(".custom-file-upload").html('<i class="fa fa-cloud-upload"></i> Upload Image');
                } else {
                    $(".image-remove-package").show();
                    $(".custom-file-upload").html('<i class="fa fa-cloud-upload"></i> Change Image');
                }
            }

        });
    });

    $(document).on("click", ".package_delete", function () {
        
        $(this).prop('disabled', true);
        $(".submit_message1").show();
        var id = $(this).attr('delete-id');
        
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action:'wpmlm_ajax_package_settings',package_delete_id: id},
            success: function (data) {
                if ($.trim(data) === "1") {
                    
                    $(".submit_message1").html('<div class="alert alert-info">Package Deleted</div>');
                    setTimeout(function () {
                        $(".submit_message1").hide();
                        $("#package-settings").hide();

                        $("#package-div").load(location.href + " #package-table");
                        $("#package-form")[0].reset();
                        $('.thumb-image').attr('src', plugin_url + '/uploads/no-image.png');

                    }, 3000);

                } else {
                    $(this).prop('disabled', false);
                    $(".submit_message1").html('<div class="alert alert-info">Package Deletion Failed !</div>');
                    setTimeout(function () {
                        $(".submit_message").hide();

                    }, 1000);


                }
            }

        });
    });

    $(".forgot-password").click(function () {
        $("#forgot-password").show();
        $("#login-form").hide();
    });

    $(".login-form").click(function () {
        $("#login-form").show();
        $("#forgot-password").hide();
    });



    //binding click events to elements

    var locationHash = window.location.hash.substring(1);
    if (locationHash == 'forgot-password') {
        $("#forgot-password").show();
        $("#login-form").hide();
    } else if (locationHash == 'login-form') {
        $("#login-form").show();
        $("#forgot-password").hide();
    }




$(document).on("click", ".user-details-tab", function () {
    

    $("#user-div").load(location.href + " #user-table", function () {
        
        if ( $.fn.dataTable.isDataTable( '#user-table' ) ) {
            $('#user-table').DataTable();
        }else{
            $('#user-table').DataTable();
        }
    });

});

$(document).on("click", ".report-tab", function () {
$('.report_ul li.active').removeClass('active');
$('.report_ul li:first-child').addClass('active');
    default_profile_data();
});


$(document).on("click", ".ewallet-tab", function () {

    $("#profile_print_area").load(location.href + " #ewallet_details_table", function () {
        
        if ( $.fn.dataTable.isDataTable( '#ewallet_details_table' ) ) {
            $('#ewallet_details_table').DataTable();
        }else{
            $('#ewallet_details_table').DataTable();
        }
    });

});

$(document).on("click", ".fund_management", function () {    
   $("#fund-management-form")[0].reset();
   $('#fund-management-form input').removeClass('invalid');
});

$(document).on("click", ".fund-transfer", function () {    
   $("#fund-transfer-form")[0].reset();
   $('#fund-transfer-form input').removeClass('invalid');
});
$(document).on("click", ".transfer-details", function () {    
   $("#transfer-details-form")[0].reset();   
   $('#transfer-details-form input').removeClass('invalid');
});

$(document).on("click", ".ewallet-tab", function () {    
   $('.fund_management').trigger('click');
});

$(document).on("click", ".ewallet-tab-user", function () {    
   $('.ewallet-details').trigger('click');
});

});

function readURL(input) {
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            jQuery('.thumb-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        jQuery(".custom-file-upload").html('<i class="fa fa-cloud-upload"></i> Change Image');
    }
}

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            jQuery('.thumb-image-general').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        
        jQuery(".custom-file-upload-logo").html('<i class="fa fa-cloud-upload"></i> Change Logo');
    }
}


function copyToClipboard(element) {
    var $temp = jQuery("<input>");
    jQuery("body").append($temp);
    $temp.val(jQuery(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}