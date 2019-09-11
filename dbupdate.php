<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dbupdate.php</title>
</head> 
<body>
<?php
$WF_ID=$_REQUEST["WF_ID"];//Get the ID from select.php page.
$rowname=$_REQUEST["rowname"];
$rowtext=$_REQUEST["rowtext"];//Get the modify information
if ((!(preg_match("/^[0-9]+$/",$WF_ID))) 
	or ((($rowname=="WF_Name")or($rowname=="WF_Quanity_Name_Per_Unit")) and (!preg_match("/^[A-Za-z]+$/",$rowtext)))
    or (($rowname=="WF_Amount_Per_Unit") and (!(preg_match("/^[0-9]+$/",$rowtext))))
    or(($rowname=="WF_Price_Per_Unit") and (!(preg_match("/^(([1-9][0-9]*)|(([0]\.\d{1,2}|[1-9][0-9]*\.\d{1,2})))$/",$rowtext))))
    or ($WF_ID==null) or ($rowtext==null)) //Input ID and Amount must be POSITIVE INT,and Price POSITIVE NUMBER(Decimal in two places), and Name and Quanity Name must be letter, and all input can not be null.If have problem,give warning message.
{
?>
<script>alert("Warning:Incorrect or Empty Information!!");window.location.href="dbselect.php";</script><!--Give warning message-->
<?php
}else{
include ("connect.php");
session_start();//Connect database.
$query = mysqli_query($conn,"SELECT * FROM WarehouseFood WHERE WF_ID =".$WF_ID.";");//Check the ID is exist.
if (mysqli_num_rows($query)>0){
$sql=("UPDATE WarehouseFood SET ".$rowname."='".$rowtext."' WHERE WF_ID=".$WF_ID.";");//Modify the information in database.
if  (mysqli_query($conn,$sql))
{
?>
<script>alert("Update success!");window.location.href="dbselect.php";</script><!--Give successful message-->
<?php
}
else {
echo "Error:" . $sql . "<br>" . mysqli_error($conn);//if something wrong,print the error message to programmer.
}
}else{
	?>
	<script>alert("Warning:Modify data not exist!");window.location.href="dbselect.php";</script><!--Give warning message-->
	<?php
}
}
?>
</body>
</html>