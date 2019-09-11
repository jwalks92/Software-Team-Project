<head>
    <meta charset="utf-8">
    <title> CLUK Warehouse </title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /><!--import ManageCSS.css file-->
    
</head>


<?php include ("connect.php");//use connection.php connect database
$sql="SELECT OrderList.OrderID, OrderList.Res_ID, Restaurant.Res_Branch_Name, Approve.Date_Time FROM OrderList, Approve, Restaurant WHERE Approve.OrderID=OrderList.OrderID AND Approve.ApprovingStatus='APPROVE'  ORDER BY OrderID ASC;";//according orderid sort from small to large, and display restaurant name which approve status is "approve", then show the approve confirm time
echo "<table>";//display databse use table style
echo "<tr>
<th>ConfirmTime</th>
<th>ResName</th>
</tr>";//display text "ConfirmTime" and "ResName"
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{		
		echo "<tr><td>" . $row["Date_Time"]. "</td><td>" . $row["Res_Branch_Name"]. "</td></tr>";
	}//display time and restaurant name with datasbase
}
else
{
echo "<tr><td>0 results</td></tr>";//if database is empty, will display "0 results"
}
echo "</table>";//close table bolder
?>