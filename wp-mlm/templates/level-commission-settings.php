<?php
function wpmlm_commission_settings() {
    $res = wpmlm_get_commission_level_type();
    $level_commission = wpmlm_get_level_commission();
    $result = wpmlm_get_general_information();
    ?>    
    <div id="level-settings">
        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4><i class="fa fa-external-link-square"></i> <span> Bonus Settings</span></h4>
                             
                         </div>
            <div class="panel-border">
            <h5>Level Settings</h5>
            <div class="submit_message"></div>
            <form id="depth-form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="control-label col-md-3 user-dt" for="depth">Level Bonus Depth:</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="depth" id="depth" placeholder="Enter Level" value="<?php echo count($level_commission);?>" min="0" onkeypress="return isNumberKey(event)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 user-dt" for="depth_agree">I agree</label>
                    <div class="col-md-6">
                        <input type="checkbox" class="form-control" name="depth_agree" id="depth_agree">
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-6">

                        <input type="submit" name="depth-submit" class="btn btn-danger" value="Save">
                    </div>
                </div>
            </form> 
        </div>


        <div class="panel-border">  
            <h5>Bonus Settings</h5>

            <div class="submit_message1"></div>
            <form id="commission-form" class="form-horizontal " method="post">
                <div class="commission-inner-div">
                    <?php if (count($level_commission) > 0) { ?>
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <input  type="radio" value="percentage" name="level_type" <?php echo($res->level_commission_type == 'percentage' && $result->registration_type!='with_out_package' ) ? 'checked' : ''; ?>  > <span> Percentage&nbsp;&nbsp;</span>
                                <input type="radio" value="flat" name="level_type" <?php echo ($res->level_commission_type == 'flat' || $result->registration_type=='with_out_package') ? 'checked' : ''; ?> > <span> Flat</span>
                            <!--</div>-->
                </div>

                        <?php
                        $i = 0;
                        foreach ($level_commission as $comm) {
                            $i++;
                            ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 user-dt" for="level_commission">Level <?php echo $i; ?>:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control commission_input" name="level_commission[]" value="<?php echo $comm->level_percentage; ?>">
                                </div>
                            </div>
                        <?php }
                        ?>

                        <div class="form-group"> 
                            <div class="col-sm-offset-3 col-sm-6">
                                <?php wp_nonce_field('level_commission', 'level_commission_nonce'); ?>
                                <input type="submit" name="commission-submit" class="btn btn-danger" value="Update">
                            </div>
                        </div>
                    <?php } ?> 
                </div>
            </form>
        </div>
<!--     </div>
 -->        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            //var url = plugin_url + '/ajax-pages/level-commission.php';

            $("#depth-form").submit(function () {                
                $(".submit_message").html('');
                $(".submit_message").show();
                isValid = true;
                if (($("#depth").val() == '') || ($("#depth").val() < 1)) {
                    
                    $("#depth").addClass("invalid");
                    isValid = false;
                    return false;
                } else if ($("#depth_agree").is(':not(:checked)')) {
                    $("#depth_agree").css("border-color", "red");
                    return false;
                } else if (isValid) {

                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: {depth: $("#depth").val(),action:'wpmlm_level_bonus'},
                        cache: false,
                        success: function (data) {

                            $(".submit_message").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $(".commission-notice").hide();
                                $(".submit_message").hide();
                                $("#commission-form").load(location.href + " .commission-inner-div");
                                
                                //$('#depth_agree').prop('checked', false); // Checks it

                            }, 1000);

                        }
                    });

                }
                return false;

            });

            $("#commission-form").submit(function () {
                
                $(".submit_message1").html('');
                $(".submit_message1").show();
                
                var formData = new FormData(this);
                formData.append('action', 'wpmlm_level_bonus');
                isValid = true;

                $(".commission_input").each(function () {
                    var element = $(this);
                    if ((element.val() == '')|| (element.val() < 1)) {
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
                            $(".submit_message1").html('<div class="alert alert-info">' + data + '</div>');
                            setTimeout(function () {
                                $(".submit_message1").hide();

                            }, 1000);

                        }
                    });

                }
                return false;

            });
            
            
            $(document).on("click", ".commission-tab", function () {
                $("#commission-form").load(location.href + " .commission-inner-div");
   
            });
            
            $(".commission_input").focus(function () {
                $(this).removeClass("invalid");
            });

        });

    </script>
    <?php
}