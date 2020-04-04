<?php include '../common/navbar.php';?>
                
                <div id="title_section">
                    <h4>Insert your Vacation details</h4>
                </div>
                <div class="row">
                    <div id="table_section" class="col-sm-5">
                        <table>
                            <tr><td><label>Name: </label></td><td> <input type="text" class="noChange" id="nome" name="nome" readonly value="<?php echo $_SESSION['nome'];?>"></input></td></tr>
                            <tr><td><label>Surname: </label></td><td> <input type="text" class="noChange" id="cognome" name="cognome" readonly value="<?php echo $_SESSION['cognome'];?>"></input></td></tr>
                            <tr><td><label>Start Date: </label></td><td> <input type="date" id="data_inizio" name="data_inizio" onchange="fillStartDay()"></input></td></tr>
                            <tr><td><label>Start Day: </label></td><td> <input class="noChange" type="text" id="giorno_inizio" name="giorno_inizio" readonly ></input></td></tr>
                            <tr><td><label>End Date: </label></td><td> <input type="date" id="data_fine" name="data_fine" onchange="fillEndDay()"></input></td></tr>
                            <tr><td><label>End Day: </label></td><td> <input class="noChange" type="text" id="giorno_fine" name="giorno_fine" readonly></input></td></tr>
                            <tr><td><label>Type: </label></td><td> <input class="noChange" type="text" id="type" name="giorno_fine" value="Vacation" readonly></input></td></tr>
                            <tr><td> <input type="hidden" id="hidden_mail_text" name="hidden_mail_text"></input></td></tr>

                        </table><br><br>
                        <button type="button" name="button_add" id="button_add" onclick="add_text_to_mail()" class="btn btn-primary">Add to Mail</button>

                    </div>

                    <div class="form-group col-sm-5">
                      <label for="mail_text">Your Email:</label>
                      <textarea class="form-control" rows="10" id="mail_text" name="mail_text" readonly></textarea>
                      <br>
                      <button type="submit" id="button_send_mail" name="send_mail" class="btn btn-success">Send Mail</button>
                      <button type="button" name="button_erase" id="button_erase" onclick="erase_all()" class="btn btn-danger">Erase All</button>

                    </div>
                </div>
                <br><br>
            
        </div>
        
        <script>
        
        /*$( document ).ready(function() {
            $("#vacation_p").removeClass('text-success');
            $("#vacation_p").addClass('text-white');
        });*/
            
        function erase_all() {
            document.getElementById('data_inizio').value = "";
            document.getElementById('giorno_inizio').value = "";
            document.getElementById('data_fine').value = "";
            document.getElementById('giorno_fine').value = "";
            document.getElementById('mail_text').value = "";
            document.getElementById('hidden_mail_text').value = "";
            alert('Everything has been erased!');
        }
            
        function fillStartDay() {
          var data_inizio = document.getElementById("data_inizio").value;
          var dayName = findDay(data_inizio);
          document.getElementById("giorno_inizio").value = dayName;
        }
        
        function fillEndDay() {
          var data_fine = document.getElementById("data_fine").value;
          var dayName = findDay(data_fine);
          document.getElementById("giorno_fine").value = dayName;
        }
        
        function findDay(data_inizio) {
            var dayNames = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
          ];

          var d = new Date(data_inizio);
          var dayName = dayNames[d.getDay()];
          return dayName;
        }
        
        function add_text_to_mail() {
            var nome = document.getElementById('nome').value;
            var cognome = document.getElementById('cognome').value;
            var data_inizio = document.getElementById('data_inizio').value;
            var data_fine = document.getElementById('data_fine').value;
            var giorno_inizio = document.getElementById('giorno_inizio').value;
            var giorno_fine = document.getElementById('giorno_fine').value;
            
            if (data_inizio == "" || data_fine == "") {
                alert('fill in every field to add');
                return;
            }
            
            data_inizio = date_us_to_eu(data_inizio);
            data_fine = date_us_to_eu(data_fine);
            
            var pre_mail = 'Hi,\n\n'; 
            pre_mail += 'I am ' + nome + ' ' + cognome + ' and I would like going on vacation in the following days:\n\n';
            var vacation_dates = 'From ' + data_inizio + ' (' + giorno_inizio + ') to ' + data_fine + ' (' + giorno_fine + ').';   
            var post_mail = '\nYours sincerely, \n\n';
            post_mail += nome;
            
            var previous_dates = document.getElementById('hidden_mail_text').value;

            var content_mail = previous_dates + vacation_dates;
            content_mail = content_mail.split('.').join('\n');
            
            var content_mail_show = previous_dates + vacation_dates;
            content_mail_show = content_mail.split('\n').join('.\n');
            
            document.getElementById('hidden_mail_text').value = content_mail;
            document.getElementById('mail_text').value = pre_mail + content_mail_show + post_mail;
            
        }
        
        function date_us_to_eu(date_to_convert) {
            date_converted = date_to_convert.split('-');
            date_converted = date_converted[2] + '-' + date_converted[1] + '-' + date_converted[0]
            return date_converted;
        }
        
       
        
        </script>
        </form>
    </body>
</html>

<?php 

if ( !isset( $_SESSION['ID'] ) ) {
    logout();
}

include '../common/footer.php';
        
if ( isset( $_POST['send_mail'] ) ) {
    if (!empty($_POST['mail_text']) ) {
        $mail_text = $_POST['mail_text'];
        $hidden_mail_text = $_POST['hidden_mail_text'];
        preg_match_all(
            '/[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]/',
            $hidden_mail_text,
            $matches_dates,
            PREG_PATTERN_ORDER
        );
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $giorno_inizio = $_POST['giorno_inizio'];
        $giorno_fine = $_POST['giorno_fine'];
        $status = 0;
        $emp_id = $_SESSION['ID'];

        for ($i = 0; $i < count($matches_dates[0]); $i += 2) {
            $data_inizio = date_eu_to_us($matches_dates[0][$i]);
            $data_fine = date_eu_to_us($matches_dates[0][$i+1]);
            $durata = dateChecker($data_inizio, $data_fine);                    
            $db -> insertVacation($nome,$cognome,$data_inizio,$data_fine, $durata, $status, $emp_id);
        }
        sendMail($db, $mail_text, 'vacation request');
    } else {
        $message_alert = "Add the text of the email";
        echoAlert($message_alert, false);
    }
}
        
        ?>