<?php
if (!function_exists('generatePermissionsHtml')) {

    function generatePermissionsHtml($permissions) {
        foreach ($permissions as $permission) {
            echo("\n<tr class='parent_top'>"
            . "\n<td>"
            . "\n<input type='checkbox' class='main_parent chk' name='permission_ids[]' value='$permission->id'> "
            . "<label for='main_menu'>$permission->display_name <span class='btn glyphicon glyphicon-triangle-bottom'></span></label>"
            . "\n</td>"
            . "\n</tr>");
            //var_dump(array_key_exists("child_menu", $menu));

            if ($permission->type == "expand") {
                echo("\n<tr class='child_first'>\n<td>");
                load_child_options($permission->childrens, 2);
                echo("\n</td>\n</tr>");
            }elseif($permission->type == "open"){
                echo("\n<tr class='child_first single'>\n<td>");
                load_sub_child_options($permission->childrens, 2);
                echo("\n</td>\n</tr>");
            }
        }
    }

}

if (!function_exists('load_child_options')) {
    function load_child_options($permissions, $level = 0) {
        echo("\n<table class='table table-bordered'>");

        foreach ($permissions as $permission) {
            if ($permission->type == "open") {
                echo("\n<tr class='child_row lvl_" . $level . "'>"
                . "\n<td>"
                . "\n"
                . "<div class='row'>"
                . "<div class='col-xs-12'>"
                . "<input type='checkbox' class='child chk' name='permission_ids[]' value='$permission->id'> "
                . "$permission->display_name</div>");
                load_sub_child_options($permission->childrens);

                echo("</div>"
                . "\n</td>\n</tr>");
            } else if ($permission->type == "expand") {
                echo("\n<tr  class='parent_inner'>\n<th>"
                . "<input type='checkbox' class='sub_parent' name='permission_ids[]' value='$permission->id'> "
                . "$permission->display_name<span class='btn glyphicon glyphicon-triangle-bottom'></span></th>\n</tr>\n<tr class='child_inner'>\n<td>");

                load_child_options($permission->childrens, ($level + 1));
                echo("\n</td>\n</tr>");
            }
        }
        echo("\n</table>\n");
    }
}

if(!function_exists('load_sub_child_options')){
    function load_sub_child_options ($permissions){
        if(!empty($permissions)){
            foreach ($permissions as $permission){
                echo("<div class='col-xs-2'>"
                        . "<input type='checkbox' class='action' name='permission_ids[]' value='$permission->id'>"
                        . " $permission->display_name</div>");
            }
        }
    }
}