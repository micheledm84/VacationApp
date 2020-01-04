<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");


if ( isset( $_POST['group_id'] ) ) {
    $edit_group = array($_POST['group_name'], $_POST['group_mail'], $_POST['group_id'], $_POST['isRip']);
    $response = $db -> editGroupById($edit_group);    
    echo $response;
}

