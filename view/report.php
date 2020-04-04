<?php include '../common/navbar.php';?>

                
            <div id="title_section">
                    <h4>Check Reports</h4>
            </div>
            <br>
                <div class="row-fluid" id="row_report">
                    <div class="col-lg-1">
                        Type
                    </div>
                    <div class="col-lg-2">

                        <select name="ferie_permesso" id="ferie_permesso">
                            <option <?php if (isset ($_POST['ferie_permesso'])) { checkSelectionManager($_POST['ferie_permesso'], 'all'); } ?> value="all">All</option>
                            <option <?php if (isset ($_POST['ferie_permesso'])) { checkSelectionManager($_POST['ferie_permesso'], 'vacation'); } ?> value="vacation">Vacation</option>
                            <option <?php if (isset ($_POST['ferie_permesso'])) { checkSelectionManager($_POST['ferie_permesso'], 'day_of_leave'); }?> value="day_of_leave">Day Of Leave</option>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        Status
                    </div>
                    <div class="col-lg-2">
                        <select name="select_status" id="select_status">
                            <option <?php if (isset ($_POST['select_status'])) { checkSelectionManager($_POST['select_status'], 'all'); }?> value="all">All</option>
                            <option <?php if (isset ($_POST['select_status'])) { checkSelectionManager($_POST['select_status'], '0'); }?> value="0">Suspended</option>
                            <option <?php if (isset ($_POST['select_status'])) { checkSelectionManager($_POST['select_status'], '1'); }?> value="1">Accepted</option>
                            <option <?php if (isset ($_POST['select_status'])) { checkSelectionManager($_POST['select_status'], '2'); }?> value="2">Rejected</option>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        Full Name
                    </div>
                    <div class="col-lg-2">
                        <select name="select_nome" id="select_nome">
                            <?php 
                            if (isset ($_POST['select_nome'])) { fillSelectNomeReport($db, $_POST['select_nome']); } else { fillSelectNomeReport($db, '0'); }; 
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <button type="submit" name="manager_report" class="btn btn-success">Search</button>
                    </div>
                    <div class="pull-right">
                    </div>
                    
                </div>
            
            
        </div> 
        
        <br>
        <script>
            
            /*$( document ).ready(function() {
                $("#report_p").removeClass('text-success');
                $("#report_p").addClass('text-white');
            });*/
            
            function passToAjax(input_value, table_manager) {
               $.ajax({
                    type: "POST",
                    url:  "../ajax/report_update_status.php",
                    data: 'id=' + input_value.id + '&new_status=' + input_value.value + '&table_manager=' + table_manager,

                    success: function(data){
                        var data_decoded = JSON.parse(data);
                        var id_new = data_decoded[0];
                        var td_new = "#status_" + id_new;
                        var status_new = data_decoded[1];
                        $('#manager_dynamic_table').find(td_new).html(status_new);
                        alert('The request of ' + data_decoded[3] + ' ' + data_decoded[4] + ' has been ' + data_decoded[5]
                                + '. ' + data_decoded[6]);
                    }
                  });
            };
        </script>
        </form>
    </body>
</html>

<?php

include '../common/footer.php';

if ( !isset( $_SESSION['ID'] ) ) {
    logout();
}

if ( isset( $_POST['manager_report'] ) ) {
        $ferie_permesso = $_POST['ferie_permesso'];
        $select_status = $_POST['select_status'];
        $select_nome = $_POST['select_nome'];


        chooseReportTable($db, $ferie_permesso, $select_status, $select_nome);
}
        




