<?php
session_start();
include "functions.php";



$tradeId = "";

$tradeId = $_REQUEST["id"]; //pulls the get variable

$uname = "";
$otherUser = "";
$myteam = "";
$offeredTeam = "";
$tradeErr = "";
$leagueP = "";

if (!isset($_SESSION['userSess']))
{
  Redirect("login.php");
}
else {
  $uname = $_SESSION['userSess'];
}

// #############################
// #### Trade varification ####
// #############################
$canTrade = 0;


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }

  //echo "test: " . $uname;

  $sql = "SELECT * FROM trades WHERE id = '$tradeId' AND offerUser = '$uname' AND accept = '0'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $canTrade = 1;
    while($row = $result->fetch_assoc()) {
      $otherUser = $row['username'];
      $myteam = $row['yourteam'];
      $offeredTeam = $row['myteam'];
      $leagueP = $row['league'];
    }
  }
  else {
    $tradeErr = "Error: Invalid Trade Offer!";
  }



  if ($canTrade == 1)
  {
    $sql = "UPDATE draft SET username='$otherUser' WHERE league = '$leagueP' AND team = '$myteam'";
    $conn->query($sql);

    $sql = "UPDATE draft SET username='$uname' WHERE league = '$leagueP' AND team = '$offeredTeam'";
    $conn->query($sql);

    $sql = "UPDATE trades SET accept='1' WHERE id = '$tradeId'";
    $conn->query($sql);

    Redirect("home.php");


  }
  //Redirect("index.html");


?>

<html>
<head>
  <title>Invite</title>
  <link rel="stylesheet" href="./css/login.css">
  <link rel="icon" href="./pics/danjosfantasy.jpg">
</head>
<body>
  <div class="banner">
    <img class="page-logo" src="./pics/logo.png" alt="logo">
  </div>
  <div class="navWrap">

    <div class="navButtonL">
      <a href="home.php">Home</a>
    </div>

    <div class="navButtonR">
      <a href="logout.php">Logout</a>
    </div>
    <div class="navButtonR">
      <a href="#">test2</a>
    </div>  </div>
  <div class="main">
    <div class="loginWrap" style="color: #ff0000;">
      <b>
        <?php echo $tradeErr; ?>
    </b>
    </div>
  </div>
</body>
</html>
