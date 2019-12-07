<!doctype html>
<?php
include "functions.php";
?>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="./css/home.css">

        <title>Django Bets</title>
        <link rel="icon" href="./pics/danjosfantasy.jpg">
    </head>

    <body>
        <div class="banner">
            <img class="page-logo" src="./pics/logo.png" alt="logo">
          </div>
          <div class="navWrap">

            <?php
            echo '
            <div class="navButtonL">
              <a href="home.php">Home</a>
            </div>

            <div class="navButtonR">
              <a href="logout.php">Logout</a>
            </div>
            <div class="navButtonR">
              <a href="#">' . $_SESSION['userSess'] . '</a>
            </div>

            ';
             ?>
          </div>

        <div class="wrapper">
            <div class="panel">
                <a href="profile.php" class="profile">
                    <img class="profile-picture" alt="profile picture" src="pics/defaultprofile.png">
                </a>
                <div>
                <?php
                  echo $_SESSION['userSess'];
                  echo '<span style="font-family:Times New Roman;font-size:25px;">'."<br><br>Welcome, " . $_SESSION['userSess'];
                  echo "<br>You are currently in the following leagues:<br><br></span>";
                  $conn = new mysqli($servername, $username, $password, $dbname);
                  // Check connection
                  if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                      //error message if database connection fails.
                    }

                  $sql = 'SELECT * FROM leagues WHERE username = "'.$_SESSION['userSess'].'"';
                  /*This is the first mySQL. This selects data from the
                  table users where the username colum is equal to the username input */

                  $result = $conn->query($sql);
                  $uname = $_SESSION['userSess'];
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      $leagueP = $row['league'];
                      $sql = "SELECT * FROM points WHERE player='$uname' AND league='$leagueP'";
                      $resultx = $conn->query($sql);
                      if ($resultx->num_rows > 0) {
                        while($rowx = $resultx->fetch_assoc()) {
                          $points = $rowx['points'];
                        }
                      }
                      else {
                        $points = 0;
                      }
                      echo '<span style="font-family:Courier New;font-size:25px;"> ' . str_pad($row['league']." ", 20, "=") . " Points: $points" . "<br></span>";
                  }
                  }
                ?>
                <br>
                      
                    
                     
                
            </div>
            <div class="panel-right">
            </div>
        </div>
    </body>
</html>
