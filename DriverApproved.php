<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<title>Driver Approved</title>
<style><!--style of the table-->
table,tr,td{
	border: 1px solid black;
	border-collapse: collapse;
	background-color: white;
	color: black;
}
</style>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /><!--import ManageCSS.css file-->
</head>
<body>
<?php include ("connect.php");//use connect.php connect database
session_start();
$sql="SELECT DR_ID, DR_Name, DR_Tel FROM Driver;";//sql statement display driverid, drivername and drivertelephonenumber from driver table 
echo "<table>";//display databse use table style
$result=$conn->query($sql);
if($result->num_rows>0)
{
	echo"<tr><td>DR_ID</td><td>DR_Name</td><td>DR_Tel</td></tr>";//show text "DR_ID", "DR_Name", "DR_Tel"
	while($row=$result->fetch_assoc())
	{
		echo "<tr><td>".$row["DR_ID"]. "</td><td>" . $row["DR_Name"]. "</td><td>" . $row["DR_Tel"]. "</td></tr>";
	}
}//display driverid, drivername and drivertelephonenumber
else
{
echo "<tr><td>0 results</td></tr>";//if database is empty, will display "0 results"
}
echo "</table>";//close table bolder
?>
</body>
</html>