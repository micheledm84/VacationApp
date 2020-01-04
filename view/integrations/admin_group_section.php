<div id="group_table_section" class="admin_table hidden" >
                <label for="groups_admin">Select group:</label>
                <select onchange="fillGroupData(this)" name="groups_admin" id="groups_admin">
                    <?php listAllGroups($db) ?>
                </select>
                <br><br>
                    <table>
                        <tr><td>Name:</td><td> <input type="text" id="group_name" name="group_name"></input></td></tr>
                        <tr><td>Mail:</td><td> <input type="email" id="group_mail" name="group_mail"></input></td></tr>
                        <tr><td>RIP:</td><td><input type="checkbox" name="group_RIP" id="group_RIP" /></input></td></tr>

                    </table><br><br>
                    <button onclick="insert_group_ajax()" type="button" id="insert_group" class="btn btn-success same_width">Insert</button>
                    <button onclick="edit_group_ajax()" type="button" id="edit_group" class="btn btn-primary same_width">Edit</button>
                    <button onclick="delete_group_ajax()" type="button" id="delete_group" class="btn btn-danger same_width">Delete</button>
                    <br><br><br>
</div>

