<?php
function wpmlm_unilevel_tree($user_id='') {
echo '<div id="dynamic-div">';
$user_details = wpmlm_get_all_user_details_join();
    $tree = wpmlm_buildTree($user_details, $user_id);

    function flattenArray($arr) {
        for ($i = 0; $i < count($arr); $i++) {
            if (is_array($arr[$i])) {
                array_splice($arr, $i, 1, $arr[$i]);
            }
        }
        return $arr;
    }

    foreach ($tree as $key => $data) {
        if (is_array($data)) {
            foreach ($data as $sub_data) {
                $tree = flattenArray($tree);
            }
        }
    }
    $arr = array();
    $count = 0;
    foreach ($tree as $us) {

        $count++;
        if ($count == 1) {
            $parent_id = null;
        } else {
            $parent_id = $us->user_parent_id;
        }
        $arr[$us->user_ref_id] = Array(
            'name' => $us->user_login,
            'user_id' => $us->user_ref_id,
            'parent_id' => $parent_id,
            'email' => $us->user_email,
        );
    }
    $uniLevelTree = wpmlm_makeNested($arr);
    $treeJson = json_encode($uniLevelTree[0]);
    ?>

    <div class="panel-border-heading">
        <h4><i class="fa fa-sitemap" aria-hidden="true"></i> Genealogy Tree</h4>
    </div>
    <div id="unilevel-tree">
        <div class="panel-border">            
            <div id="chart-container"></div>
            <div id="test"></div>
        </div>
    </div>

    <script type="text/javascript">
        //$(function () {
        jQuery( document ).ready( function( $ ) {
        var datasource =<?php echo $treeJson; ?>

        var nodeTemplate = function(data) {
        return `<span class = "user-image" ><img src = "<?php echo plugins_url() . "/" . WP_MLM_PLUGIN_NAME . "/images/user.png"; ?>" > </span>
                <div class = "title" > ${data.name} </div>`;
        };
        var oc = $('#chart-container').orgchart({
        'data' : datasource,
                'nodeTemplate': nodeTemplate
        });        
       });
        
        
    </script>
<?php 
echo '</div>';
}