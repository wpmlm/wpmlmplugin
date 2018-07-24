<?php

function wpmlm_admin_area() {    
    $user_id = get_current_user_id();
    $user_details = wpmlm_get_user_details($user_id);
    $parent_id = $user_details->user_parent_id;
    $packages = wpmlm_select_all_packages();
    $depth = wpmlm_get_level_depth();    
    ?>
<div class="panel-border-heading">
<h3 class="mlm-title">WP MLM Admin</h3>
</div>
  <div class="ioss-mlm-menu panel-border">
    <input id="ioss-mlm-tab1" class="tab_class" type="radio" name="tabs" checked>
    <label class="tab_class" for="ioss-mlm-tab1">Dashboard</label>      
    <input id="ioss-mlm-tab2" class="tab_class user-details-tab" type="radio" name="tabs">
    <label class="tab_class" for="ioss-mlm-tab2">Users</label>      
    <input id="ioss-mlm-tab3" class="tab_class tree-tab" type="radio" name="tabs">
    <label class="tab_class" for="ioss-mlm-tab3">Genealogy Tree</label>      
    <input id="ioss-mlm-tab4" class="tab_class ewallet-tab" type="radio" name="tabs">
    <label class="tab_class" for="ioss-mlm-tab4">E-wallet Management</label>
    <input id="ioss-mlm-tab5" class="tab_class report-tab" type="radio" name="tabs">
    <label class="tab_class" for="ioss-mlm-tab5">Reports</label>
    <input id="ioss-mlm-tab6" class="tab_class" type="radio" name="tabs">
    <label class="tab_class" for="ioss-mlm-tab6">Change Password</label>
    <input id="ioss-mlm-tab7" class="tab_class" type="radio" name="tabs">
    <label class="tab_class" for="ioss-mlm-tab7">Settings</label>    
      
    <section id="content1"><p><?php echo wpmlm_admin_dashboard($user_id); ?></p></section>      
    <section id="content2"><p><?php echo wpmlm_user_details_admin(); ?></p></section>      
    <section id="content3" ><p><?php echo wpmlm_unilevel_tree($user_id); ?></p></section>      
    <section id="content4"><p><?php echo wpmlm_ewallet_management(); ?></p></section>    
    <section id="content5"><p><?php echo wpmlm_all_reports(); ?></p></section>
    <section id="content6"><p><?php echo wpmlm_password_settings(); ?></p></section>
    <section id="content7"><p><?php echo wpmlm_settings(); ?></p></section>
    
  </div>
<?php }