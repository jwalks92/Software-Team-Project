<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dbConfirm.php</title>
</head> 
<body>
<?php
$ID=str_replace('"','',$_REQUEST["ID"]); //Get the order ID which need to approve
include ("connect.php");
session_start();//Connect to database and start.
$sql="DELETE FROM csc8005_team03.Approve WHERE OrderID=$ID";
if (mysqli_query($conn,$sql)) //Delete data in database.
{
	$Flag2=true; 
}
else {
echo "Error:" . $sql . "<br>" . mysqli_error($conn); //If error, give error message to programmer.
}
$user = $_SESSION['username'];//get the username for globle variable.
$sql = "SELECT Name FROM Staff WHERE ID ='".$user."';"; 
$result=$conn->query($sql);
$name = mysqli_fetch_object($result);
$stuffName = $name->Name;//Get the staff name in the database.
$time = date("y-m-d H:i:s");//Get the nowtime.
$sql=("INSERT INTO csc8005_team03.Approve(OrderID,ApprovingStatus,Date_Time,Signed_By) VALUES ('".$ID."','APPROVE','".$time."','".$stuffName."')"); //Update the order staus.
if (mysqli_query($conn,$sql)) //insert data in database.
{
	$Flag1=true;
}
else {
echo "Error:" . $sql . "<br>" . mysqli_error($conn);
}
?>
<script>alert("Change date successful!");window.location.href="work.php";</script><!--give the successful message-->
<?php

mysqli_close($conn);
?>
</body>
</html>