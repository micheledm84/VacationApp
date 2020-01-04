<?php

include_once (dirname(__FILE__) . "/../functions/functions.php");


if ( isset( $_POST['id_emp_delete'] ) ) {
    $delete_employee = $_POST['id_emp_delete'];
    $response = $db -> deleteEmployeeByIdAdmin($delete_employee);    
    echo $response;
}

