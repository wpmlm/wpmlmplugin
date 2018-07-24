<?php
function wpmlm_user_referrals($user_id = '') {
    $results = wpmlm_get_user_details_by_parent_id_join($user_id);
    $current_user_id = get_current_user_id();
    $user_info=get_userdata($current_user_id);
    $role = implode(', ', $user_info->roles);
            
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-bars" aria-hidden="true"></i> <span>Referral Details</span></h4>
                    
                </div>
                <div  id="profile_print_area" style="overflow: auto; padding: 10px;" class="report-data" >
                    <?php
                    if (count($results) > 0) {
                        ?>
                        <table id="user-referrals-table" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Full Name</th>                                    
                                    <th>Joining Date</th>
                                    <th>Email</th>
                                    <?php if($role=='administrator'){?>
                                    <th>Action</th>
                                    <?php }?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($results as $res) {
                                    
                                    if($role=='administrator'){
                                    $action = '<td>
                <button type="button" class="btn btn-default btn-sm user_view" edit-id="'.$res->ID.'">View details</button>
            </td>';
                                    }else{
                                        $action ='';
                                    }

                                    $count++;
                                    echo '<tr>
            <th scope="row">' . $count . '</th>
            <td>' . $res->user_login . '</td>
                <td>' . $res->user_first_name . ' ' . $res->user_second_name . '</td>
                <td>' . date("Y/m/d", strtotime($res->join_date)) . '</td>
                <td>' . $res->user_email . '</td>'.$action;                                    
            '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    <?php
                    } else {
                        echo '<div class="no-data"> No Data</div>';
                    }
                    ?>
                </div>

            </div>
        </div>
    </div> 
    <script>
        jQuery(document).ready(function ($) {
            $('#user-referrals-table').DataTable({
                "pageLength": 10,
                "bFilter": false
            });
        });

    </script>
    <?php
}