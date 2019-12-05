<?php
session_start();
include "functions.php";
//$dataAccess = 0;

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

$errCode = "";

$errCode = $_REQUEST["errCode"]; //pulls the get variable

$mainErr = "";


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
  $mainErr = '<div class="errrs"><b>Error: You do not seem to belong to this league, or you were deleted by the captin!</b></div>';

}

if ($errCode == 1)
{
  $mainErr = '<div class="errrs"><b>Error: You do not seem to belong to this league, or you were deleted by the captin!</b></div>';

}
else if ($errCode == 2)
{
  $mainErr = '<div class="errrs"><b>Error: It is not your turn. Please come back, or refresh page!</b></div>';

}
else if ($errCode == 3)
{
  $mainErr = '<div class="errrs"><b>Error: That team has already been picked!</b></div>';

}
else if ($errCode == 4)
{
  $mainErr = '<div class="errrs"><b>Error: Drafts are over!</b></div>';

}

function leaguesUsers($servername, $username, $password, $dbname, $uname, $leagueP)
{
  $dataAccess = 0;
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
        $dataAccess = 1;
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
  $draftCount = ($draftCount % $totalUsers);

  if ($dataAccess == 1)
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
          echo '<div style="color: #00ff00"><h2>' . $row['username'] . '</h2></div><br>';
        }
        else
        {
          echo '<h2>' . $row['username'] . '</h2><br>';
        }

        $userCount++;
      }
    }
  }
}

function leaguesTeams($servername, $username, $password, $dbname, $uname, $leagueP)
{
  $dataAccess = 0;


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
      $dataAccess = 1;
  }

  if ($dataAccess == 1)
  {
    $sql = "SELECT * FROM teamsAlt";
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
            if ($row['teamName'] == $row2['team'])
            {

              $teamTaken = 1;
            }
          }

        }

        if ($teamTaken == 1)
        {
          echo '
          <a href="#" class="buttonTwo">
            <img src="pics/teamIcons/' . $row['picLink'] . '" alt="' . $row['teamName'] . '">
          </a>';
        }
        else{
          echo '
          <a href="pick.php?leagueP=' . $leagueP . '&pick=' . $row['teamName'] . '" class="button">
            <img src="pics/teamIcons/' . $row['picLink'] . '" alt="' . $row['teamName'] . '">
          </a>';
        }
      }
    }
  }


}

// ## just for counting rounds.
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
$draftMessage = "";
$roundP = intdiv($draftCount, $totalUsers);
if ($roundP == 0)
{
  $draftMessage = '<div class="dM"><b>Round 1: On your turn, select who you think will lose.</b></div>';
}
else if ($roundP <= 3)
{
  $draftMessage = '<div class="dM"><b>Round ' . ($roundP + 1) . ': On your turn, select who you think will win.</b></div>';
}
else {
  $draftMessage = '<div class="dM"><b>Daft is over, good luck!</b></div>';

}


 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="./css/home.css"/>
      <link rel="stylesheet" href="./css/league.css"/>
      <link rel="icon" href="./pics/danjosfantasy.jpg"/>
      <title>Django Bets</title>
  </head>

  <body>
    <header>
  	  <div class="banner">
          <img class="page-logo" src="./pics/logo.png" alt="logo">
  	  </div>
  	</header>

    <div class="nav">
      <a class="navButtonL" href="home.php">Home</a>
      <a class="navButtonL" href="teamInfo.php">Info</a>
      <a class="navButtonR" href="logout.php">Log Out</a>
    </div>
    <?php
    echo $draftMessage;
    echo $mainErr;
     ?>
    <div class="left">
      <div class="group">
        <?php
          leaguesUsers($servername, $username, $password, $dbname, $uname, $leagueP);
         ?>
      </div>
    </div>

    <div class="center">
      <div class="grid">

        <?php
        leaguesTeams($servername, $username, $password, $dbname, $uname, $leagueP);
        ?>

      </div>
    </div>



  </body>
</html>
