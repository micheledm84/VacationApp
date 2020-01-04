<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");


if ( isset( $_POST['name'] ) ) {
    $insert_group = array($_POST['name'], $_POST['mail'], $_POST['isRip']);
    $response = $db -> insertNewGroup($insert_group);
    echo $response;
} 

