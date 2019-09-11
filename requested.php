<head>
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /><!--import ManageCSS.css file-->
</head>


<?php include ("connect.php");//use connect.php connect database
$sql="SELECT OrderID, ApprovingStatus, Date_Time FROM Approve;";//display orderid, approve status and time from approve database
echo "<table>";//display databse use table style
echo "<tr>
            <th>OrderID</th>
			<th>ApprovingStatus</th>
			<th>Confirm_Time</th>
		</tr>";//display text "OrderID" and "ApprovingStatus" and "Confirm_Time"
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{		
		echo "<tr><td>".$row["OrderID"]. "</td><td>" . $row["ApprovingStatus"]. "</td><td>" . $row["Date_Time"]. "</td></tr>";
	}
}//display orderid and approve status and confirmation time from Approve database
else
{
echo "<tr><td>No Request Approved</td></tr>";//if database is empty, will display "No Request Approved"
}
echo "</table>";//close table bolder
?>