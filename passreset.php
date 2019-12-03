<?php
include "functions.php";

$resetValid = 0;
$email = "";
$user = "";
$resetLink = "";
$email = $_REQUEST['email'];
$resetLink = $_REQUEST['resetlink'];

// I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
// The reason I did this, is so that people cant have the same username with different caps.
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }
$sql = "SELECT * FROM passreset WHERE email = '$email' AND resetlink = '$resetLink' AND valid = '1'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result = $conn->query($sql);

// this looks to see if there are any resultsf from the sql.
if ($result->num_rows > 0) {
  $resetValid = 1;
}
else{
  $resetError = "This link is not valid, or has already been used!";
}

if ($email == "" && $resetLink == "")
{
  $resetError = "Please check your email for a link to reset your password!";

}


if (!empty($_POST['resetPass']))
{
  if ($resetValid == 1)
  {
  $maySign = 1;
  $pass = $_POST['password'];
  $repass = $_POST['repassword'];
  // I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
  // The reason I did this, is so that people cant have the same username with different caps.
  if ($pass == "" || $repass == "")
  {
    $resetError = "The passwords must not be blank!";
    $maySign = 0;
  }

  if ($pass != $repass)
  {
    $resetError = "The passwords did not match!";
    $maySign = 0;
  }



  $sql = "SELECT * FROM users WHERE email = '$email'";

  $result = $conn->query($sql);

  // this looks to see if there are any resultsf from the sql.
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $user = $row['username'];
    }
  }

  if ($maySign == 1) {

  $salt = "";

  $pepper = $user . "rR@gt5!ic6";

  // This is creating the salt, pretty much a range of letters and numbers 22 chars long.
  $saltOptions = array_merge(range('A','Z'), range('a', 'z'), range(0,9));
  for($i = 0; $i < 22; $i++)
  {
      $salt .= $saltOptions[array_rand($saltOptions)];
  }
  // adding the pepper to the end of the password.
  $pass .= $pepper;
  $pass = crypt($pass, sprintf('$2y$%02d$', 9) . $salt);


  $sql = "UPDATE passreset SET valid='0' WHERE email='$email'";

  $conn->query($sql);
  $sql = "UPDATE users SET password='$pass', salt='$salt' WHERE email='$email'";
  if ($conn->query($sql) === TRUE) {

    $conn->close();
    Redirect("login.php");
    }
  }
  $conn->close();
}
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
      <?php
      if ($resetValid == 1)
      {
       echo '
      <form action="passreset.php?email=' . $email . '&resetlink=' . $resetLink . '" enctype="multipart/form-data" method="post">
      <div class="cTitle">
      New Password
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
      <div class="inputLeft">
        Retype Password:
      </div>
      <div class="inputRight">
        <input name="repassword" type="password" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenter">
        <input class="formButton" type="submit" value="Reset" name="resetPass" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenterError">
        ' . $resetError . '
      </div>
    </div>
  </form>';
}
else{
  echo $resetError;
}
  ?>
    </div>
  </div>
</body>
