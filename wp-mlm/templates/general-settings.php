<?php

function wpmlm_general_settings() {
    $result = wpmlm_get_general_information();
    ?>
    <div id="general-settings">
         <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square" aria-hidden="true"></i> <span> General Settings</span></h4>
                             
                         </div>
        <div class="panel-border">
            <div id="submit_message"></div>
            <form id="general-form" class="form-horizontal " method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-md-2 user-dt" for="company_name">Company Name:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control company_input" name="company_name" id="company_name" placeholder="Enter Company Name" value="<?php echo $result->company_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 user-dt" for="company_address">Company Address:</label>
                    <div class="col-md-6">

                        <textarea class="form-control company_input" name="company_address" id="company_address" rows="4"><?php echo $result->company_address; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-12 col-xs-12 user-dt" >Company Logo:</label>
                    <div class="col-md-2 col-sm-3 col-xs-3" > <img class="thumb-image-general" src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/uploads/' . $result->company_logo; ?>">       
                    </div>


                </div>
                
                <div class="form-group">
                    <div class="col-sm-6 company_logo col-md-offset-2"> 
                        <label for="company_logo" class="custom-file-upload-logo">
                            <?php
                            if ($result->company_logo == 'default_logo.png') {
                                echo '<i class="fa fa-cloud-upload"></i> Upload Logo';
                            } else {
                                echo '<i class="fa fa-cloud-upload"></i> Change Logo';
                            }
                            ?>

                        </label>

                        <input type="file" onchange="previewFile()" class="form-control" name="company_logo" id="company_logo" style="margin-top: 10%">
                        <label for="image-remove" class="image-remove" style="<?php if ($result->company_logo == 'default_logo.png') {
                                echo 'display:none';
                            } ?>" >
                            <i class="fa fa-trash"></i> Remove

                        </label>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        
                        <input type="checkbox" <?php echo ($result->site_logo=='active'?'checked':'')?> class="form-control" name="site_logo" id="site_logo" value="active"  ><label class="control-label site_logo_label" for="site_logo">Use same image in the Login/Register Page</label>
                </div></div>
                <div class="form-group">
                    <label class="control-label col-md-2 user-dt" for="company_email">Company Email:</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control company_input" name="company_email" id="company_email" placeholder="Enter Email" value="<?php echo $result->company_email; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 user-dt" for="company_phone">Company Phone:</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control company_input" name="company_phone" id="company_phone" placeholder="Enter Company Phone" value="<?php echo $result->company_phone; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 user-dt" for="company_currency">Currency:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control company_input" name="company_corrency" id="company_corrency" value="USD ($)" style="background-color: #eaeaea;">
                    </div>
                </div>
                




                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-6">
                        <input type="hidden" name="action" value="" id="action">
                        <input type="hidden" name="image" value="default_logo.png" id="image">
    <?php wp_nonce_field('general_add', 'general_add_nonce'); ?>
                        <button id="general-save" type="submit" class="btn btn-danger"> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    </div> 


    <script>
        jQuery(document).ready(function ($) {
            var plugin_url = path.pluginsUrl;
            $("#general-form").submit(function () {
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_general_settings');
                
                isValid = true;
                $(".company_input").each(function () {
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
                            
                            $("#submit_message").show();
                            $("#submit_message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                    $("#submit_message").hide();

                                }, 2000);
                        }
                    });
                }
                return false;
            })
            $(".company_input").focus(function () {
                $(this).removeClass("invalid");
            });
            
            $(document).on('click', '.image-remove', function () {
            $('.thumb-image-general').attr('src', plugin_url + '/uploads/default_logo.png');
            $("#image").val('');
            $("#company_logo").val('');
            $(".image-remove").hide();
            $(".custom-file-upload-logo").html('<i class="fa fa-cloud-upload"></i> Upload Logo');
        });
        
        $("#company_logo").change(function () {
            readURL1(this);
            $(".image-remove").show();
        }); 
        });
    </script>
    <?php
}