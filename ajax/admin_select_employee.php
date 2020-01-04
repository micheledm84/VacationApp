<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");

if ( isset( $_POST['emp_selected'] ) ) {
    $emp_id = $_POST['emp_selected'];
    $emp_selected_data = $db -> selectDataEmployees($emp_id);
    $row = $emp_selected_data -> fetch();   
    $array_resp = array($row ["ID"],$row ["FirstName"],$row ["LastName"],$row ["Mail"],$row ["Permission"],$row ["Utente"],$row ["Password"],$row ["AssumptionDate"],$row ["ID_Group"],$row ["RIP"]);
    
    echo json_encode($array_resp);
}

