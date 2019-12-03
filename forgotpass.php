<?php
include "functions.php";


if (!empty($_POST['resetPass']))
{
  $maySign = 0;
  $emailError = "";
  $email = $_POST['email'];

  // I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
  // The reason I did this, is so that people cant have the same username with different caps.
  $conn = new mysqli($servername, $username, $password, $dbname);


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

  $sql = "SELECT * FROM users WHERE email = '$email'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  // this looks to see if there are any resultsf from the sql.
  if ($result->num_rows > 0) {
    $maySign = 1;
  }
  else{
    $emailError = "Sorry, email not registered!";
  }

  if ($maySign == 1) {
    // refrenced: https://www.pontikis.net/tip/?id=18 for date('Y-m-d H:i:s')
    $currentDT = date('Y-m-d H:i:s');

  $resetLink = "";
  // This is creating the salt, pretty much a range of letters and numbers 22 chars long.
  $resetOptions = array_merge(range('A','Z'), range('a', 'z'), range(0,9));
  for($i = 0; $i < 22; $i++)
  {
      $resetLink .= $resetOptions[array_rand($resetOptions)];
  }
  $sql = "UPDATE passreset SET valid=0 WHERE email='$email'";

  $conn->query($sql);

    $sql = "INSERT INTO passreset (email, resetlink, date, valid) VALUES ('$email','$resetLink','$currentDT', 1)";
    if ($conn->query($sql) === TRUE) {
// Note: the email below requires computers to have an email service of somesort.
// it will work online, but not locally.
$email_subject = "Djangofantasy Password Reset";
$email_message = "Hello! \r\n \r\n
We have recieved a request to reset your Djangosfantasy password!\r\n
If you did not request a reset, then ignore this email and your password will remain the same.\r\n
Please Click the link below to reset your password!\r\n

<a href='www.djangosfantasy.com/passreset.php?email=" . $email . "&resetlink=" . $resetLink . "'>Reset Password</a>\r\n

If the link does not work, you can also copy the following link to put in your browsers URL.\r\n \r\n

www.djangosfantasy/passreset.php?email=" . $email . "&resetlink=" . $resetLink . "\r\n \r\n

Have a good day!\n
~Djangosfantasy Developement Team";

$email_message = wordwrap($email_message, 70, "\r\n");

$headers = 'Content-type: text/html; charset=utf-8' . "\r\n" .

'From: contact@djangosfantasy.com\r\n'.

'Reply-To: contact@djangosfantasy.com\r\n' .

'X-Mailer: PHP/' . phpversion();

@mail($email, $email_subject, $email_message, $headers);


      Redirect("passreset.php");
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
      Forgot Password
    </div>
    <div class="inputWrap">
      <div class="inputLeft">
        Email:
      </div>
      <div class="inputRight">
        <input type="text" name = "email" value="<?php echo $email; ?>"/>
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenter">
        <input class="formButton" type="submit" value="Reset" name="resetPass" />
      </div>
    </div>
    <div class="inputWrap">
      <div class="inputCenterError">
        <?php echo $emailError; ?>
      </div>
    </div>
  </form>
    </div>
  </div>
</body>
