<?php
include "functions.php";

// Variable to store the username
$user = "";
// variable for password
$pass = "";

if (!empty($_POST['login']))
{
  $mayPass = 0;
  $loginError = "";
  $user = $_POST['username'];
  $pass = $_POST['password'];
  // www.w3schools.com way of connecting to database.
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

  $sql = "SELECT password FROM users WHERE username = '$user'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $realPass = $row['password'];
      if ($pass == $realPass)
      {
        $mayPass = 1;
      }
    }
  }
  if ($mayPass == 1) {
    $_SESSION['userSess'] = $user;
  }
  else {
    $loginError = "Invalid username or Password";
  }
}
if (!empty($_SESSION['userSess']))
{
  Redirect("home.html");
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
      <a href="home.html">Home</a>
    </div>
    <div class="navButtonL">
      <a href="#">League</a>
    </div>
    <div class="navButtonL">
      <a href="#">Players</a>
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
    <div class="navButtonL">
      <a href="#">Players</a>
    </div>
    <div class="navButtonR">
      <a href="#">Login</a>
    </div>
    <div class="navButtonR">
      <a href="#">Sign up</a>
    </div>';
  }
  ?>
  </div>
  <div class="main">
    <div class="loginWrap">
      <form action="<?php htmlspecialchars($_SERVER[' PHP_SELF ']); ?>" enctype="multipart/form-data" method="post">
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
