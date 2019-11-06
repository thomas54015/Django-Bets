<?php
session_start();
include "functions.php";



$leagueN = "";
$invite = "";

$leagueN = $_REQUEST["leagueN"]; //pulls the get variable
$invite = $_REQUEST["invite"]; //pulls the get variable

$uname = "";
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
    echo "Error: Invalid invite or invite already used!";
  }


  $sql = "SELECT * FROM invite WHERE league = '$leagueN' AND username = '$uname'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $canRegister = 0;
    echo "Error: You already belong to this league!";

  }

  if ($canRegister == 1)
  {
    $sql = "UPDATE invite SET username='$uname', valid='0' WHERE link = '$invite' AND league = '$leagueN'";
    $conn->query($sql);


    $currentDT = date('Y-m-d H:i:s');

    $sql = "INSERT INTO leagues (league, username, leader, dateCreate)
    VALUES ('$leagueN', '$uname', '$captin', '$currentDT')";

    $conn->query($sql);
    Redirect("home.php");


  }
  //Redirect("index.html");


?>
