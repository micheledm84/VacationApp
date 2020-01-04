<?php



class Database {
    
    public $conn;
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "vacation_db";

    public function connect() {

        $this -> conn = null;

        try 
        { 
            $this->conn = new PDO('mysql:host=' . $this->servername . ';dbname=' . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) 
        {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
        return $this->conn;
    }
    
    function insertVacation($nome,$cognome,$data_inizio,$data_fine, $durata, $status, $emp_id) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                INSERT INTO vacation (Nome, Cognome, DataInizio, DataFine, Durata, Status, ID_emp)
                VALUES (?, ?, ?, ?, ?, ?, ?);");            
                $stmt->execute(array($nome,$cognome,$data_inizio,$data_fine, $durata, $status, $emp_id));
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        
    function insertDayOfLeave($nome, $cognome, $data_inizio, $data_fine, $ora_inizio, $ora_fine, $status, $all_day, $emp_id) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                INSERT INTO day_of_leave (FirstName, LastName, DayStart, DayEnd, HourStart, HourEnd, AllDay, Status, ID_emp)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");            
                $stmt->execute(array($nome,$cognome,$data_inizio,$data_fine, $ora_inizio, $ora_fine, $all_day, $status, $emp_id));
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        

        
    function selectEmployeesLogin() {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                SELECT Utente, Password, ID FROM `employees` WHERE RIP = 'false';");            
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        
    function selectDataEmployees($ID) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                SELECT * FROM `employees` WHERE ID = $ID;");            
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        
    function selectDataGroupById($ID) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                SELECT * FROM `groups` WHERE ID = $ID;");            
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        
    function selectDataVacationOrDayOfLeaveById($ID, $table) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                SELECT * FROM `$table` WHERE ID = $ID;");            
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        
        function selectVacationDayOfLeaveReport($select_status, $ferie_permesso, $select_nome) {

            try 
            {
                $this -> conn = $this->connect();
                $permission = $_SESSION['permission']; 
                $group = $_SESSION['group']; 
                if ($permission == 2) {
                    if ($select_status == "all" && $select_nome != "all" ) {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `" . $ferie_permesso . "` ON employees.ID = " . $ferie_permesso . ".ID_emp WHERE employees.ID = '" . $select_nome . "' ORDER BY " . $ferie_permesso . ".ID DESC;";
                    } elseif ($select_status != "all" && $select_nome == "all" ) {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `$ferie_permesso` ON employees.ID = $ferie_permesso.ID_emp WHERE $ferie_permesso.Status = '$select_status' AND employees.RIP = 'false'  ORDER BY $ferie_permesso.ID DESC;";
                    } elseif  ($select_status == "all" && $select_nome == "all" ) {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `$ferie_permesso` ON employees.ID = $ferie_permesso.ID_emp WHERE employees.RIP = 'false' ORDER BY $ferie_permesso.ID DESC;";
                    } else {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `$ferie_permesso` ON employees.ID = $ferie_permesso.ID_emp WHERE employees.ID = $select_nome AND $ferie_permesso.Status = '$select_status'  ORDER BY $ferie_permesso.ID DESC;";

                    }
                } else {
                    if ($select_status == "all" && $select_nome != "all" ) {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `" . $ferie_permesso . "` ON employees.ID = " . $ferie_permesso . ".ID_emp WHERE employees.ID = '" . $select_nome . "' ORDER BY " . $ferie_permesso . ".ID DESC;";
                    } elseif ($select_status != "all" && $select_nome == "all" ) {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `$ferie_permesso` ON employees.ID = $ferie_permesso.ID_emp WHERE $ferie_permesso.Status = '$select_status' AND employees.ID_Group = $group AND employees.RIP = 'false' ORDER BY $ferie_permesso.ID DESC;";
                    } elseif  ($select_status == "all" && $select_nome == "all" ) {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `$ferie_permesso` ON employees.ID = $ferie_permesso.ID_emp WHERE employees.ID_Group = $group AND employees.RIP = 'false' ORDER BY $ferie_permesso.ID DESC;";
                    } else {
                        $queryVacationDayOfLeaveReport = "SELECT * FROM employees LEFT JOIN `$ferie_permesso` ON employees.ID = $ferie_permesso.ID_emp WHERE employees.ID = $select_nome AND $ferie_permesso.Status = '$select_status' ORDER BY $ferie_permesso.ID DESC;";

                    }
                }
                $stmt = $this -> conn -> prepare($queryVacationDayOfLeaveReport);
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }

        }
        
        function updateStatusVacationDayOfLeave($id, $new_status, $table) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                UPDATE " . $table . " SET Status = '" . $new_status . "'
                WHERE ID = '" . $id . "';");            
                $stmt->execute();
                return $stmt;
                
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
                
            }

        }
        
        function selectAllNamesEmployees() {

            try 
            {

                $this -> conn = $this->connect();
                if ($_SESSION['permission'] == 2) {
                    $stmt = $this -> conn -> prepare("SELECT ID, FirstName, LastName FROM employees WHERE RIP = 'false'");   
                } else {
                    $query_permission_group = "SELECT ID, FirstName, LastName FROM employees WHERE ID_Group = " . $_SESSION['group'] . " AND RIP = 'false'";
                    $stmt = $this -> conn -> prepare($query_permission_group);   
                }
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
                
            }

        }
        
        function selectAllNamesGroups() {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                SELECT ID, Name, Mail FROM groups WHERE RIP = 'false'");            
                $stmt->execute();
                return $stmt;
            } 
            catch(PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
                
            }

        }
        
        function insertNewEmployee($array_emp) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                INSERT INTO employees (FirstName, LastName, Mail, Permission, Utente, Password, AssumptionDate, ID_Group, RIP)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");            
                $stmt->execute(array($array_emp[0],$array_emp[1],$array_emp[2],$array_emp[3], $array_emp[4], $array_emp[5], $array_emp[6], $array_emp[7], $array_emp[8]));
                return $array_emp[0] . " " . $array_emp[1] . " has been inserted!";
            } 
            catch(PDOException $e) 
            {
                return "Error: " . $e->getMessage();
            }

        }
        
        function insertNewGroup($array_group) {

            try 
            {

                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                INSERT INTO groups (Name, Mail, RIP)
                VALUES (?, ?, ?);");            
                $stmt->execute(array($array_group[0],$array_group[1],$array_group[2]));
                return "The group " . $array_group[0] . " has been created!";
            } 
            catch(PDOException $e) 
            {
                return "Error: " . $e->getMessage();
            }

        }
        
        function editEmployeeById($edit_employee) {

            try 
            {
                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                UPDATE employees SET FirstName = ?, LastName = ?, Mail = ?, Permission = ?, Utente = ?, Password = ?, AssumptionDate = ?, ID_Group = ?, RIP = ?
                WHERE ID = ?");            
                $stmt->execute(array($edit_employee[0],$edit_employee[1],$edit_employee[2],$edit_employee[3], $edit_employee[4], 
                    $edit_employee[5], $edit_employee[6], $edit_employee[8], $edit_employee[9], $edit_employee[7]));
                return $edit_employee[0] . " " . $edit_employee[1] . " has been edited!";
            } 
            catch(PDOException $e) 
            {
                return "Error: " . $e->getMessage();
            }
        }
        
        function editGroupById($edit_group) {

            try 
            {
                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                UPDATE groups SET Name = ?, Mail = ?, RIP = ?
                WHERE ID = ?");            
                $stmt->execute(array($edit_group[0],$edit_group[1],$edit_group[3],$edit_group[2]));
                return "The group " . $edit_group[0] . " has been edited!";
            } 
            catch(PDOException $e) 
            {
                return "Error: " . $e->getMessage();
            }
        }
        
        function deleteEmployeeByIdAdmin($delete_employee) {

            try 
            {
                $this -> conn = $this->connect();
                $stmt_names = $this -> selectDataEmployees($delete_employee);
                $row = $stmt_names -> fetch();   
                $array_names = array($row ["FirstName"],$row ["LastName"]);
    
                $stmt = $this -> conn -> prepare("
                DELETE FROM `employees` WHERE ID = ?");            
                $stmt->execute(array($delete_employee));
                return "$array_names[0] $array_names[1] has been deleted!";
            } 
            catch(PDOException $e) 
            {
                return "Error: " . $e->getMessage();
            }

        }
        
        function deleteGroupByIdAdmin($delete_group) {

            try 
            {
                $this -> conn = $this->connect();
                $stmt = $this -> conn -> prepare("
                DELETE FROM `groups` WHERE ID = ?");            
                $stmt->execute(array($delete_group[0]));
                return "The group $delete_group[1] has been deleted!";
            } 
            catch(PDOException $e) 
            {
                return "Error: " . $e->getMessage();
            }

        }
        
        
   
    
}


