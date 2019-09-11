<?
//destroys the connection with the database and directs back to the login page 
include ("connect.php");
session_start();
session_unset();
session_destroy();
ob_start();
header("location:loginPage.php");
ob_end_flush(); 
include 'loginPage.php';

exit();
?>
