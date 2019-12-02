<?php
session_start();
include "functions.php";



$leagueN = "";
$invite = "";

$leagueN = $_REQUEST["leagueN"]; //pulls the get variable
$invite = $_REQUEST["invite"]; //pulls the get variable

$uname = "";
$inviteErr = "";

if (!isset($_SESSION['userSess']))
{
  Redirect("login.php?linkPass=invite&leagueN=" . $leagueN . "&invite=" . $invite);
}
else {
  $uname = $_SESSION['userSess'];
}

// #############################
// #### Invite varification ####
// #############################
$canRegister = 0;
$captin = "";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }
  $sql = "SELECT * FROM leagues WHERE league = '$leagueN'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $captin = $row['leader'];
    }
  }


  $sql = "SELECT * FROM invite WHERE link = '$invite' AND league = '$leagueN' AND valid = '1'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $canRegister = 1;
  }
  else {
    $inviteErr = "Error: Invalid invite or invite already used!";
  }


  $sql = "SELECT * FROM invite WHERE league = '$leagueN' AND username = '$uname'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $canRegister = 0;
    $inviteErr = "Error: You already belong to this league!";

  }

  if ($canRegister == 1)
  {
    $sql = "UPDATE invite SET username='$uname', valid='0' WHERE link = '$invite' AND league = '$leagueN'";
    $conn->query($sql);


    $currentDT = date('Y-m-d H:i:s');

    $sql = "INSERT INTO leagues (league, username, leader, dateCreate, valid)
    VALUES ('$leagueN', '$uname', '$captin', '$currentDT', 1)";

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
        <?php echo $inviteErr; ?>
    </b>
    </div>
  </div>
</body>
</html>
