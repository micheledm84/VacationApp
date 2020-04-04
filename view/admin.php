<?php
    include_once (dirname(__FILE__) . "/../functions/functions.php");
?>

<html>
    <body>
        <form id="send_post" name="send_post" method="post" >
            <?php include '../common/navbar.php';?>
                
            <div id="title_section">
                    <h4>Modify settings and database</h4>
            </div>
            <br>
            <div >
                <label for="operation_admin">Select operation:</label>
                <select onchange="selectOperationDiv()" name="operation_admin" id="operation_admin">
                    <?php listAllOperations($db) ?>
                </select>
            </div>
            <?php include 'integrations/admin_employee_section.php';?>
            <?php include 'integrations/admin_group_section.php';?>
        </form>
    </div>
        <script>
            
            /*$( document ).ready(function() {
                $("#admin_p").removeClass('text-success');
                $("#admin_p").addClass('text-white');
            });*/
            
            function selectOperationDiv() {
                var operation_selected = document.getElementById('operation_admin').value;
                if (operation_selected === "Employees") {
                    $("#employee_table_section").removeClass('hidden')
                    $("#group_table_section").addClass('hidden')
                } else if (operation_selected === "Groups") {
                    $("#group_table_section").removeClass('hidden')
                    $("#employee_table_section").addClass('hidden')
                } else {
                    $("#employee_table_section").addClass('hidden')
                    $("#group_table_section").addClass('hidden')
                }
            }
            
            function edit_group_ajax() {
                        var id_group_edit = document.getElementById('groups_admin').value;
                        var isRip = $('#group_RIP').prop("checked");

                        if (id_group_edit == 0) {
                            alert('Select a group before editing!');
                            return;
                        }
                        var name = document.getElementById('group_name').value;
                        var mail = document.getElementById('group_mail').value.toLowerCase();;
                        var arr_no_empty = [name, mail]; 
                        
                        if (isEmpty(arr_no_empty)) {
                            alert('Fill in every field to edit');
                            return;
                        }
                        
                        if (!checkMailFormat(mail)) {
                            alert('The format of the mail is not correct');
                            return;
                        }
                        
                        $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_edit_group.php",
                            data: 'group_id=' + id_group_edit + '&group_name=' + name + '&group_mail=' + mail + '&isRip=' + isRip,
                            success: function(data){
                                alert(data);
                                location.reload();
                            }
                            });
             };
            
            function edit_employee_ajax() {
                        var group = document.getElementById('groups_employee_admin').value;
                        var id_emp_edit = document.getElementById('employees_admin').value;
                        if (id_emp_edit == 0) {
                            alert('Select an employee before to edit!');
                            return;
                        }
                        var nome = document.getElementById('nome').value;
                        var cognome = document.getElementById('cognome').value;
                        var mail = document.getElementById('mail').value.toLowerCase();;
                        var permessi = document.getElementById('permessi').value;
                        var utente = document.getElementById('utente').value;
                        var password = document.getElementById('password').value;
                        var data_assunzione = document.getElementById('data_assunzione').value;
                        var isRip = $('#employees_RIP').prop("checked");
                        var arr_no_empty = [nome, cognome, mail, permessi, utente, password, data_assunzione, group];  
                        
                        if (isEmpty(arr_no_empty)) {
                            alert('Fill in every field to edit');
                            return;
                        }
                        
                        if (!checkMailFormat(mail)) {
                            alert('The format of the mail is not correct');
                            return;
                        }
                        
                        $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_edit_employee.php",
                            data: 'nome=' + nome + '&cognome=' + cognome + '&mail=' + mail + 
                                  '&permessi=' + permessi + '&utente=' + utente + '&password=' + password + 
                                  '&data_assunzione=' + data_assunzione + '&id_emp_edit=' + id_emp_edit + '&group=' + group
                                    + '&isRip=' + isRip,
                            success: function(data){
                                alert(data);
                                location.reload();
                            }
                            });
             };
             
             function delete_group_ajax() {
                        var id_group_delete = document.getElementById('groups_admin').value;
                        var name_group_delete = $("#groups_admin>option:selected").html()
                        
                        if (id_group_delete == 0) {
                            alert('Select a group before deleting!');
                            return;
                        }  
                        $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_delete_group.php",
                            data: 'id_group_delete=' + id_group_delete + '&name_group_delete=' + name_group_delete,
                            success: function(data){
                                alert(data);
                                location.reload();
                            }
                            });
             };
             
             function delete_employee_ajax() {
                        var id_emp_delete = document.getElementById('employees_admin').value;
                        
                        if (id_emp_delete == 0) {
                            alert('Select an employee before to delete!');
                            return;
                        }  
                        $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_delete_employee.php",
                            data: 'id_emp_delete=' + id_emp_delete,
                            success: function(data){
                                alert(data);
                                location.reload();
                            }
                            });
             };

            function insert_group_ajax() {
                        var group_name = document.getElementById('group_name').value;
                        var group_mail = document.getElementById('group_mail').value.toLowerCase();;
                        var isRip = $('#group_RIP').prop("checked");
                        
                        var arr_no_empty = [group_name, group_mail];
                        
                        if (isEmpty(arr_no_empty)) {
                            alert('Fill in every field to insert a new employee');
                            return;
                        }
                        
                        if (!checkMailFormat(group_mail)) {
                            alert('The format of the mail is not correct');
                            return;
                        }
                        
                        $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_insert_group.php",
                            data: 'name=' + group_name + '&mail=' + group_mail + '&isRip=' + isRip,



                            success: function(data){
                                alert(data);
                                location.reload();


                            }
                            });
                          };
            
            
            function insert_employee_ajax() {
                        var group = document.getElementById('groups_employee_admin').value;
                        var nome = document.getElementById('nome').value;
                        var cognome = document.getElementById('cognome').value;
                        var mail = document.getElementById('mail').value.toLowerCase();
                        var permessi = document.getElementById('permessi').value;
                        var utente = document.getElementById('utente').value;
                        var password = document.getElementById('password').value;
                        var data_assunzione = document.getElementById('data_assunzione').value;
                        var isRip = $('#employees_RIP').prop("checked");
                        
                        var arr_no_empty = [nome, cognome, mail, permessi, utente, password, data_assunzione, group];
                        
                        
                    
                        if (isEmpty(arr_no_empty)) {
                            alert('Fill in every field to insert a new employee');
                            return;
                        }
                        
                        //mail = mail.toLowerCase();
                        if (!checkMailFormat(mail)) {
                            alert('The format of the mail is not correct');
                            return;
                        }
                        
                        $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_insert_employee.php",
                            data: 'nome=' + nome + '&cognome=' + cognome + '&mail=' + mail + 
                                  '&permessi=' + permessi + '&utente=' + utente + '&password=' + password + 
                                  '&data_assunzione=' + data_assunzione + '&group=' + group + '&isRip=' + isRip,



                            success: function(data){
                                alert(data);
                                location.reload();
                            }
                            });
                          };
                          
            function fillGroupData(group_id) {
                var group_selected = group_id.value;
                
                  
                  $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_select_group.php",
                            data: 'group_selected=' + group_selected,

                            success: function(data){
                                var group_data = JSON.parse(data);
                                document.getElementById('group_name').value = group_data[1];
                                document.getElementById('group_mail').value = group_data[2];
                                document.getElementById('group_RIP').checked = JSON.parse(group_data[3]);


                            }
                          });
            };
            
            function fillEmployeeData(emp_id) {
                var emp_selected = emp_id.value;
                
                  
                  $.ajax({
                            type: "POST",
                            url:  "../ajax/admin_select_employee.php",
                            data: 'emp_selected=' + emp_selected,

                            success: function(data){
                                var emp_data = JSON.parse(data);
                                document.getElementById('nome').value = emp_data[1];
                                document.getElementById('cognome').value = emp_data[2];
                                document.getElementById('mail').value = emp_data[3];
                                document.getElementById('permessi').value = emp_data[4];
                                document.getElementById('utente').value = emp_data[5];
                                document.getElementById('password').value = emp_data[6];
                                document.getElementById('data_assunzione').value = emp_data[7];
                                document.getElementById('groups_employee_admin').value = emp_data[8];
                                document.getElementById('employees_RIP').checked = JSON.parse(emp_data[9]);
                            }
                          });
            };
            
            function isEmpty(arr_to_check) {
                var i;
                        
                for (i = 0; i < arr_to_check.length; i++) { 
                    if (arr_to_check[i] == "") {
                        return true;
                    }
                }
                return false;
            };
            
            function checkMailFormat(mail) {
                var regularExpressionMail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (regularExpressionMail.test(String(mail))) {
                    return true;
                }
                return false;
            };
            
 
            
            
            
            
            </script>
            
    </body>
</html>



<?php 
include '../common/footer.php';

if ( !isset( $_SESSION['ID'] ) or $_SESSION['permission'] != 2 ) {
    logout();
}



