<div id="employee_table_section" class="admin_table hidden" >
                <label for="employees_admin">Select employee:</label>
                <select onchange="fillEmployeeData(this)" name="employees_admin" id="employees_admin">
                    <?php listAllEmployees($db) ?>
                </select>
                <br><br>
                    <table>
                        <tr><td>Name:</td><td> <input type="text" id="nome" name="nome"></input></td></tr>
                        <tr><td>Surname:</td><td> <input type="text" id="cognome" name="cognome"></input></td></tr>
                        <tr><td>Mail:</td><td> <input type="email" id="mail" name="mail"></input></td></tr>
                        <tr><td>Permissions:</td><td> <select name="permessi" id="permessi">
                            <?php listAllPermissions($db) ?>
                        </select></td></tr>
                        <tr><td>Group:</td><td> <select name="groups_employee_admin" id="groups_employee_admin">
                            <?php listAllGroups($db) ?>
                        </select></td></tr>
                        <tr><td>User:</td><td> <input type="text" id="utente" name="utente"></input></td></tr>
                        <tr><td>Password:</td><td> <input type="text" id="password" name="password"></input></td></tr>
                        <tr><td>Hiring Date:</td><td> <input type="date" id="data_assunzione" name="data_assunzione"></input></td></tr>
                        <tr><td>RIP:</td><td><input type="checkbox" name="employees_RIP" id="employees_RIP" /></input></td></tr>
                    </table><br><br>
                    <button onclick="insert_employee_ajax()" type="button" id="insert_employee" class="btn btn-success same_width">Insert</button>
                    <button onclick="edit_employee_ajax()" type="button" id="edit_employee" class="btn btn-primary same_width">Edit</button>
                    <button onclick="delete_employee_ajax()" type="button" id="delete_employee" class="btn btn-danger same_width">Delete</button>
                    <br><br><br>
</div>

