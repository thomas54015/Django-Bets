<?php
session_start();
include "functions.php";

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

function leaguesData($servername, $username, $password, $dbname, $uname, $leagueP)
{

  //#####################################################
  //#####################################################
  //######### DO NOT FORGET TO CHANGE LINKPASS  #########
  //######### IN HOME.PHP BEFORE UPLOADING SITE #########
  //#####################################################
  //#####################################################

$urlMain = "localhost/Django-Bets/";
//$urlMain = "www.djangosfantasy.com/";

$leagueAccess = 0;
$leagueCaptin = "";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //error message if database connection fails.
  }

$sql = "SELECT * FROM leagues WHERE username = '$uname' AND league = '$leagueP' AND valid = '1'";
/*This is the first mySQL. This selects data from the
table users where the username colum is equal to the username input */

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row

  while($row = $result->fetch_assoc()) {
    $leagueCaptin = $row['leader'];

    if ($uname == $leagueCaptin)
    {
      $leagueAccess = 2;
    }
    else
    {
      $leagueAccess = 1;
    }
  }
}

// If just a regular user, then we only want to show them other team users and points.
/*
<div class="leagueBox"><br>
  Leaguename<br><br>

  Team - TeamPoints<br><br>

  player1 - points<br>
  player2 - points<br>
  player3 - points<br>
  player4 - points<br>
  player5 - points<br>
  player6 - points<br>
  player7 - points<br>
  player8 - points<br>
  player9 - points<br>
  player10 - points<br>
  player11 - points<br>
</div>
*/
if ($leagueAccess == 1)
{
  $points = 0;
  $sql = "SELECT * FROM points WHERE player='$uname' AND league='$leagueP'";
  $resultx = $conn->query($sql);
  if ($resultx->num_rows > 0) {
    while($rowx = $resultx->fetch_assoc()) {
      $points = $rowx['points'];
    }
  }
  echo $leagueP . '<br>';
  echo '<a href="draft.php?leagueP=' . $leagueP . '">Draft!</a><br>';
  echo "Points: $points<br><br>";

  echo "League Captin: " . $leagueCaptin . "<br>";
  echo "Players:<br>";
  $sql = "SELECT * FROM points WHERE player='$leagueCaptin' AND league='$leagueP'";
  $resultx = $conn->query($sql);
  if ($resultx->num_rows > 0) {
    while($rowx = $resultx->fetch_assoc()) {
      $points = $rowx['points'];
    }
  }
  echo "1. " . $leagueCaptin . " - Points: " . $points . "<br>";

  $sql = "SELECT * FROM leagues WHERE league = '$leagueP' AND valid = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 1;
  if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
      if ($row['username'] != $leagueCaptin)
      {
        $points = 0;
        $player = $row['username'];
        $sql = "SELECT * FROM points WHERE player='$player' AND league='$leagueP'";
        $resulty = $conn->query($sql);
        if ($resulty->num_rows > 0) {
          while($rowy = $resulty->fetch_assoc()) {
            $points = $rowy['points'];
          }
        }
        echo $nameCount . ". " . $row['username'] . " - Points: " . $points . "<br>";
      }

      $nameCount++;

    }
  }

  echo "<br>Winning Teams Picked: <br>";
  $sql = "SELECT * FROM draft WHERE league = '$leagueP' AND username = '$uname' AND winlose = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 1;
  if ($result->num_rows > 0) {
    // output data of each row
    $winTeams = 1;
    while($row = $result->fetch_assoc()) {
      echo $winTeams . '. ' . $row['team'] . '<br>';
      $winTeams++;
    }
  }
  echo "
  <br>
  Losing Team Picked:<br>";
  $sql = "SELECT * FROM draft WHERE league = '$leagueP' AND username = '$uname' AND winlose = '0'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 1;
  if ($result->num_rows > 0) {
    // output data of each row
    $loseTeams = 1;
    while($row = $result->fetch_assoc()) {
      echo $loseTeams . '. ' . $row['team'] . '<br>';
      $loseTeams++;
    }
  }
  echo "

  <br>
  ";
}
else if ($leagueAccess == 2)
{
  $points = 0;
  $sql = "SELECT * FROM points WHERE player='$uname' AND league='$leagueP'";
  $resultx = $conn->query($sql);
  if ($resultx->num_rows > 0) {
    while($rowx = $resultx->fetch_assoc()) {
      $points = $rowx['points'];
    }
  }
  // This is for the league captian.
  echo $leagueP . '<br>';
  echo '<a href="draft.php?leagueP=' . $leagueP . '">Draft!</a><br>';

  echo "Points: $points<br><br>";

  echo "League Captin: " . $leagueCaptin . "<br>";
  echo "* Send links to invite players *<br>";
  echo "Players:<br>";
  echo "1. " . $leagueCaptin . " - Points: " . $points . "<br>";

  $sql = "SELECT * FROM leagues WHERE league = '$leagueP' AND valid = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 1;
  if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
      if ($row['username'] != $leagueCaptin)
      {
        $points = 0;
        $player = $row['username'];
        $sql = "SELECT * FROM points WHERE player='$player' AND league='$leagueP'";
        $resultx = $conn->query($sql);
        if ($resultx->num_rows > 0) {
          while($rowx = $resultx->fetch_assoc()) {
            $points = $rowx['points'];
          }
        }
        echo $nameCount . ". " . $row['username'] . " - Points: " . $points . ' <a href="delete.php?leagueN=' . $leagueP . '&delUser=' . $row['username'] . '">Delete</a><br>';
      }

      $nameCount++;

    }
  }

  $sql = "SELECT * FROM invite WHERE league = '$leagueP' AND valid = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
      echo $nameCount . ". " . $urlMain . "invite.php?leagueN=" . $leagueP . "&invite=" . $row['link'] . "<br>";
      $nameCount++;

    }
  }
  echo "<br>Winning Teams Picked: <br>";
  $sql = "SELECT * FROM draft WHERE league = '$leagueP' AND username = '$uname' AND winlose = '1'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 1;
  if ($result->num_rows > 0) {
    // output data of each row
    $winTeams = 1;
    while($row = $result->fetch_assoc()) {
      echo $winTeams . '. ' . $row['team'] . '<br>';
      $winTeams++;
    }
  }
  echo "
  <br>
  Losing Team Picked:<br>";
  $sql = "SELECT * FROM draft WHERE league = '$leagueP' AND username = '$uname' AND winlose = '0'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);
  $nameCount = 1;
  if ($result->num_rows > 0) {
    // output data of each row
    $loseTeams = 1;
    while($row = $result->fetch_assoc()) {
      echo $loseTeams . '. ' . $row['team'] . '<br>';
      $loseTeams++;
    }
  }
  echo "

  <br>
  ";
}
else
{
  echo "Invalid league or no league selected.<br>
  You can select or create a league in left tool bar.";
}


}
function updatebutton($servername, $username, $password, $dbname) {
	
	$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://sportsop-soccer-sports-open-data-v1.p.rapidapi.com/v1/leagues/premier-league/seasons/19-20/standings",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"x-rapidapi-host: sportsop-soccer-sports-open-data-v1.p.rapidapi.com",
			"x-rapidapi-key: 4777a60297msh383d23636d01510p16375ejsn40230e12fcd8"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$new = explode('team":',$response);
		for ($i = 1; $i < sizeof($new); $i++) {
			$team = explode('"',$new[$i])[1];
			$wins = preg_replace('/[^0-9]/','',explode('"',$new[$i])[6]);
			$draws = preg_replace('/[^0-9]/','',explode('"',$new[$i])[8]);
			$losses = preg_replace('/[^0-9]/','',explode('"',$new[$i])[10]);
			$points = preg_replace('/[^0-9]/','',explode('"',$new[$i])[12]);
			$scores = preg_replace('/[^0-9]/','',explode('"',$new[$i])[14]);
			$conceded = preg_replace('/[^0-9]/','',explode('"',$new[$i])[16]);
			$matches_played = preg_replace('/[^0-9]/','',explode('"',$new[$i])[22]);
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$sql = ("UPDATE teams SET wins=$wins, losses=$losses, draws=$draws, points=$points, scores=$scores, conceded=$conceded, played=$matches_played WHERE team='$team'");
			if($conn->query($sql) === FALSE) {
				echo "SQL FAIL\n";
			}
			#echo "$result\n";
			if (!$conn->commit()) {
				echo "Transaction commit failed\n";
			}
		}
		echo 'Update Complete<br>';
	}
}
function pointsbutton($servername, $username, $password, $dbname) {
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = ("DELETE FROM points");
  if($conn->query($sql) === FALSE) {
    echo "SQL FAIL\n";
  }
  if (!$conn->commit()) {
    echo "Transaction commit failed\n";
  }
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = ("SELECT * from draft"); //grab rows in draft
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      $l = array();
      $p = array();
      while($row = $result->fetch_assoc()) {
          $max = sizeof($l);
          $found = 0;
          for($i = 0; $i < $max;$i++) {
            if ($row['league'] == $l[$i] && $row['username'] == $p[$i]) {
              $found += 1;
            }
          }
          if ($found == 0) {
            array_push($l,$row['league']);
            array_push($p,$row['username']);
          }
          elseif ($found == 1) {
            array_push($l,$row['league']);
            array_push($p,$row['username']);
          }
          elseif ($found == 2) {
            array_push($l,$row['league']);
            array_push($p,$row['username']);
          }
          elseif ($found == 3) {
            echo "found3\n";
            $leaguetemp = $row['league'];
            $usernametemp = $row['username'];
            $loss = '';
            $win1 = '';
            $win2 = '';
            $win3 = $row['team'];
            $points = 0;
            $sql = ("SELECT * from draft where username='$usernametemp' and league='$leaguetemp'"); 
            $resultx = $conn->query($sql);
            if ($resultx->num_rows > 0) {
              $j = 0;
              while($rowx = $resultx->fetch_assoc()) {
                if ($j == 0){
                  $loss = $rowx['team'];
                  $sql = ("SELECT * from teams where team='$loss'");
                  $result1 = $conn->query($sql);
                  if ($result1->num_rows > 0) {
                    while($rowy = $result1->fetch_assoc()) {
                      $points -= $rowy['points'];
                      echo '$points\n';
                    }
                  }
                }
                elseif ($j == 1) {
                  $win1 = $rowx['team'];
                  $sql = ("SELECT * from teams where team='$win1'");
                  $result2 = $conn->query($sql);
                  if ($result2->num_rows > 0) {
                    while($rowy = $result2->fetch_assoc()) {
                      $points += $rowy['points'];
                      echo '$points\n';
                    }
                  }
                }
                elseif ($j == 2) {
                  $win2 = $rowx['team'];
                  $sql = ("SELECT * from teams where team='$win2'"); 
                  $result3 = $conn->query($sql);
                  if ($result3->num_rows > 0) {
                    while($rowy = $result3->fetch_assoc()) {
                      $points += $rowy['points'];
                      echo '$points\n';
                    }
                  }
                }
                elseif ($j == 3) {
                  $sql = ("SELECT * from teams where team='$win3'");
                  $result4 = $conn->query($sql);
                  if ($result4->num_rows > 0) {
                    while($rowy = $result4->fetch_assoc()) {
                      $points += $rowy['points'];
                      echo '$points\n';
                    }
                  }
                }
                $j += 1;
            }

            $sql = ("INSERT INTO points VALUES('$leaguetemp','$usernametemp',$points)");
            if($conn->query($sql) === FALSE) {
              echo "SQL FAIL\n";
            }
            if (!$conn->commit()) {
              echo "Transaction commit failed\n";
            }
          }
        }
      }
  } else {
      echo "0 results";
  }
}

if (!empty($_POST['newLeagueB']))
{
  $mayCreate = 1;
  $leagueError = "";
  $leagueN = $_POST['newLeagueT'];

  if ($leagueN == "")
  {
    $leagueError = "The League name must not be blank!";
    $mayCreate = 0;
  }

  // I knew this function existed, but refrenced from :https://www.w3schools.com/php/func_string_strtolower.asp#targetText=strtoupper()%20%2D%20converts%20a%20string,in%20a%20string%20to%20uppercase
  // The reason I did this, is so that people cant have the same username with different caps.
  $leagueN = strtolower($leagueN);
  $conn = new mysqli($servername, $username, $password, $dbname);


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

  $sql = "SELECT * FROM leagues WHERE league = '$leagueN'";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  // this looks to see if there are any resultsf from the sql.
  if ($result->num_rows > 0) {
    $leagueError = "Sorry, League name is already taken!";
    $mayCreate = 0;
  }

  if ($mayCreate == 1) {
    // refrenced: https://www.pontikis.net/tip/?id=18 for date('Y-m-d H:i:s')
    $currentDT = date('Y-m-d H:i:s');
    // refrenced: https://www.w3schools.com/php/php_mysql_insert.asp
    $sql = "INSERT INTO leagues (league, username, leader, dateCreate, valid)
    VALUES ('$leagueN', '$uname', '$uname', '$currentDT', 1)";

    $conn->query($sql);

    $numsTest = "";
    for($i = 0; $i < 4; $i++) {
      $numsTest .= $i;

      //Verification code
      $verifyCode = "";
      $verifyChars = array_merge(range('a', 'z'), range(0,9));
      for($j = 0; $j < 8; $j++) {
              $verifyCode .= $verifyChars[array_rand($verifyChars)];
      }

      $sql = "INSERT INTO invite (link, league, username, valid)
      VALUES ('$verifyCode', '$leagueN', '$uname', 1)";

      $conn->query($sql);
    }
  //  echo "Loop check: " . $numsTest;
  }
  $conn->close();
}

function leaguesName($servername, $username, $password, $dbname, $uname)
{
  $conn = new mysqli($servername, $username, $password, $dbname);


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
    }

    

    $sql = "SELECT * FROM leagues WHERE username = '$uname' AND valid='1'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $leagueN = $row['league'];
        $points = 0;
        $sql = "SELECT * FROM points WHERE player='$uname' AND league='$leagueN'";
        $resultx = $conn->query($sql);
        if ($resultx->num_rows > 0) {
          while($rowx = $resultx->fetch_assoc()) {
            $points = $rowx['points'];
          }
        }
        echo '<a href="home.php?leagueP=' . $leagueN . '">' . $leagueN . '</a> ' . $points . '<br>';
      }
    }
}
 ?>
<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="./css/home.css">

        <title>Django Bets</title>
        <link rel="icon" href="./pics/danjosfantasy.jpg">
    </head>

    <body>
        <div class="banner">
            <img class="page-logo" src="./pics/logo.png" alt="logo">
          </div>
          <div class="navWrap">

            <?php
            echo  '
            <div class="navButtonL">
              <a href="home.php">Home</a>
            </div>
            <div class="navButtonL">
              <a href="teamInfo.php">Info</a>
            </div>
            <div class="navButtonR">
              <a href="logout.php">Logout</a>
            </div>
            <div class="navButtonR">
              <a href="#">' . $_SESSION['userSess'] . '</a>
            </div>

            ';
             ?>
          </div>

        <div class="wrapper">
            <div class="panel-left">
                <a href="profile.php" class="profile">
                    <img class="profile-picture" alt="profile picture" src="pics/defaultprofile.png">
                </a>
                <div>
                    <?php
                    
                    echo $_SESSION['userSess'];
                    #if ($_SESSION['userSess'] == "daniluk") {
                      echo "<br><br>";
                      if (array_key_exists('updatebutton', $_POST)) {
                        updatebutton($servername, $username, $password, $dbname);
                      }
                      echo '<form method="post">
                      <input type="submit" name="updatebutton"
                        class="button" value="Update Teams" /> ';
                    echo "<br>";
                    if (array_key_exists('pointsbutton', $_POST)) {
                      pointsbutton($servername, $username, $password, $dbname);
                    }
                    echo '<form method="post">
                    <input type="submit" name="pointsbutton"
                      class="button" value="Update Points" /> ';
                    ?>
                <br>



                </div>
                <br><br>
                <ul class="leagueList">
                    <?php
                    leaguesName($servername, $username, $password, $dbname, $uname);
                     ?>
                </ul>
                <div class="newLeague">
                  <form action="<?php htmlspecialchars($_SERVER[' PHP_SELF ']); ?>" enctype="multipart/form-data" method="post">
                    <div class="newLeagueL">
                      Name:
                    </div>
                    <input type="text" class="newLeagueT" name="newLeagueT" />
                    <input type="submit" class="newLeagueB" name="newLeagueB" value="➕ Create League" />
                    <div>Be sure you enter a unique league name!</div>
                  </form>
                  <div class="newLeagueErr">
                    <?php
                    echo $leagueError;
                     ?>
                  </div>
                </div>
                <br><br>
                <a class="twitter-timeline" data-height="500" data-theme="dark" href="https://twitter.com/premierleague?ref_src=twsrc%5Etfw">Tweets by premierleague</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              </div>
            <div class="panel-center">
                <div style="justify-content: center;">
                  <button class="tablink" onclick="openPage('Team', this, 'grey')" id="team">My Team</button>
                  <button class="tablink" onclick="openPage('Standings', this, 'grey')" id="standings">Standings</button>
                </div>

                <div id="Team" class="tabcontent">
                  <div class="leagueBox">
                    <?php
                    leaguesData($servername, $username, $password, $dbname, $uname, $leagueP);
                    ?>

                  </div>
                </div>
                <div id="Standings" class="tabcontent" style="margin:10px;margin-top:70px;">
                  <!-- This widget is from https://www.sofascore.com/tournament/football/england/premier-league/17 -->
                  <iframe id="sofa-standings-embed-1-23776" width="100%" height="726px" style="height:726px!important" src="https://www.sofascore.com/tournament/1/23776/standings/tables/embed" frameborder="0" scrolling="no"></iframe><script type="text/javascript" src="https://www.sofascore.com/bundles/sofascoreweb/js/bin/util/embed.min.js"></script><script type="text/javascript">sofa_embed('sofa-standings-embed-1-23776', window);</script>
                </div>
                <script>
                  //script and code for buttons found at https://www.w3schools.com/howto/howto_js_full_page_tabs.asp
                  function openPage(pageName,elmnt,color) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                      tabcontent[i].style.display = "none";
                    }
                    document.getElementById(pageName).style.display = "block";
                  }

                  //gives the frame a chance to load before automatically clicking to the team page
                  window.onload=function(){
                    document.getElementById("standings").click();
                    setTimeout(openPage('Team', this, 'grey'), 3000);
                  };
                </script>
            </div>
            <div class="panel-right">
              <h2 style='text-align: center'>Trades</h2>

              <div class="inner-panel-right">
                <div class="tradeBox">
                  <img src="pics/teamIcons/arsenal.png" style='width:49%;' alt="Arsenal">
                  <img src="pics/teamIcons/chelsea.jpg" style='width:49%;' alt="Chelsea F.C.">
                  <button type="button" class='tradeButton' name="tradeButton">ACCEPT!</button>
                </div>

                <div class="tradeBox">
                  <img src="pics/teamIcons/wolver.png" style='width:49%;' alt="Wolverhampton Wanderers F.C.">
                  <img src="pics/teamIcons/southampton.png"  style='width:49%;'alt="Liverpool F.C.">
                  <button type="button" class='tradeButton' name="tradeButton">ACCEPT!</button>
                </div>

                <div class="tradeBox">
                  <img src="pics/teamIcons/liverpool.jpg" style='width:49%;' alt="Liverpool F.C.">
                  <img src="pics/teamIcons/manCity.png" style='width:49%;' alt="Manchester City F.C.">
                  <button type="button" class='tradeButton' name="tradeButton">ACCEPT!</button>
                </div>

                <div class="tradeBox">
                  <img src="pics/teamIcons/everton.png" style='width:49%;' alt="Everton F.C.">
                  <img src="pics/teamIcons/manCity.png" style='width:49%;' alt="Manchester City F.C.">
                  <button type="button" class='tradeButton' name="tradeButton">ACCEPT!</button>
                </div>

              </div>

              <div class="swap" style='padding-top=20px;'>
                <select class="myTeams" style='width: 120px; margin-left: 0px;' name="MyTeams">
                  <option value="Arsenal">Arsenal</option>
                  <option value="Chelsea F.C.">Chelsea F.C.</option>
                  <option value="Wolverhampton Wanderers F.C.">Wolverhampton Wanderers F.C.</option>
                  <option value="Everton F.C.">Everton F.C.</option>
                </select>

                <select class="wantedTeams" style='width: 120px; float: right;'name="wantedTeams">
                  <option value="Manchester City F.C.">Manchester City F.C.</option>
                  <option value="Liverpool F.C.">Liverpool F.C.</option>
                  <option value="Leicester F.C.">Leicester F.C.</option>
                  <option value="Tottenham Hotspurs F.C.">Tottenham Hotspurs F.C.</option>
                </select>

                <button type="button" class='requestButton' name="button">REQUEST</button>
              </div>
            </div>
        </div>
    </body>
</html>
