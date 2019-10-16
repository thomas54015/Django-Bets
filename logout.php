<?php
session_start();
include "functions.php";
unset($_SESSION['userSess']);
session_destroy();
Redirect("login.php");
?>
