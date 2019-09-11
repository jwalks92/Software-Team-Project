<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dbdelete.php</title>
</head> 
<body>
<?php
$WF_ID=$_REQUEST["WF_ID"]; //Get the id which need to delete.
if ($WF_ID==null)
{
	?>
 <script>alert("Warning:Incorrect or Empty Information!!");window.location.href="dbselect.php";</script><!--If ID is empty, give warning message-->
 <?php
}
else{
include ("connect.php");
session_start(); //Connect to database.
$sql="SELECT * FROM csc8005_team03.WarehouseFood WHERE WF_ID=$WF_ID";
$query = mysqli_query($conn,$sql);//Find the ID is exist or not in database.
if (mysqli_num_rows($query)==0){//If the num_rows is zero, it means ID is not exist.
	?>
	<script>alert("Warning:The delete data do not exist!");window.location.href="dbselect.php";</script><!--Give warning message-->
	<?php
	}else{
$sql="DELETE FROM csc8005_team03.WarehouseFood WHERE WF_ID=$WF_ID"; //Delete the row in database.
if (mysqli_query($conn,$sql))
{
?>
<script>alert("Delete successful!");window.location.href="dbselect.php";</script><!--Give successful message-->
<?php
}
else {
echo "Error:" . $sql . "<br>" . mysqli_error($conn);//If something wrong, print the error message.
}
}
}
?>
</body>
</html>