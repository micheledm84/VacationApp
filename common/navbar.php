<?php
    include_once (dirname(__FILE__) . "/../functions/functions.php");
?>


<html>
        <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <title>Vacation App</title>
    </head>
    <body>
        <form id="send_post" name="send_post" method="post" >

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">                    
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
          <li>
              <a class="nav-link" href="../view/index.php"><p class="text-success" id="vacation_p">Vacation Area</p></a>
          </li>
          <li>
              <a class="nav-link " href="../view/day_of_leave.php"><p class="text-success" id="dayofleave_p">Day Of Leave Area</p></a>
          </li>
          <li>
              <a class="nav-link " href="../view/report.php"><p class="text-success" id="report_p">Report Area</p></a>
          </li>
          <?php
          if ($_SESSION['permission'] == 2) {
            printAdminNavbar();
          }
          ?>
      </ul>
        <button type="submit" id="logout_button" name="logout_button" class="btn btn-warning">Logout</button>
    </div>
  </div>
</nav>
<div id="container">
<?php 
          printName();
?>
