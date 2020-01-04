<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");


if ( isset( $_POST['data_assunzione'] ) ) {
    $insert_employee = array($_POST['nome'], $_POST['cognome'], $_POST['mail'], $_POST['permessi'],
            $_POST['utente'], $_POST['password'], $_POST['data_assunzione'], $_POST['group'], $_POST['isRip']);
    $response = $db -> insertNewEmployee($insert_employee);
    echo $response;
} 

