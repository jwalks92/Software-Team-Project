<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dbinsert.php</title>
</head> 
<body>
<?php
//First of all, dbselect.php's form accept insert data
//dbselect.php use get method，in php, get and post process can use $_REQUEST["ValableName"] achevied 
$WF_ID=$_REQUEST["WF_ID"];
$WF_Name=$_REQUEST["WF_Name"];
$WF_Amount_Per_Unit=$_REQUEST["WF_Amount_Per_Unit"];
$WF_Quanity_Name_Per_Unit=$_REQUEST["WF_Quanity_Name_Per_Unit"];
$WF_Price_Per_Unit=$_REQUEST["WF_Price_Per_Unit"];
//Input ID and Amount must be POSITIVE INT,and Price POSITIVE NUMBER(Decimal in two places), and Name and Quanity Name must be letter, and all input can not be null.If have problem,give warning message.
if ((!(preg_match("/^[0-9]+$/",$WF_ID))) 
	or (!preg_match("/^[A-Za-z]+$/",$WF_Name))
	or (!(preg_match("/^[0-9]+$/",$WF_Amount_Per_Unit))) 
	or (!preg_match("/^[A-Za-z]+$/",$WF_Quanity_Name_Per_Unit))
    or (!(preg_match("/^(([1-9][0-9]*)|(([0]\.\d{1,2}|[1-9][0-9]*\.\d{1,2})))$/",$WF_Price_Per_Unit)))
    or ($WF_ID==null) or ($WF_Name==null) or ($WF_Amount_Per_Unit==null) or ($WF_Quanity_Name_Per_Unit==null) or ($WF_Price_Per_Unit==null))
{
?>
<script>alert("Warning:Incorrect or Empty Information!!");window.location.href="dbselect.php";</script><!--Give warning message-->
<?php
}
else
{
include ("connect.php");
session_start();
//control databse easier than dbselect.php，becasue no deal with query databse's result
//connect String use '.' rather than JSP's +, and asp's &
$sql=("INSERT INTO WarehouseFood(WF_ID,WF_Name,WF_Amount_Per_Unit,WF_Quanity_Name_Per_Unit,WF_Price_Per_Unit) VALUES ('".$WF_ID."','".$WF_Name."','".$WF_Amount_Per_Unit."','".$WF_Quanity_Name_Per_Unit."','".$WF_Price_Per_Unit."')");
if  (mysqli_query($conn,$sql))
{
?>
<script>alert("Insert success!");window.location.href="dbselect.php";</script><!--Give successful Message-->
<?php
}
else {
	?>
<script>alert("You input the same ID");window.location.href="dbselect.php";</script><!--Give warning Message-->
<?php
}
//$sql="INSERT INTO WarehouseFood (WF_ID, WF_Name, WF_Amount_Per_Unit, WF_Quanity_Name_Per_Unit , WF_Price_Per_Unit) VALUES ('".$WF_ID."','".$WF_Name."','".$WF_Amount_Per_Unit."','".$WF_Quanity_Name_Per_Unit."','".$WF_Price_Per_Unit."');
//mysql_query
mysqli_close($conn);


}
?>

</body>
</html>
