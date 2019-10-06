<?php
// So these next four lines are connection data used over and over again in
// phpexample.php.  I commented a lot in phpexample.php, this file is just
// something you can look thru if you want to see more php code.
// oh, and you can see how I hashed passwords before below if you look for it.
$servername = "localhost";
$username = "thomas54015";
$password = "pass123";
$dbname = "testtest";



$uname = "";
$type = "";
$sStart = 0;
$sNum = 0;

if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
    $type = $_SESSION['type'];
    $sStart = $_SESSION['sStart'];
}

  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      //error message if database connection fails.
  }

  $sql = "SELECT * FROM seasons";
  /*This is the first mySQL. This selects data from the
  table users where the username colum is equal to the username input */

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  if ($row['seasonNum'] > $sNum)
  {
    $sNum = $row['seasonNum'];
  }
  }
  }


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

//Login stuff begins here
if (!empty($_POST['loginB'])) {
    $formcheck = 0;

    $loginErr = "";
$luname = $pword = $realpword = $email = $type = "";


        if (empty($_POST["luname"])) {
 $loginErr = "User name is required";
     $formcheck = 1;

     //same concept as interview test, checks to see if field is blank. If it is, it throws an error.
}

 if (empty($_POST["lpword"])) {
 $loginErr = "Password is required";
     $formcheck = 1;
}




 if ($formcheck != 1){ //if statement of what to do if the form fields ok.
     $luname = test_input($_POST["luname"]);
     $pword = test_input($_POST["lpword"]);
     $salt = "";


     $conn = new mysqli($servername, $username, $password, $dbname);
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
         //error message if database connection fails.
     }

     $sql = "SELECT * FROM honeyusers WHERE username = '$luname'";
     /*This is the first mySQL. This selects data from the
     table users where the username colum is equal to the username input */

     $result = $conn->query($sql);

     if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         $realpword = $row["password"];
         $email = $row["email"];
         $type = $row["type"];
         $salt = $row["salt"];
         $sStart = $row["season"];
         //different columns in my database.



         $pepper = $luname . "tRking";
         $hashpword = $pword . $pepper;
         $hashpword = crypt($hashpword, sprintf('$2y$%02d$', 9) . $salt);

         //This is where I rehash their password input to compare the hashed password in the database
         //I refrenced most of the hashing, but it does work.
         if ($hashpword == $realpword) {

              $_SESSION["uname"] = $luname;
              $uname = $luname;
             $_SESSION["type"] = $type;
             $_SESSION["sStart"] = $sStart;

             //because it SELECTS data using the username, if the hashed passwords are the same then the login is valid.



         }

         if ($pword != $realpword){
             $loginErr = "Username or Password incorrect!";

             /*I plan on adding more code here that will keep track of the login attempts and locks the account after so many attempts.
             I hope to do this by adding an attempt column under the user and UPDATE it on each attempt. Succeful login will reset the
             attempt column to 0 */
         }


     }
     }
     else {
       $loginErr = "Username or Password incorrect!";
       $conn->close();
     }



 }


    if (isset($_SESSION['uname'])) {

//if the login session is set then update tables for stat reasons. Such as how many logings, last login, and most used users.

$tomdate = date("Y-m-d H:i:s");
$sql = "UPDATE honeyusers SET lastlog='$tomdate' WHERE username='$luname'";
 if ($conn->query($sql) === TRUE) {

} else {
 echo "Error updating record: " . $conn->error;
}

$sql = "INSERT INTO loginlogs (username, datelog) VALUES ('$luname', '$tomdate')";
 if ($conn->query($sql) === TRUE) {

} else {
 echo "Error updating record: " . $conn->error;
}

$conn->close();
//Redirect('index.php', false);


}

}

// Login ends here.



?>
