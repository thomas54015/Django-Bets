<!doctype html>
<?php
include "functions.php";
?>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="./css/teamInfo.css">

        <title>Django Bets</title>
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
            <div class="navButtonL">
              <a href="teamInfo.php">Info</a>
            </div>
            <div class="navButtonR">
              <a href="login.php">Login</a>
            </div>
            <div class="navButtonR">
              <a href="signup.php">Sign up</a>
            </div>
        </div>

        <div class="wrapper">
            <div>
                <div class="selection-panel">
                    <button class="tablink" style="background:#212121;" onclick="openPage('blank', this, 'grey')" id="defaultOpen"></button>

                    <div class="grid">
                        <button class="tablink" onclick="openPage('Arsenal', this, 'grey')">
                            <img src="pics/teamIcons/arsenal.png" alt="Arsenal" class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Aston', this, 'grey')">
                            <img src="pics/teamIcons/astonvila.png" alt="Aston Villa F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('AFC', this, 'grey')">
                            <img src="pics/teamIcons/afcbourne.png" alt="A.F.C. Bournemouth" class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Brighton', this, 'grey')">
                            <img src="pics/teamIcons/brighton.png" alt="Brighton & Hove Albion" class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Burnley', this, 'grey')">
                            <img src="pics/teamIcons/burnley.jpg" alt="Burnley F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Chelsea', this, 'grey')">
                            <img src="pics/teamIcons/chelsea.jpg" alt="Chelsea F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Crystal', this, 'grey')">
                            <img src="pics/teamIcons/crystal.png" alt="Crystal Palace F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Everton', this, 'grey')">
                            <img src="pics/teamIcons/everton.png" alt="Everton F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Leicester', this, 'grey')">
                            <img src="pics/teamIcons/leicester.png" alt="Leicester F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Liverpool', this, 'grey')">
                            <img src="pics/teamIcons/liverpool.jpg" alt="Liverpool F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('ManCity', this, 'grey')">
                            <img src="pics/teamIcons/manCity.png" alt="Manchester City F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('ManU', this, 'grey')">
                            <img src="pics/teamIcons/manU.png" alt="Manchester United F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Newcastle', this, 'grey')">
                            <img src="pics/teamIcons/newcastle.jpg" alt="Newcastle United F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Norwich', this, 'grey')">
                            <img src="pics/teamIcons/norwich.png" alt="Norwich F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Sheffiled', this, 'grey')">
                            <img src="pics/teamIcons/sheffield.png" alt="Sheffiled United F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Southampton', this, 'grey')">
                            <img src="pics/teamIcons/southampton.png" alt="Southampton F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Tottenham', this, 'grey')">
                            <img src="pics/teamIcons/tottenham.png" alt="Tottenham Hotspurs F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Watford', this, 'grey')">
                            <img src="pics/teamIcons/watford.png" alt="Watford F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('WestHam', this, 'grey')">
                            <img src="pics/teamIcons/westHam.png" alt="West Ham United F.C." class="thumbnail">
                        </button>

                        <button class="tablink" onclick="openPage('Wolverhampton', this, 'grey')">
                            <img src="pics/teamIcons/wolver.png" alt="Wolverhampton Wanderers F.C." class="thumbnail">
                        </button>
                    </div>
                </div>
            </div>

            <script>
                //clicks a blank button that keeps the embedded frames from stacking on the page
                window.onload=function(){
                    document.getElementById("defaultOpen").click();
                };

                //script and code for buttons found at https://www.w3schools.com/howto/howto_js_full_page_tabs.asp
                function openPage(pageName,elmnt,color) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                    }

                    document.getElementById(pageName).style.display = "block";
                }

                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>

            <?php
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
            ?>

            <div class="infoWrapper">
                <div id="Arsenal" style="padding:100px 40px;" class="tabcontent">

                    <iframe src="https://footystats.org/api/club?id=59" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                    <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Arsenal'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Aston" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=158" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Aston Villa'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="AFC" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=148" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Bournemouth'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Brighton" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=209" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Brighton & Hove Albion'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Burnley" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=145" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Burnley'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Chelsea" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=152" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Chelsea'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Crystal" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=143" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Crystal Palace'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Everton" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=144" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Everton'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Leicester" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=108" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Leicester City'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Liverpool" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=151" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Liverpool'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="ManCity" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=93" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Man City'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="ManU" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=149" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Man United'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Newcastle" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=157" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Newcastle'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Norwich" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=159" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Norwich'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Sheffiled" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=251" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Sheffield Utd'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Southampton" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=146" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Southampton'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Tottenham" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=92" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Tottenham'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Watford" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=155" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Watford'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="WestHam" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=153" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'West Ham'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>

                <div id="Wolverhampton" style="padding:100px 40px;" class="tabcontent">
                    <iframe src="https://footystats.org/api/club?id=223" height="100%" width="100%" style="height:420px; width:100%;" frameborder="0"></iframe>
                        <?php
                        $sql = "SELECT * FROM teams WHERE team = 'Wolverhampton'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo $row['team'] . " has a total of " . $row['points'] . " points<br>";

                                echo $row['team'] . " has scored " . $row['scores'] . ' goals and given up ' . $row['conceded'] . " goals<br>";

                                $w = $row['wins']/($row['wins']+$row['losses']+$row['draws'])*100;
                                echo $row['team'] . "'s wins percentage is currently " . round($w,2) . "%<br>";
                                if ($w < 50) {
                                    echo "Dr.Django does not recommend this team.";
                                }
                                else {
                                    echo "Dr.Django recommends this team!";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
</html>
