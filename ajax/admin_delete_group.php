<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");


if ( isset( $_POST['id_group_delete'] ) ) {
    $id_delete_group = $_POST['id_group_delete'];
    $name_delete_group = $_POST['name_group_delete'];
    $delete_group = array($id_delete_group, $name_delete_group);
    $response = $db -> deleteGroupByIdAdmin($delete_group);    
    echo $response;
}

