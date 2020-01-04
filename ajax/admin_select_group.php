<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");

if ( isset( $_POST['group_selected'] ) ) {
    $group_id = $_POST['group_selected'];
    $group_selected_data = $db -> selectDataGroupById($group_id);
    $row = $group_selected_data -> fetch();   
    $array_resp = array($row ["ID"],$row ["Name"],$row ["Mail"],$row ["RIP"]);
    
    echo json_encode($array_resp);
}

