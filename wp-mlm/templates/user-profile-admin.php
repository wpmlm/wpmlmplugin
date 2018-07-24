<?php
function wpmlm_user_profile_admin($user_id = '') {
    $results = wpmlm_get_user_details_by_id_join($user_id);
    $results1 = wpmlm_get_user_details_by_id_join($results[0]->user_parent_id);
    $date = strtotime($results1[0]->join_date);
    $joining_date = date('Y-m-d', $date);    
    $package_details = wpmlm_select_package_by_id($results[0]->package_id);
    ?>
    <div id="user-profile">
    <div class="panel panel-default">
        <div class="panel-heading">
         <h4><i class="fa fa-info-circle"></i> <span class="report-caption"> User Profile</span></h4>         
      </div>
                <div class="panel-border">
               <h4>Sponsor & Package Information</h4>
                    <form id="user-form1" class="form-horizontal " method="post">
                        <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="user_name">User Name:</label>
                     <div class="col-md-7">
                                <input type="text" class="" name="user_name" id="user_name" value="<?php echo $results[0]->user_login; ?>" readonly style="border: none;" >
                            </div>
                        </div>
                        <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="package_price">Sponsor Name:</label>
                     <div class="col-md-7">
                                <input type="text" class="" name="sponsor_name" id="sponsor_name" value="<?php echo $results1[0]->user_login; ?>" readonly style="border: none;">
                            </div>
                        </div>
                        <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="joining_date">Joining Date:</label>
                     <div class="col-md-7">
                                <input type="text" class="" name="joining_date" id="joining_date" value="<?php echo $joining_date; ?>" readonly style="border: none;">
                            </div>
                        </div>
                        
                        <?php if($package_details){?>
                        <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="registration_package">Registration Package :</label>
                     <div class="col-md-7">
                                <input type="text" class="" name="registration_package" id="registration_package" value="<?php echo $package_details->package_name; ?>" readonly style="border: none;">
                            </div>
                        </div>
                        <?php }?>
                        
                    </form>
               
               <div id="user-form2-message"></div>
                    
                    <h4>Personal Information</h4>
                    <form id="user-form2" class="form-horizontal " method="post" style="margin-top: 20px;">
                        <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="fname">First Name:</label>
                     <div class="col-md-7">
                                <input type="text" class="user-input" name="fname" id="fname" value="<?php echo $results[0]->user_first_name; ?>" readonly style="border: none;" >
                            </div>
                        </div>
                        <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="lname">Last Name:</label>
                     <div class="col-md-7">
                                <input type="text" class="user-input" name="lname" id="lname" value="<?php echo $results[0]->user_second_name; ?>" readonly style="border: none;">
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-sm-offset-4 col-sm-6">
                            </div>
                        </div>
                    </form>

               <div id="user-form3-message"></div>
<h4>Contact Information</h4>


               <div id="user-form3-div">
                  <form id="user-form3" class="form-horizontal" method="post">
                      <div class="form-group">
                   <label class="control-label col-md-3 user-dt" for=""></label>

                     <div class=" col-md-7">
                        <a class="btn btn-danger user-form3-edit">
                            <i class="fa fa-edit"></i>&nbsp;Edit
                        </a>

                    </div>
                  </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="address1">Address 1:</label>
                        <div class="col-md-7">
                                    <input type="text" class="" name="address1" id="address1" value="<?php echo $results[0]->user_address; ?>" readonly style="border: none;" >
                                </div>
                            </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="user_email">Email:</label>
                        <div class="col-md-7">
                                    <input type="email" class="user-input" name="user_email" id="user_email" value="<?php echo $results[0]->user_email; ?>" readonly style="border: none;">
                                </div>
                            </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="city">Date of birth:</label>
                        <div class="col-md-7">
                                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" type="text" class="date-picker" name="dob" id="dob" value="<?php echo $results[0]->user_dob; ?>" readonly style="border: none;">
                                </div>
                            </div>
                      
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="contact_no">Telephone:</label>
                        <div class="col-md-7">
                                    <input type="text" class="" name="contact_no" id="contact_no" value="<?php echo $results[0]->user_mobile; ?>" readonly style="border: none;" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="city">City:</label>
                        <div class="col-md-7">
                                    <input type="text" class="" name="city" id="city" value="<?php echo $results[0]->user_city; ?>" readonly style="border: none;">
                                </div>
                            </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="state">State:</label>
                        <div class="col-md-7">
                                    <input type="text" class="" name="state" id="state" value="<?php echo $results[0]->user_state; ?>" readonly style="border: none;">
                                </div>
                            </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="country">Country:</label>
                        <div class="col-md-7">
                                    <select   name="country" id="country" style="display:none; width:100%; background-color: #fff" >
                                        <?php
                                        $country_results = wpmlm_getAllCountry();
                                        foreach ($country_results as $res) {
                                            if ($results[0]->user_country == $res->id) {
                                                $selected = 'selected';
                                                $country_name = $res->name;
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option ' . $selected . ' value="' . $res->id . '">' . $res->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="text" id="country_temp" value="<?php echo $country_name; ?>" readonly style="border: none;">
                                </div>
                            </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 user-dt" for="zip">Zip Code:</label>
                        <div class="col-md-7">
                                    <input type="text" class="" name="zip" id="zip" value="<?php echo $results[0]->user_zip; ?>" readonly style="border: none;" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                     <div class="form-group">
                  <label class="control-label col-md-3 user-dt" for=""></label>
                        <div class="col-sm-7" class="up-can-btn">
                                    <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <?php wp_nonce_field('user_form3', 'user_form3_nonce'); ?>
                           <div class="form-group" id="user-form3-update" style="display: none">
                             
                                        
                                                         <div class="sharedaddy">
                  
  <ul>
    <li class="share-facebook"><button class="btn btn-success  col-sm-offset-2 user_form3_save" type="submit" name="user_form3_save" id="user_form3_save">
                                 Update <i class="fa fa-arrow-circle-right"></i>
                                 </button></li>
    <li class="share-twitter"><a style="width:87px;" data-cancel="user-form3" class="btn btn-primary edit-cancel">
                                 Cancel
                                 </a></li>
    
  </ul>
</div>
                  
                                        
                           </div>
                                        
                                    </div>
                                </div>
                        </form>
                    </div>
<?php if (!current_user_can('administrator')) {
    ?>

                    <div class="" id="change-password">
                    <div id="user-form4-message"></div>
                    <h4>Change Password</h4>
                        <form id="user-form4" class="form-horizontal " method="post">
                            <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="password_admin">New Password:</label>
                     <div class="col-md-7">
                                    <input type="password" class="user-password-input form-control" name="password_admin" id="password_admin">
                                </div>
                            </div>
                            <div class="form-group">
                     <label class="control-label col-md-3 user-dt" for="confirm_password">Confirm Password:</label>
                     <div class="col-md-7">
                                    <input type="password" class="user-password-input form-control confirm_password" name="confirm_password_admin" id="confirm_password_admin">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <?php wp_nonce_field('user_form4_admin', 'user_form4_admin_nonce'); ?>
                            <div class="form-group">
                   <label class="control-label col-md-3 user-dt" for=""></label>

                     <div class=" col-md-7">
                        <button class="btn btn-danger  user_form4_save" type="submit" name="user_form4_save" id="user_form4_save">
                                        Save 
                                    </button>
                                </div>
                            </div>                        
                        </form> 
 </div>
<?php 
}
?>
                
                
                </div>      
                    </div>   
                </div> 
    <script type="text/javascript">
        
                
        jQuery(document).ready(function ($) {

            

            $(".user-form3-edit").click(function () {
                $("#dob").datepicker({
                    autoclose: true
                });
                
                $("#country").show();
                $("#country_temp").hide();

                $("#user-form3 [type=text],[type=email]").addClass("form-control");
                $("#user-form3 [type=text],[type=email]").attr("readonly", false);
                $("#user-form3 [type=text],[type=email]").css("border", "1px solid #bbb");
                $("#user-form3 .form-group").css("margin-bottom", "10px");
                $("#user-form3-update").show();
            });


            $(document).on('click', '.edit-cancel', function () {
                var cancel_id = $(this).attr('data-cancel');
                $("#" + cancel_id + " [type=text], #" + cancel_id + " [type=email]").removeClass("form-control");
                $("#" + cancel_id + " [type=text], #" + cancel_id + " [type=email]").attr("readonly", true);
                $("#" + cancel_id + " [type=text], #" + cancel_id + " [type=email]").css("border", "none");
                //$("#" + cancel_id + " .form-group").css("margin-bottom", "10px");
                $("#" + cancel_id + "-update").hide();
                $("#country").hide();
                $("#country_temp").show();
            });

            // form 2 update start //
            

            $(document).on('submit', '#user-form3', function () {

                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_user_profile');
                isValid = true;
                $(".user-input").each(function () {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });
                
                if($( "#user_email" ).hasClass( "invalid" )){
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
                            $("#user-form3-message").show();
                            $("#user-form3-message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $("#user-form3-message").hide('slow');
                                $(".edit-cancel").trigger('click');
                            }, 1000);

                        }

                    });
                }
                return false;
            });



            $(document).on('submit', '#user-form4', function () {
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_ajax_user_profile');
                isValid = true;
                $(".user-password-input").each(function () {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).addClass("invalid");
                        isValid = false;
                    }
                });
                
                var pass = $("#password_admin").val();
                var confirm_password = $("#confirm_password_admin").val();
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
                            
                            
                            $("#user-form4")[0].reset();
                            $("#user-form4-message").show();
                            $("#user-form4-message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $("#user-form4-message").hide();
                            }, 1000);

                        }

                    });
                }
                return false;
            })

            $(".user-input").focus(function () {
                $(this).removeClass("invalid");
            })
            $(".user-password-input").focus(function () {
                $(this).removeClass("invalid");
            })


        });

    </script>
    <?php
}