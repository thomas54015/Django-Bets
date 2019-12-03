<?php
session_start();
include "functions.php";

$userPick = "";
$teamTook = 0;
$roundP = 0;
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

$pick = "";

$pick = $_REQUEST["pick"]; //pulls the get variable

$errCode = "";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }
$sql = "SELECT * FROM leagues WHERE league = '$leagueP' AND username = '$uname' AND valid = '1'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
} else {
  $errCode = 1;
  Redirect("draft.php?leagueP=" . $leagueP . "&errCode=" . $errCode);

}

// ############################################
// ### This is all for selecting right user ###
// ############################################

$dataAccessU = 0;
$draftCount = 0;
$totalUsers = 0;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }
$sql = "SELECT * FROM leagues WHERE league = '$leagueP' AND valid = '1'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    if ($uname == $row['username'])
    {
      $dataAccessU = 1;
    }
    $totalUsers++;
  }
}
$sql2 = "SELECT * FROM draft WHERE league = '$leagueP'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
  // output data of each row

  while($row2 = $result2->fetch_assoc()) {
    $draftCount++;
  }
}
$roundP = intdiv($draftCount, $totalUsers);

$draftCount = ($draftCount % $totalUsers);

if ($dataAccessU == 1)
{
  $sql = "SELECT * FROM leagues WHERE league = '$leagueP' AND valid = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $userCount = 0;
    while($row = $result->fetch_assoc()) {
      if ($userCount == $draftCount)
      {
        $userPick = $row['username'];
      }


      $userCount++;
    }
  }
}

if ($userPick != $uname)
{
  $errCode = 2;
  $conn->close();
  Redirect("draft.php?leagueP=" . $leagueP . "&errCode=" . $errCode);
}
// ############################################
// ### This is End for selecting right user ###
// ############################################
// ##################################
// ### This is for verifying team ###
// ##################################

$dataAccessT = 0;


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }
$sql = "SELECT * FROM leagues WHERE league = '$leagueP' AND username = '$uname' AND valid = '1'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
    $dataAccessT = 1;
}

if ($dataAccessT == 1)
{
  $sql = "SELECT * FROM teams";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $teamTaken = 0;
      $sql2 = "SELECT * FROM draft WHERE league = '$leagueP'";
      $result2 = $conn->query($sql2);
      if ($result2->num_rows > 0) {
        // output data of each row
        while($row2 = $result2->fetch_assoc()) {
          if ($pick == $row2['team'])
          {

            $teamTaken = 1;
          }
        }

      }

      if ($teamTaken == 1)
      {
        $teamTook = 1;
      }

    }
  }
}

if($teamTook == 1)
{
  $errCode = 3;
  $conn->close();
  Redirect("draft.php?leagueP=" . $leagueP . "&errCode=" . $errCode);
}

// ######################################
// ### This is END for verifying team ###
// ######################################
if ($teamTook == 0 && $userPick == $uname)
{
  if ($roundP == 0)
  {
    $sql = "INSERT INTO `draft`(`username`, `league`, `team`, `winlose`) VALUES ('$uname','$leagueP','$pick',0)";
  }
  else if ($roundP <= 4)
  {
    $sql = "INSERT INTO `draft`(`username`, `league`, `team`, `winlose`) VALUES ('$uname','$leagueP','$pick',1)";
  }
  else {
    $errCode = 4;
    $conn->close();
    Redirect("draft.php?leagueP=" . $leagueP . "&errCode=" . $errCode);
  }

  $conn->query($sql);

}

$conn->close();
Redirect("draft.php?leagueP=" . $leagueP);
?>
