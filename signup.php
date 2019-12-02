<?php
include "functions.php";

// Variable to store the username
$user = "";
// variable for password
$pass = "";

if (!empty($_POST['signup']))
{
  $maySign = 1;
  $signupError = "";
  $user = $_POST['username'];
  $pass = $_POST['password'];
  $repass = $_POST['repassword'];
  // I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
  // The reason I did this, is so that people cant have the same username with different caps.
  $user = strtolower($user);
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($pass == "" || $repass == "")
  {
    $signupError = "The passwords must not be blank!";
    $maySign = 0;
  }

  if ($pass != $repass)
  {
    $signupError = "The passwords did not match!";
    $maySign = 0;
  }

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

  $sql = "SELECT * FROM users WHERE username = '$user'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  // this looks to see if there are any resultsf from the sql.
  if ($result->num_rows > 0) {
    $signupError = "Sorry, username is already taken!";
    $maySign = 0;
  }

  if ($maySign == 1) {
    // refrenced: https://www.pontikis.net/tip/?id=18 for date('Y-m-d H:i:s')
    $currentDT = date('Y-m-d H:i:s');


  $salt = "";
  // The pepper is so that if somone manages to get the database, then
  // they still may have a hard time cracking common hashes. the pepper
  // gets added to the password (in our case the end), to make it less common
  // of a password for hashes. It would slow the attacker down to not have both
  // the salt and pepper. which would mean he would need access to the code,
  // and get into the database.
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

    // refrenced: https://www.w3schools.com/php/php_mysql_insert.asp
    $sql = "INSERT INTO users (username, password, salt, type, signupdate, lastlog)
    VALUES ('$user', '$pass', '$salt', 1, '$currentDT', '$currentDT')";

    if ($conn->query($sql) === TRUE) {
      $_SESSION['userSess'] = $user;
    }
  }
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
      Signup For Django
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
      <div class="inputLeft">
        Retype Password:
      </div>
      <div class="inputRight">
        <input name="repassword" type="password" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenter">
        <input class="formButton" type="submit" value="Sign Up" name="signup" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenterError">
        <?php echo $signupError; ?>
      </div>
    </div>
  </form>
    </div>
  </div>
</body>
