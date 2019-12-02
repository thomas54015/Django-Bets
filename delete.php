<?php
session_start();
include "functions.php";



$leagueN = "";
$delUser = "";

$leagueN = $_REQUEST["leagueN"]; //pulls the get variable
$delUser = $_REQUEST["delUser"]; //pulls the get variable

$uname = "";
$deleteErr = "";
$canDelete = 0;

if (!isset($_SESSION['userSess']))
{
  Redirect("login.php");
}
else {
  $uname = $_SESSION['userSess'];
}



$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
}


$sql = "SELECT * FROM leagues WHERE league = '$leagueN' AND username = '$delUser' AND leader = '$uname'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
  $canDelete = 1;
}
else {
  $deleteErr = "Error: You do not have permission to delete this user!";
}



if ($canDelete == 1)
{
  $sql = "UPDATE leagues SET valid='0' WHERE league = '$leagueN' AND username = '$delUser'";
  $conn->query($sql);

  Redirect("home.php");

}


?>

<html>
<head>
  <title>Delete</title>
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
        <?php echo $deleteErr; ?>
    </b>
    </div>
  </div>
</body>
</html>
