<?php

function wpmlm_user_details_admin() {
    ?>
    <div class="panel-border-heading">
        <h4><i class="fa fa-info-circle" aria-hidden="true"></i> User Details</h4>
    </div>


    <div class="panel-border" id="user-div">

        <table id="user-table" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Full Name</th>
                    <th>Joining Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $results = wpmlm_get_all_user_details_join();
                $p_count = 0;
                foreach ($results as $res) {

                    $p_count++;
                    echo '<tr>
            <th scope="row">' . $p_count . '</th>
                <td>' . $res->user_login . '</td>
           <td>' . $res->user_first_name . ' ' . $res->user_second_name . '</td>
            <td>' . date("Y/m/d", strtotime($res->join_date)) . '</td>
            
            <td>
                <button type="button" class="btn btn-default btn-sm user_view" edit-id="' . $res->ID . '">View details</button>
            </td>
        </tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
    <div class="col-md-12 please-wait" style="text-align: center; display: none"><img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/images/please-wait.gif'; ?>"></div>
    <div class="user-details">

    </div>


    <script>

        jQuery(document).ready(function ($) {
            $('#user-table').DataTable({
                "pageLength": 10
            });
            $(document).on("click", ".user_view", function () {
                $(".please-wait").show();
                $(".user-details").show();

                var user_id = $(this).attr('edit-id');
                $.get(ajaxurl + '?user_id=' + user_id+'&action=wpmlm_ajax_user_details', function (data) {
                    $('.user-details').html(data);
                    $(".please-wait").hide("slow");

                });
                $("#user-div").hide();
                return false;

            });
        });

    </script>
    <?php
}
