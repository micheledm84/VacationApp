<?php

session_start();


include_once (dirname(__FILE__) . "/../db/data_access.php");

$db = new Database();


        
if ( isset( $_POST['logout_button'] ) ) {
    logout();
}



function logout() {
    session_destroy();
    $message_logout = "You have been disconnected";
    echo "<script type='text/javascript'>alert('$message_logout');</script>";
    echo "<script type='text/javascript'>window.location.href = \"../view/login.php\";</script>";
}

function dateChecker($data_inizio, $data_fine) {
    $earlier = new DateTime($data_inizio);
    $later = new DateTime($data_fine);

    $diff = $later->diff($earlier)->format("%a");
    
    return $diff;
}

function credentialsChecker($db, $utente_input, $pwd_input) {
    $user_pwd = $db -> selectEmployeesLogin();
    
    while($row = $user_pwd->fetch()) {
        if ($row['Utente'] == $utente_input && $pwd_input == $row['Password']) {
            return $row['ID'];
        }
    }
    return false;
}

function buildSession($db, $ID) {
    $session_data = $db -> selectDataEmployees($ID);
    $row = $session_data->fetch();
    $_SESSION['ID'] = $ID;
    $_SESSION['utente'] = $row['Utente'];
    $_SESSION['password'] = $row['Password'];
    $_SESSION['nome'] = $row['FirstName'];
    $_SESSION['cognome'] = $row['LastName'];
    $_SESSION['mail'] = $row['Mail'];
    $_SESSION['permission'] = $row['Permission'];
    $_SESSION['group'] = $row['ID_Group'];
}

function buildHourSelect($name_select) {
    echo "<select name=\"$name_select\" id=\"$name_select\">";
        for($i = 0; $i <= 9; $i++) {
            $temp = $i + 1;
            echo "<option value=\"$temp\">0$i:00</option>";
        }
        for($i = 10; $i <= 23; $i++) {
            $temp = $i + 1;
            echo "<option value=\"$temp\">$i:00</option>";
        }
    echo "</select>";
}

function chooseReportTable($db, $ferie_permesso, $select_status, $select_nome) {
    if ($ferie_permesso != 'all') {
        $report_manager = $db -> selectVacationDayOfLeaveReport($select_status, $ferie_permesso, $select_nome);
        if ($ferie_permesso == 'vacation') {
            buildVacationTable($report_manager);
        } else {
            buildDayOfLeaveTable($report_manager);
        } 
    } else {
        $report_vacation = $db -> selectVacationDayOfLeaveReport($select_status, 'vacation', $select_nome);
        $report_day_of_leave = $db -> selectVacationDayOfLeaveReport($select_status, 'day_of_leave', $select_nome);
        buildAllVacationDayOfLeaveTable($report_vacation, $report_day_of_leave);
    }
}

function buildDayOfLeaveTable($report_permesso) {
    echo '<div class="container">';
    //echo '<br>';
    echo "<h5>Day Of Leave Report</h5>";

    echo '<table class="table table-condensed table table-bordered table-hover table-responsive" id="manager_dynamic_table">';
        echo '<thead>';
          echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Surname</th>';
            echo '<th>Start Date</th>';
            echo '<th>End Date</th>';
            echo '<th>All Day</th>';
            echo '<th>Start Hour</th>';
            echo '<th>End Hour</th>';
            echo '<th>Status</th>';
            echo '<th> </th>';
        echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while($row = $report_permesso->fetch()) {
        if (isset($row['ID'])) {
            echo '<tr>';
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DayStart'] . "</td>";
                echo "<td>" . $row['DayEnd'] . "</td>";
                echo "<td>" . $row['AllDay'] . "</td>";
                echo "<td>" . $row['HourStart'] . "</td>";
                echo "<td>" . $row['HourEnd'] . "</td>";
                echo "<td id='status_" . $row['ID'] ."'>" . $row['Status'] . "</td>";
                echo "<td><select ";
                if ($_SESSION['permission'] == 0) { echo " disabled "; }
                echo " onchange=\"passToAjax(this, 'day_of_leave')\" name='" . "select_" . $row['ID'] . "' id='" . $row['ID'] . "'>";
                       echo "<option " . checkSelectedStatusManager (0, $row['Status']) . " value=\"0\">Suspended</option>";
                    echo "<option " . checkSelectedStatusManager (1, $row['Status']) . " value=\"1\">Accepted</option>";
                    echo "<option " . checkSelectedStatusManager (2, $row['Status']) . " value=\"2\">Rejected</option>";
                echo "</select></td>";
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</br></br>';
}

function buildVacationTable($report_vacation) {
    $id_max = 0;
    echo '<div class="container">';
    //echo '<br>';
    echo "<h5>Vacation Report</h5>";
    echo '<table class="table table-condensed table-bordered table-hover table-responsive" id="manager_dynamic_table">';
        echo '<thead>';
          echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Surname</th>';
            echo '<th>Start Date</th>';
            echo '<th>End Date</th>';
            echo '<th>Length</th>';
            echo '<th>Status</th>';
            echo '<th> </th>';
        echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while($row = $report_vacation->fetch()) {
        if (isset($row['ID'])) {
            echo '<tr>';
                $id_max = checkMaxId($id_max, $row['ID']);
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['Nome'] . "</td>";
                echo "<td>" . $row['Cognome'] . "</td>";
                echo "<td>" . $row['DataInizio'] . "</td>";
                echo "<td>" . $row['DataFine'] . "</td>";
                echo "<td>" . $row['Durata'] . "</td>";
                echo "<td id='status_" . $row['ID'] ."'>" . $row['Status'] . "</td>";
                echo "<td><select ";
                if ($_SESSION['permission'] == 0) { echo " disabled "; }
                echo " onchange=\"passToAjax(this, 'vacation')\" name='" . "select_" . $row['ID'] . "' id='" . $row['ID'] . "'>";

                    echo "<option " . checkSelectedStatusManager (0, $row['Status']) . " value=\"0\">Suspended</option>";
                    echo "<option " . checkSelectedStatusManager (1, $row['Status']) . " value=\"1\">Accepted</option>";
                    echo "<option " . checkSelectedStatusManager (2, $row['Status']) . " value=\"2\">Rejected</option>";
                echo "</select></td>";
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '<input type="hidden" name="input_' . $id_max . ' id="input_counter" value="' . $id_max . '">';
    echo '</div>';
    
    echo '</br></br>';
}

function buildAllVacationDayOfLeaveTable($report_vacation, $report_day_of_leave) {
    buildVacationTable($report_vacation);
    buildDayOfLeaveTable($report_day_of_leave);
}

function checkMaxId($id_max, $id) {
    if($id > $id_max) {
        return $id;
    } else {
        return $id_max;
    }
}

function checkSelectionManager($post, $value) {
    if (isset ($post)) {
        if ($post == $value) {
            echo " selected ";
        }
        
    }
}

function checkSelectedStatusManager ($id_old, $id_new) {
    if ($id_old == $id_new) {
        return "selected";
    }
}

function fillSelectNomeReport($db, $id) {
    if ($_SESSION['permission'] == 2 or $_SESSION['permission'] == 1) {
        $all_names = $db -> selectAllNamesEmployees();
        $temp_selected = "";
        echo "<option value=\"all\">All</option>";
        while($row = $all_names->fetch()) {
            if ($row['ID'] == $id) {
                $temp_selected = " selected ";
            } else {
                $temp_selected = "";
            }
                echo "<option value=" . $row['ID'] . " " . $temp_selected . ">" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
        }
    } else {
        echo "<option value=" . $_SESSION['ID'] . " selected>" . $_SESSION['nome'] . " " . $_SESSION['cognome'] . "</option>";
   
    }
}

function listAllGroups($db) {
    $all_groups = $db -> selectAllNamesGroups();
    echo "<option value=\"0\"></option>";

    while($row = $all_groups->fetch()) {
        echo "<option value=" . $row['ID'] . ">" . $row['Name'] . "</option>";
    }
}

function listAllPermissions($db) {
    echo "<option value=\"0\">0</option>";
    echo "<option value=\"1\">1</option>";
    echo "<option value=\"2\">2</option>";
}

function listAllOperations($db) {
    echo "<option value=\"Def\"></option>";
    echo "<option value=\"Employees\">Employees</option>";
    echo "<option value=\"Groups\">Groups</option>";
}

function listAllEmployees($db) {
    $all_employees = $db -> selectAllNamesEmployees();
    echo "<option value=\"0\"></option>";

    while($row = $all_employees->fetch()) {
        echo "<option value=" . $row['ID'] . ">" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
    }
}

function date_eu_to_us($date_to_convert) {
            $date_converted = explode("-", $date_to_convert);
            $date_converted = $date_converted[2] . '-' . $date_converted[1] . '-' . $date_converted[0];
            return $date_converted;
        }
        
function printName() {
    echo "<p class=\"pull-right\"><strong>" . $_SESSION['nome'] . " " . $_SESSION['cognome'] . "</strong> is connected</p>";
}

function printAdminNavbar() {
    echo '<li>';
        echo '<a class="nav-link" href="../view/admin.php"><p class="text-success" id="admin_p">Admin Area</p></a>';
    echo '</li>';
    
}
    
function echoAlert($message_alert, $reload) {
    echo "<script type='text/javascript'>alert('$message_alert');</script>";
    if ($reload) {
        echo "<script type='text/javascript'>location.reload();</script>";

    }

}

function statusNames($status_number) {
    if($status_number == 0) {
        return "suspended";
    } else if ($status_number == 1) {
        return "accepted";
    } else {
        return "rejected";
    }

}

function sendMail($db, $message, $subject) { 
    $mail_group = $db -> selectDataGroupById($_SESSION['group']);
    $row = $mail_group -> fetch();
    $to = $row['Mail'];
    if (mail($to,$subject,$message)) {
        $message_alert = "The mail has been sent for the approval";
        echoAlert($message_alert, false);
    } else {
        $message_alert = "The mail could not be sent";
        echoAlert($message_alert, false);
    }
}

function sendMailAjax($db, $message, $subject, $to, $name, $surname) { 
    if (mail($to,$subject,$message)) {
        return "One mail has been sent to inform " . $name . " " . $surname;
    } else {
        return "The mail could not be sent";
    }
}

function buildMailVacationChangeStatus($name, $surname, $status, $startDate, $endDate) {
    $message = "Dear " . $name . " " . $surname . ",\n\n";
    $message = $message . "You request of vacation from " . $startDate . " to " . $endDate . " has been " . $status . ".\n\n";
    $message = $message . "Have a nice day,\n\n";
    $message = $message . "Vacation App";
    return $message;
}

function buildMailDayOfLeaveChangeStatus($name, $surname, $status, $startDate, $endDate, $allDay, $startHour, $endHour) {
    $message = "Dear " . $name . " " . $surname . ",\n\n";
    $message = $message . "You request of day of leave from " . $startDate . " to " . $endDate;
    if ($allDay == 1) {
        $message = $message . " (all the day) ";
    } else {
        $message = $message . " (from " . $startHour . " to " . $endHour . ") ";
    }
    $message = $message . "has been " . $status . ".\n\n";
    $message = $message . "Have a nice day,\n\n";
    $message = $message . "Vacation App";
    return $message;
}
 