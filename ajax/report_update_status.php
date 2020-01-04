<?php


include_once (dirname(__FILE__) . "/../functions/functions.php");




if ( isset( $_POST['new_status'] ) ) {
    $id = $_POST['id'];
    $new_status = $_POST['new_status'];
    $new_table = $_POST['table_manager'];
    
    
    $db -> updateStatusVacationDayOfLeave($id, $new_status, $new_table);
    $vacation_dayOfLeave_data = $db -> selectDataVacationOrDayOfLeaveById($id, $new_table);
    $row_id_emp = $vacation_dayOfLeave_data -> fetch();
    $employee_names = $db -> selectDataEmployees($row_id_emp['ID_emp']);
    $row_names = $employee_names -> fetch();
    $status_name = statusNames($new_status);
    $message = "";
    if($new_table == 'vacation') {
        $message = buildMailVacationChangeStatus($row_names['FirstName'], $row_names['LastName'], $status_name, $row_id_emp['DataInizio'], $row_id_emp['DataFine']);
        $response_mail = sendMailAjax($db, $message, 'vacation response', $row_names['Mail'], $row_names['FirstName'], $row_names['LastName']);

    } else {
        $message = buildMailDayOfLeaveChangeStatus($row_names['FirstName'], $row_names['LastName'], $status_name, $row_id_emp['DayStart'], $row_id_emp['DayEnd'], $row_id_emp['AllDay'], $row_id_emp['HourStart'], $row_id_emp['HourEnd']);
        $response_mail = sendMailAjax($db, $message, 'day of leave response request', $row_names['Mail'], $row_names['FirstName'], $row_names['LastName']);     
    }

    $response_vacation = array($id, $new_status, $new_table, $row_names['FirstName'], $row_names['LastName'], $status_name, $response_mail);
    
    echo json_encode($response_vacation);
    
}
