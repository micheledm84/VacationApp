<?php
    include_once (dirname(__FILE__) . "/../functions/functions.php");
?>
<html>
    <head>
        <title>Vacation App</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="jumbotron">
            <center><h3>Welcome to Vacation App! :D</h3></center>
        </div>
        <div class="container" >
            <div class="row">
                
                <div class="col-md-2 col-md-offset-5 panel panel-default">
                    <form method="post" action="" class="text-center" >
                        <div class="form-group">
                          <label for="utentePwd">User</label>
                          <input type="text" class="form-control" maxlength="20" id="utentePwd" name="utente_input" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                          <label for="passwordUt">Password</label>
                          <input type="password" class="form-control" maxlength="20" name="pwd_input" id="passwordUt">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
            
        
        
    </body>
</html>

<?php

        
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!empty($_POST['utente_input']) && !empty($_POST['pwd_input'])) {
                    $utente_input = $_POST['utente_input'];
                    $pwd_input = $_POST['pwd_input'];
                    if (credentialsChecker($db, $utente_input, $pwd_input)) {
                        buildSession($db, credentialsChecker($db, $utente_input, $pwd_input));
                        header("Location: index.php");
                    } else {
                        $messageLoginFailed = "Le credenziali inserite non sono corrette";
                        echo "<script type='text/javascript'>alert('$messageLoginFailed')</script>;";
                    }
                } else {
                    $messageLogin = "Per favore... compila tutti i campi";
                    echo "<script type='text/javascript'>alert('$messageLogin')</script>;";
                }
            }
            
        ?>

