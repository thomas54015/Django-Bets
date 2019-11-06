<?php
session_start();

// I put this here incase we need to change the database information.
// This way we would only have to change it here instead of everywhere.
$servername = "localhost";
$username = "djangoadmin";
//djangoadmin8
$password = "bestgroup";
// best!Group
$dbname = "django";


//#####################################################
//#####################################################
//######### DO NOT FORGET TO CHANGE LINKPASS  #########
//######### IN HOME.PHP BEFORE UPLOADING SITE #########
//#####################################################
//#####################################################

//
/*
//This is for the online site.
$servername = "mysql.djangosfantasy.com";
$username = "djangoadmin8";
$password = "best!Group";
$dbname = "djangosfantasy";
*/

/*
MySQL command to add a new user to database. Not needed for anyone who doesn't
want to use a database locally. **Grants user full rights to everything**
GRANT ALL PRIVILEGES ON *.* TO 'djangoadmin'@'localhost' IDENTIFIED BY 'bestgroup';
*/

// A redirection function I found on the net a long time ago,
// I will try to find a reference to add here later.
// found: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}
?>
