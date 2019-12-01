<?php
session_start();
include "functions.php";

$uname = "";
if (!isset($_SESSION['userSess']))
{
  Redirect("login.php");
}
else {
  $uname = $_SESSION['userSess'];
}

$leagueP = "";

$leagueP = $_REQUEST["leagueP"]; //pulls the get variable

function leaguesData($servername, $username, $password, $dbname, $uname, $leagueP)
{

  //#####################################################
  //#####################################################
  //######### DO NOT FORGET TO CHANGE LINKPASS  #########
  //######### IN HOME.PHP BEFORE UPLOADING SITE #########
  //#####################################################
  //#####################################################

$urlMain = "localhost/Django-Bets/";
//$urlMain = "www.djangosfantasy.com/";

$leagueAccess = 0;
$leagueCaptin = "";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }

$sql = "SELECT * FROM leagues WHERE username = '$uname' AND league = '$leagueP'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row

  while($row = $result->fetch_assoc()) {
    $leagueCaptin = $row['leader'];

    if ($uname == $leagueCaptin)
    {
      $leagueAccess = 2;
    }
    else
    {
      $leagueAccess = 1;
    }
  }
}

// If just a regular user, then we only want to show them other team users and points.
/*
<div class="leagueBox"><br>
  Leaguename<br><br>

  Team - TeamPoints<br><br>

  player1 - points<br>
  player2 - points<br>
  player3 - points<br>
  player4 - points<br>
  player5 - points<br>
  player6 - points<br>
  player7 - points<br>
  player8 - points<br>
  player9 - points<br>
  player10 - points<br>
  player11 - points<br>
</div>
*/
if ($leagueAccess == 1)
{
  echo $leagueP . '<br>';
  echo "Points: 0<br><br>";

  echo "League Captin: " . $leagueCaptin . "<br>";
  echo "Players:<br>";
  echo "1. " . $leagueCaptin . "<br>";

  $sql = "SELECT * FROM invite WHERE league = '$leagueP' AND valid = '0'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 2;
  if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
      echo $nameCount . ". " . $row['username'] . "<br>";

      $nameCount++;

    }
  }
  echo "<br>3 Winning Teams: <br>
  1. Team 1<br>
  2. Team 2<br>
  3. Team 3<br>
  <br>
  Losing Team:<br>
  1. Team 1<br>
  <br>
  ";
}
else if ($leagueAccess == 2)
{
  echo $leagueP . '<br>';
  echo "Points: 0<br><br>";

  echo "League Captin: " . $leagueCaptin . "<br>";
  echo "* Send links to invite players *<br>";
  echo "Players:<br>";
  echo "1. " . $leagueCaptin . "<br>";

  $sql = "SELECT * FROM invite WHERE league = '$leagueP' AND valid = '0'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 2;
  if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
      echo $nameCount . ". " . $row['username'] . "<br>";

      $nameCount++;

    }
  }

  $sql = "SELECT * FROM invite WHERE league = '$leagueP' AND valid = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
      echo $nameCount . ". " . $urlMain . "invite.php?leagueN=" . $leagueP . "&invite=" . $row['link'] . "<br>";
      $nameCount++;

    }
  }
  echo "<br>3 Winning Teams: <br>
  1. Team 1<br>
  2. Team 2<br>
  3. Team 3<br>
  <br>
  Losing Team:<br>
  1. Team 1<br>
  <br>
  ";
}
else
{
  echo "Invalid league or no league selected.<br>
  You can select or create a league in left tool bar.";
}


}


if (!empty($_POST['newLeagueB']))
{
  $mayCreate = 1;
  $leagueError = "";
  $leagueN = $_POST['newLeagueT'];

  if ($leagueN == "")
  {
    $leagueError = "The League name must not be blank!";
    $mayCreate = 0;
  }

  // I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
  // The reason I did this, is so that people cant have the same username with different caps.
  $leagueN = strtolower($leagueN);
  $conn = new mysqli($servername, $username, $password, $dbname);


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

  $sql = "SELECT * FROM leagues WHERE league = '$leagueN'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  // this looks to see if there are any resultsf from the sql.
  if ($result->num_rows > 0) {
    $leagueError = "Sorry, League name is already taken!";
    $mayCreate = 0;
  }

  if ($mayCreate == 1) {
    // refrenced: https://www.pontikis.net/tip/?id=18 for date('Y-m-d H:i:s')
    $currentDT = date('Y-m-d H:i:s');
    // refrenced: https://www.w3schools.com/php/php_mysql_insert.asp
    $sql = "INSERT INTO leagues (league, username, leader, dateCreate)
    VALUES ('$leagueN', '$uname', '$uname', '$currentDT')";

    $conn->query($sql);

    $numsTest = "";
    for($i = 0; $i < 4; $i++) {
      $numsTest .= $i;

      //Verification code
      $verifyCode = "";
      $verifyChars = array_merge(range('a', 'z'), range(0,9));
      for($j = 0; $j < 8; $j++) {
              $verifyCode .= $verifyChars[array_rand($verifyChars)];
      }

      $sql = "INSERT INTO invite (link, league, username, valid)
      VALUES ('$verifyCode', '$leagueN', '$uname', 1)";

      $conn->query($sql);
    }
  //  echo "Loop check: " . $numsTest;
  }
  $conn->close();
}

function leaguesName($servername, $username, $password, $dbname, $uname)
{
  $conn = new mysqli($servername, $username, $password, $dbname);


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

    $sql = "SELECT * FROM leagues WHERE username = '$uname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $leagueN = $row['league'];
        echo '<a href="home.php?leagueP=' . $leagueN . '">' . $leagueN . '</a> 0 <br>';
      }
    }
}
 ?>
<!doctype html>

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
            <div class="panel-left">
                <a href="profile.html" class="profile">
                    <img class="profile-picture" alt="profile picture" src="pics/defaultprofile.png">
                </a>
                <div>
                    <?php
                    echo $_SESSION['userSess'];
                    ?>
                </div>
                <br>
                <?php
                    if (array_key_exists('updatebutton', $_POST)) {
                      updatebutton();
                    }
                    function updatebutton() { 
                      $command = escapeshellcmd('./api/mypython/python ./api/apitest.py');
                      $output = shell_exec($command);
                      echo $output;
                      
                    }
                    echo "DEV: this will run python script 100/day"
                    ?>
                    <form method="post"> 
                      <input type="submit" name="updatebutton"
                        class="button" value="Update Teams" /> 
                <br>
                <ul class="leagueList">
                    <?php
                    leaguesName($servername, $username, $password, $dbname, $uname);
                     ?>
                </ul>
                <div class="newLeague">
                  <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" method="post">
                    <div class="newLeagueL">
                      Name:
                    </div>
                    <input type="text" class="newLeagueT" name="newLeagueT" />
                    <input type="submit" class="newLeagueB" name="newLeagueB" value="➕ Create League" />
                  </form>
                  <div class="newLeagueErr">
                    <?php
                    echo $leagueError;
                     ?>
                  </div>
                </div>
                <br><br>
                <a class="twitter-timeline" data-height="500" data-theme="dark" href="https://twitter.com/premierleague?ref_src=twsrc%5Etfw">Tweets by premierleague</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              </div>
            <div class="panel-center">
                <div style="justify-content: center;">
                  <button class="tablink" onclick="openPage('Team', this, 'grey')">My Team</button>
                  <button class="tablink" onclick="openPage('Standings', this, 'grey')" id="defaultOpen">Standings</button>
                </div>

                <div id="Team" class="tabcontent">
                  <div class="leagueBox">
                    <?php
                    leaguesData($servername, $username, $password, $dbname, $uname, $leagueP);
                    ?>

                  </div>
                </div>
                <div id="Standings" class="tabcontent" style="margin:10px;margin-top:70px;">
                  <!-- This widget is from https://www.sofascore.com/tournament/football/england/premier-league/17 -->
                  <iframe id="sofa-standings-embed-1-23776" width="100%" height="726px" style="height:726px!important" src="https://www.sofascore.com/tournament/1/23776/standings/tables/embed" frameborder="0" scrolling="no"></iframe><script type="text/javascript" src="https://www.sofascore.com/bundles/sofascoreweb/js/bin/util/embed.min.js"></script><script type="text/javascript">sofa_embed('sofa-standings-embed-1-23776', window);</script>
                </div>
                <script>
                  //script and code for buttons found at https://www.w3schools.com/howto/howto_js_full_page_tabs.asp
                  function openPage(pageName,elmnt,color) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                      tabcontent[i].style.display = "none";
                    }
                    document.getElementById(pageName).style.display = "block";
                  }

                  // Get the element with id="defaultOpen" and click on it
                  document.getElementById("defaultOpen").click();
                </script>
            </div>
            <div class="panel-right">
              <div>
                <iframe src='https://minnit.chat/Django?embed&&nickname=' style='border:none;width:90%;height:750px;margin:15px;' allowTransparency='true'></iframe>
              </div>
            </div>
        </div>
    </body>
</html>
