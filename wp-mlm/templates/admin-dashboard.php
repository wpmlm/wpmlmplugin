<?php
function wpmlm_admin_dashboard($user_id) {  
    $user_row = wpmlm_getUserDetails();
    $j_count = wpmlm_getJoiningByTodayCount($user_id);
    
    $ewallet_credit = wpmlm_getEwalletAmount('credit');
    $ewallet_debit = wpmlm_getEwalletAmount('debit');    
    $debit_amt = ($ewallet_debit->sum !=''? $ewallet_debit->sum:0);
    $credit_amt = ($ewallet_credit->sum !=''? $ewallet_credit->sum:0);
    
    $bonus_amount = wpmlm_get_total_leg_amount_all();
    $bonus_amount_today = wpmlm_get_total_leg_amount_all_by_today();
    
    $bonus_total_amt = ($bonus_amount->total_amount !=''? $bonus_amount->total_amount:0);
    $bonus_total_amt_today = ($bonus_amount_today->total_amount !=''? $bonus_amount_today->total_amount:0);
    
    $top_earners = wpmlm_get_total_leg_amount_all_users_under_admin($user_id);
    $general = wpmlm_get_general_information();
    $year = date('Y');

    
    $joining_details = wpmlm_getJoiningDetailsByMonth($year,$user_id);
    
    
    if ($joining_details) {
        $i = 0;
        foreach ($joining_details as $jdt) {
            $i++;
            if ($i == $jdt->month) {
                $joining_count[] = $jdt->count;
            } else {

                for ($j = $i; $j < $jdt->month; $j++) {
                    $joining_count[] = 0;
                }
                $joining_count[] = $jdt->count;
                $i++;
            }
        }
        $joining_count = implode($joining_count, ',');
    } else {
        $joining_count = '0,0,0,0,0,0,0,0,0,0,0,0';
    }
    ?>
    
    <div id="general-settings">

   <div class="panel-border col-md-4 col-sm-4 panel-ioss-mlm">
   
   
      <div class="col-sm-5 col-xs-6 col-md-6">
         <h4>Downlines</h4>
         <p>Total: <span><?php echo count($user_row)-1;?> </span></p>
         <p>Today: <span><?php echo $j_count->count;?></span></p>
      </div>
      <div class="col-sm-7 col-xs-6 col-md-6 ">
         <img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/images/bar-chart.png'; ?>">
      </div>
   </div>
   <div class="panel-border col-md-4 col-sm-4 panel-ioss-mlm">
   
   
      <div class="col-sm-5 col-xs-6 col-md-6">
         <h4>Bonus</h4>
         <p>Total: <span><?php echo $general->company_currency;?><?php echo $bonus_total_amt;?></span></p>
         <p>Today: <span><?php echo $general->company_currency;?><?php echo $bonus_total_amt_today;?></span></p>
      </div>
      <div class="col-sm-7 col-xs-6 col-md-6">
         <img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/images/money-bag.png'; ?>">
      </div>
   </div>
   <div class="panel-border col-md-4 col-sm-4 panel-ioss-mlm">
      <div class="col-sm-5 col-xs-6 col-md-6">
         <h4>E-Wallet</h4>
         <p>Credit: <span><?php echo $general->company_currency;?><?php echo $credit_amt;?></span></p>
         <p>Debit: <span><?php echo $general->company_currency;?><?php echo $debit_amt;?></span></p>
      </div>
      <div class="col-sm-7 col-xs-6 col-md-6">
         <img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/images/wallet.png'; ?>">
      </div>
   </div>
      <div class="panel-border col-md-6" style="padding-left: 0px;padding-top: 11px;">
         
            <script>
            window.onload = function () {
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                                label: 'Joinings',
                                lineTension: 0,
                                data: [<?php echo $joining_count; ?>],
                                backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                                borderColor: ['rgba(54, 162, 235, 1)'],
                                borderWidth: 1
                            }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                        }
                    }
                });
            }
         </script>
         <canvas id="myChart" width="400" height="400">
         </canvas>
      </div>
      <div class="panel-border  col-md-6 tabble-mode">
        <table class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
          <thead>
              <caption class="user-table-profile">Recently joined users</caption>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Username</th>
              <th scope="col">Fullname</th>
              <th scope="col">Email ID</th>
            </tr>
          </thead>
          <tbody>
            
                
            <?php
              $last_joined = wpmlm_get_recently_joined_users_under_admin($user_id,'4');
              $jcount = 0;
              foreach($last_joined as $lj){
                  $jcount++;
                  ?>
              <tr>
              <th scope="row"><?php echo $jcount;?></th>
              <td><?php echo $lj->user_login;?></td>
              <td><?php echo $lj->user_first_name.' '.$lj->user_second_name;?> </td>
              <td><?php echo $lj->user_email;?> </td>
              </tr>
            <?php }?>
              
            
            
          </tbody>
        </table>
        
        <div class="mlm-users">
            <h4 class="usr">Top Bonus Earned Users</h4>
            
            <?php 
            $top_earners = wpmlm_get_total_leg_amount_all_users_under_parent($user_id);
            if(count($top_earners)==0){
                echo '<div class="top_earners_div"><p>No bonus earned users yet</p><div>';
            }?>
            
            <?php 
            foreach($top_earners as $te){?>
        <div class="col-md-4">
            <div class="user-list">
                <img src="<?php echo plugins_url() . '/' . WP_MLM_PLUGIN_NAME . '/images/avatar.png'; ?>">
                <li><h4><?php echo $te->user_first_name;?></h4></li>
                <li><?php echo $general->company_currency;?><?php echo $te->total_amount;?></li>
            </div>            
        </div>
        <?php
            }
            ?>
        </div>
      
    </div>

    <?php
}
