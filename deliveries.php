<?php include ("connect.php");
session_start();
$sql="SELECT Date, OrderID, DriverID, Departure_Time, Arrival_Time FROM Delivery;";
echo "<table>";
$result=$conn->query($sql);
if($result->num_rows>0)
{
echo"<tr><td>Date </td><td>OrderID </td><td>DriverID </td><td>Departure_Time </td><td>Arrival_Time </td></tr>";
	while($row=$result->fetch_assoc())
	{		
		echo "<tr><td>".$row["Date"]. "</td><td>".$row["OrderID"]. "</td><td>" . $row["DriverID"]. "</td><td>" . $row["Departure_Time"]. "</td><td>" . $row["Arrival_Time"]. "</td></tr>";
	}
}
else
{
echo "<tr><td>0 results</td></tr>";
}
echo "</table>";
?>