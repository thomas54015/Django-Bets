<?php
session_start();

include "functions.php";

// Variable to store the username
$user = "";
// variable for password
$pass = "";

$linkPass="";
$linkPass = $_REQUEST['linkPass'];
$leagueN = $_REQUEST['leagueN'];
$invite = $_REQUEST['invite'];

//echo "The link pass: " . $linkPass . " leagueN: " . $leagueN . " invite: " . $invite;
if (!empty($_POST['login']))
{
  $mayPass = 0;
  $loginError = "";
  $user = $_POST['username'];
  $pass = $_POST['password'];
  // I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
  // The reason I did this, is so that people cant have the same username with different caps.
  $user = strtolower($user);
  // refrenced: https://www.w3schools.com/php/php_mysql_select.asp
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

  $sql = "SELECT * FROM users WHERE username = '$user'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $realPass = $row['password'];
      $salt = $row['salt'];


      // I explained most of how this works on the signup, I think the important
      // part here is to know that we arn't really comparing passwords. We are
      // comparing the hashed version of passwords. The inputed password is
      // hashed to be compared to the hashed password in the database.
      $pepper = $user . "rR@gt5!ic6";

      // adding the pepper to the end of the password.
      $hashpass = $pass . $pepper;
      $hashpass = crypt($hashpass, sprintf('$2y$%02d$', 9) . $salt);
      //echo $hashpass . " " . $salt;

      if ($hashpass == $realPass)
      {
        $mayPass = 1;
      }
    }
  }
  if ($mayPass == 1) {
    // refrenced: https://www.pontikis.net/tip/?id=18 for date('Y-m-d H:i:s')
    $currentDT = date('Y-m-d H:i:s');
    // refrenced: https://www.w3schools.com/php/php_mysql_update.asp
    $sql = "UPDATE users SET lastlog='$currentDT' WHERE username='$user'";

    if ($conn->query($sql) === TRUE) {
      $_SESSION['userSess'] = $user;

      if ($linkPass == "invite")
      {
        Redirect("invite.php?leagueN=" . $leagueN . "&invite=" . $invite);
      }
      else {
        Redirect("home.php");
      }
    }
  }
  else {
    $loginError = "Invalid username or Password";
  }
  // I forgot to origninally close the database
  $conn->close();
}
if (!empty($_SESSION['userSess']))
{
  Redirect("home.php");
}
?>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="./css/login.css">
  <link rel="icon" href="./pics/danjosfantasy.jpg">
</head>
<body>
  <div class="banner">
    <img class="page-logo" src="./pics/logo.png" alt="logo">
  </div>
  <div class="navWrap">
    <?php
    if (!empty($_SESSION['userSess']))
    {
    echo '
    <div class="navButtonL">
      <a href="home.php">Home</a>
    </div>

    <div class="navButtonR">
      <a href="logout.php">Logout</a>
    </div>
    <div class="navButtonR">
      <a href="#">' . $_SESSION['userSess'] . '</a>
    </div>';
  }
  else {
    echo '
    <div class="navButtonL">
      <a href="index.html">Home</a>
    </div>

    <div class="navButtonR">
      <a href="login.php">Login</a>
    </div>
    <div class="navButtonR">
      <a href="signup.php">Sign up</a>
    </div>';
  }
  ?>
  </div>
  <div class="main">
    <div class="loginWrap">
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" method="post">
      <div class="cTitle">
      Login to Django
    </div>
    <div class="inputWrap">
      <div class="inputLeft">
        Username:
      </div>
      <div class="inputRight">
        <input type="text" name = "username" value="<?php echo $user; ?>"/>
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputLeft">
        Password:
      </div>
      <div class="inputRight">
        <input name="password" type="password" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenter">
        <input class="formButton" type="submit" value="Login" name="login" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenterError">
        <?php echo $loginError; ?>
      </div>
    </div>
  </form>
    </div>
  </div>
</body>
