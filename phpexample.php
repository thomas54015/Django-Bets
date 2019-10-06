<?php
// all php must start with this, <?php

/* When using sessions (Used to store data, for us being logged in)
   you must put 'session_start();' at the top of the php file*/
session_start();

/* Include, includes other php files in the current file,
   I will use this to type the database access so that we only
   have to type it once. */
include 'functionsEx.php';


// test.com/play.php?seasonP=2&episodeP=5
// ###### Useful tip for php #######
/* I will be using the link above this as the example for the next
   2 lines of code. These are how you can pass data thru a url,
   its not really secure, but there are good uses for this. In this
   code I was using it to pick the episodes and links from the
   index page. $_REQUEST["seasonP"] would return 2 from the example
   above and store it in the variable $seasonP. Does the same for
   episodeP. */
$seasonP = $_REQUEST["seasonP"];
$episodeP = $_REQUEST["episodeP"];

/* !isset($_SESSION['']) is something I use a lot with php. When logging in
   we will set a session of username to store the username.
   !isset($_SESSION['uname']) checks to see if there is a session labeled as uname.
   essentially I'm using it here to see if the user is logged in.
*/
if (!isset($_SESSION['uname']) && ($sNum !== $seasonP))
{
  // The redirect function forwards users to index if not logged in, or don't have
  // access to the originals. This function is stored in functionsEx.php. and I copied
  // from somewhere else, I think maybe w3schools.com (will find source later).
  Redirect('index.php', false);
}
if (($sStart > $seasonP) && $type == 'n')
{
  Redirect('index.php', false);
}

function playlink($servername, $username, $password, $dbname, $sStart, $sNum, $seasonP, $episodeP) {
if (($sStart > $seasonP) && $type == 'n')
{
  Redirect('index.php', false);
}else {
  $seasonLink = $episodeLink = "";
  // What I use to connect to the database, used the same code for a long time
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection

    // This is where we write the sql to interact with the database
    $sql = "SELECT * FROM seasons WHERE seasonNum=$seasonP";
    $result = $conn->query($sql);

    // If there are any results that match the SQL the it returns true
    if ($result->num_rows > 0) {
      // if there are multiple results it will run thru each one,
      // you can put html in here with echo out if wanted. There might
      // be an example of this later in the code IDK.
      while($row = $result->fetch_assoc()) {
        // This stores the data from seasons table from column 'folder'
        $seasonLink = $row['folder'];

      }
    }

    $sql = "SELECT * FROM episodes WHERE episodeNum='$episodeP' AND season='$seasonP'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        // fetching data from the link column in the table
        $episodeLink = $row['link'];
      }
    }
    echo $seasonLink . "/" . $episodeLink . ".mp3";

    // I closed the SQL connection because I am leaving the function. IDK
    // the exact reccomendations on this, I just have always done it this way.
    $conn->close();
}
}

function playTitle($servername, $username, $password, $dbname, $sStart, $sNum, $seasonP, $episodeP, $uname) {
  $theName = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM episodes WHERE episodeNum='$episodeP' AND season='$seasonP'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        // Storing the data from column 'name' of table episodes
        $theName = $row['name'];

      }
    }
    echo "S" . $seasonP . "E" . $episodeP . ": " . $theName;
    $conn->close();

    $sql="";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // This next bit of code is how you store a new data row in a table.
      // I was using this to store data on when the podcast was played, and by who if logged in.
      $tomdate = date("Y-m-d H:i:s");
      if ($uname == "") {
        $sql = "INSERT INTO views (username, season, episode, logdate) VALUES ('visitor', '$seasonP', '$episodeP', '$tomdate')";
      }else {
        $sql = "INSERT INTO views (username, season, episode, logdate) VALUES ('$uname', '$seasonP', '$episodeP', '$tomdate')";
      }

       if ($conn->query($sql) === TRUE) {

      } else {
       echo "Error updating record: " . $conn->error;
      }
      $conn->close();
}

/* You can use this to activate certain php scripts or to pass in data
   from forms. commentSubmit with the 'name' attribute of a sumbit button.
   Essentially it is if the <input type="submit" name="commentSubmit" />
   was pressed then run the script after the if. This requires a html form
   tag, which you can find below. */
if (!empty($_POST['commentSubmit'])) {
  $formcheck = 0;

  // $_POST["newComment"] pulls the data from a text box in the form.
  $newComment = test_input($_POST["newComment"]);
   if (strlen($newComment >= 501)) {
       $formcheck = 1;
   }

   if ($formcheck == 0) {
     if (isset($_SESSION['uname'])) {


      $tomdate = date("Y-m-d H:i:s");
      // Storing the comment of the user, storing it in the table.
      $sql = "INSERT INTO comments (username, season, episode, active, comment, commentDate) VALUES ('$uname', '$seasonP', '$episodeP', 1, '$newComment', '$tomdate')";
      if ($conn->query($sql) === TRUE) {

      } else {
        echo "Error updating record: " . $conn->error;
      }

      $conn->close();
   }
}
}

// Built this funtion to display the comments.
function allComments($servername, $username, $password, $dbname, $seasonP, $episodeP) {
  $cName = $theComment = $cType = $tClass = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM comments WHERE season='$seasonP' AND episode='$episodeP' AND active=1 ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $cName = $row['username'];
        $theComment = $row['comment'];

        $sqlTwo = "SELECT * FROM honeyusers WHERE username='$cName'";
        $resultTwo = $conn->query($sqlTwo);
        /* So this is a good example of getting multiple rows of data and
           running the html for ever row it finds */
        if ($resultTwo->num_rows > 0) {
          while($row = $resultTwo->fetch_assoc()) {
            $cType = $row['type'];

            $tClass = "comName";
            // I used this to pick the class assocciated with the user to change
            // the color of the username depending on type of user.
            // EX: admins comments generate their username in red to set them apart.
            if ($cType == 'm' || $cType == 'a')
            {
              $tClass = $tClass . " nMas";
            } else if ($cType == 'g')
            {
              $tClass = $tClass . " nGuest";
            }
            echo '
            <div class="commentWrp">
              <div class="' . $tClass . '">
                <b>' . $cName . ':</b>
              </div>
              <div class="theComment">
              ' . $theComment . '
              </div>
            </div>
            ';
          }
        }else{
          echo 'Seems no records';
        }
      }
    }



    $conn->close();
}

// most of the rest of this is html with php laced in it.
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="layout.css">
  <title>H.M.M</title>
</head>
<body>
  <div class="banner">
    Test podcast site
  </div>
  <div class="navBar">
    <div class="navButton"><a class="agrab" href="index.php">Home</a></div>
    <div class="navButton"><a class="agrab" href="aboutus.php">About Us</a></div>
    <?php
    // If they are logged in and a admin, then provides an upload link in the navi bar.
    if (isset($_SESSION['uname'])) {
      if ($type == 'm' || $type == 'a')
      {
        echo '<div class="navButton"><a class="agrab" href="upload.php">Upload</a></div>';
      }
    }
    ?>
    <!--<div class="navMiddle">&nbsp;</div>-->
    <?php
    if (!isset($_SESSION['uname'])) {
      echo '
    <div class="navBRight"><a class="agrab" href="signup.php">Sign up</a></div>
    ';}else {
      echo '
      <div class="navBRight"><a class="agrab" href="logout.php">Log Out</a></div>';
    }
    ?>
  </div>
  <div class="main">
    <div class="mainl">
      <div class="logoM">
        <img src="pics/logo1.png">
      </div>
      <div class="mainlText">
        <div class="PodcastTitle">
          <b>&#8226;Podcasts&#8226;</b>
        </div><p />
        <div class="PodcastTitle">
          <?php playTitle($servername, $username, $password, $dbname, $sStart, $sNum, $seasonP, $episodeP, $uname); ?>
        </div><p />
        <div class="playMedp">
          <audio controls>
            <source src="podcasts/<?php playlink($servername, $username, $password, $dbname, $sStart, $sNum, $seasonP, $episodeP); ?>" type="audio/mpeg">
                Sorry, Error loading Podcast.
          </audio>
        </div>
        <p />
        <div class="PodcastTitle">
          <b>Comments</b>
        </div>
        <?php
        if (isset($_SESSION['uname'])) {
        echo '
          <div class="commentBox">
          <form action="' . htmlspecialchars($_SERVER[' PHP_SELF ']) . '" enctype="multipart/form-data" method="post">
            <div class="nCommentWrp">
              <textarea name="newComment" maxlength="500" required></textarea>
            </div>
            <div class="commentButton">
              <input type="submit" name="commentSubmit" value="Add Comment" />
            </div>
          </form>
        </div>';}
      ?>
      <p />
      <?php allComments($servername, $username, $password, $dbname, $seasonP, $episodeP); ?>

    </div>
    </div>
    <div class="mainr">
      <div class="logback">
      <?php
      if (!isset($_SESSION['uname'])) {
        echo '
        <div class="logBB">
          <b>&#8226;Login&#8226;</b>
        </div>
        <form action="' . htmlspecialchars($_SERVER[' PHP_SELF ']) . '" enctype="multipart/form-data" method="post">
        <div class="logWr">

          <div class="logBT">
            Username:
          </div>
          <div class="logBI">
            <input type="text" name="luname" id="luname" />
          </div>
        </div>
        <div class="logWr">
          <div class="logBT">
            Password:
          </div>
          <div class="logBI">
            <input type="password" name="lpword" id="lpword" />
          </div>
        </div>
        <div class="logBB">
          <div class="logErr">
            ' . $loginErr . '
          </div>
        </div>
        <div class="logBB">
          <input type="submit" value="Login" name="loginB" />
        </div>
      </div>

      ';}
      else {
        echo '
        <div class="logBB">
          <b>&#8226;User Info&#8226;</b>
        </div>
        <div class="logWr">
          <div class="logBT">
            Username:&nbsp;
          </div>
          <div class="logBI">
            ' . $uname . '
          </div>
        </div>
        <div class="logWr">
          <div class="logBT">
            Type:&nbsp;
          </div>
          <div class="logBI">';
          if ($type == 'n')
          {
            echo 'Normal';
          }elseif($type == 'g'){
            echo 'Guest';
          }elseif($type == 'a'){
            echo 'Admin';
          }elseif($type == 'm'){
            echo 'Master';
          }
            echo '
          </div>
        </div>
        <div class="logWr">
          <div class="logBT">
            Current:&nbsp;
          </div>
          <div class="logBI">
            Season ' . $sNum . '
          </div>
        </div>
        <div class="logWr">
          <div class="logBT">
            Started:&nbsp;
          </div>
          <div class="logBI">
            Season ' . $sStart . '
          </div>
        </div>
        ';
      }
      ?>
      </div>
    </div>
  </div>
</body>
</html>
