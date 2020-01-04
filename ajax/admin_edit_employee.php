<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");


if ( isset( $_POST['id_emp_edit'] ) ) {
    $edit_employee = array($_POST['nome'], $_POST['cognome'], $_POST['mail'], $_POST['permessi'],
            $_POST['utente'], $_POST['password'], $_POST['data_assunzione'], $_POST['id_emp_edit'], $_POST['group'],
            $_POST['isRip']);
    $response = $db -> editEmployeeById($edit_employee);    
    echo $response;
}

