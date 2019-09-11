<head>
    <meta charset="utf-8">
    <title> CLUK Warehouse </title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /><!--import ManageCSS.css file-->
    
</head>


<?php include ("connect.php");//use connect.php connect database
session_start();
$sql="SELECT WF_ID, WF_Name, WF_Amount_Per_Unit, WF_Quanity_Name_Per_Unit , WF_Price_Per_Unit FROM WarehouseFood;";//display warehouse food id, food name, unit, quanity name and price from warehousefood database
echo "<table>";//display databse use table style
$result=$conn->query($sql);
if($result->num_rows>0)
{
echo"<tr><td>ID </td><td>Name </td><td>Amount </td><td>QuanityName </td><td>Price(&pound;) </td></tr>";//display  ID, Name, Amount, QuanityName and price£
	while($row=$result->fetch_assoc())
	{		
		echo "<tr><td>".$row["WF_ID"]. "</td><td>" . $row["WF_Name"]. "</td><td>" . $row["WF_Amount_Per_Unit"]. "</td><td>" . $row["WF_Quanity_Name_Per_Unit"]. "</td><td>" . $row["WF_Price_Per_Unit"]. "</td></tr>";
	}
}//display warehouse food id, food name, unit, quanity name and price from warehousefood database
else
{
echo "<tr><td>0 results</td></tr>";//if database is empty, will display "0 results"
}
echo "</table>";//close table bolder
?>