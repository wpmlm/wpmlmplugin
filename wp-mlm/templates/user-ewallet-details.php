<?php

function wpmlm_user_ewallet_details($user_id = '') {
    $results = wpmlm_getEwalletHistory($user_id);
    $bal_amount_arr = wpmlm_getBalanceAmount($user_id);
    $bal_amount = $bal_amount_arr->balance_amount;    
    $bal_amount=number_format((float)$bal_amount, 2, '.', '');    
    $result2 = wpmlm_get_general_information();
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-external-link-square"></i> <span> E-wallet Details</span></h4>
                    
                </div>
                <div  id="profile_print_area" style="overflow: auto; padding: 10px;" class="report-data" >
                    <?php if (count($results) > 0) { ?>

                        <table id="ewallet_details_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Description</th>                                    
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>

                                    <th  colspan="5" style="text-align: right;">Available Balance</th>
                                    <th><?php echo $result2->company_currency . ' ' . $bal_amount; ?></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($results as $res) {
                                    $count++;
                                    $debit = ($res->type == 'debit') ? $result2->company_currency . $res->amount : '';
                                    $credit = ($res->type == 'credit') ? $result2->company_currency . $res->amount : '';
                                    $balance_amt = ($res->type == 'credit') ? $result2->company_currency . $balance = $balance + $res->amount : $result2->company_currency . $balance = $balance - $res->amount;

                                    $from_id = $res->from_id;
                                    $the_user = get_user_by('ID', $from_id);
                                    $amount_type = $res->amount_type;
                                    if ($amount_type == "level_bonus") {
                                        $amount_type_des = 'You received level bonus from ' . $the_user->user_login;
                                    }
                                    if ($amount_type == "admin_credit") {
                                        $amount_type_des = 'Credited By Admin<br>Transaction Id: <font color="blue">' . $res->transaction_id . '</font>';
                                    }
                                    if ($amount_type == "admin_debit") {
                                        $amount_type_des = 'Debited By Admin<br>Transaction Id: <font color="blue">' . $res->transaction_id . '</font>';
                                    }

                                    if ($amount_type == "user_credit") {
                                        $amount_type_des = 'Fund transfered from ' . $the_user->user_login . '<br>Transaction Id: <font color="blue">' . $res->transaction_id . '</font>';
                                    }
                                    if ($amount_type == "user_debit") {
                                        $amount_type_des = 'Fund transfered to ' . $the_user->user_login . '<br>Transaction Id: <font color="blue">' . $res->transaction_id . '</font>';
                                    }



                                    echo '<tr>
            <td>' . $count . '</td>
            <td>' . date("Y/m/d", strtotime($res->date_added)) . '</td>
            <td>' . $amount_type_des . '</td>
            <td>' . $debit . '</td>
            <td>' . $credit . '</td>
            <td>' . $balance_amt . '</td>                             
            </tr>';
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
            $('#ewallet_details_table').DataTable({
                "pageLength": 10,
                "bFilter": false
            });
        });

    </script>
    <?php
}