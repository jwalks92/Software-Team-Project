<?php
error_reporting(0);
$servername="homepages.cs.ncl.ac.uk";
$username="csc8005_team03";
$password="Gray(SatBand";
$db="csc8005_team03";

// Create connection
$conn=new mysqli($servername,$username,$password,$db);

// Check connection
if($conn->connect_error)
{
	die("Connection failed :" .$conn->connect_error);
}
?>
