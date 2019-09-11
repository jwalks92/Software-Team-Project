<head>
    <meta charset="utf-8">
    <title> CLUK Warehouse </title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
</head>

<?php include ("connect.php");//use connect.php connect database
session_start();
$sql="SELECT WarehouseInstock.ItemID, WarehouseFood.WF_Name, WarehouseFood.WF_ID, WarehouseInstock.Number_of_Unit FROM WarehouseInstock LEFT JOIN WarehouseFood ON WarehouseInstock.ItemID=WarehouseFood.WF_ID ORDER BY ItemID DESC;";//sql statement to display between warehousefood table and warehouseInstock table information
echo "<table>"; //display databse use table style
$result=$conn->query($sql);
if($result->num_rows>0)
{
	
	echo "<tr><td>FoodName</td><td>NumberOfUnit</td></tr>"; //display FoodName and NumberOfUnit
	while($row=$result->fetch_assoc())
	{		
		
		if ($row["Number_of_Unit"]<100)//judge the number of "Number_of_Unit", if less than 100 display "Lack"
		{
			echo "<tr><td>".$row["WF_Name"]. "</td><td>" . $row["Number_of_Unit"]."(LACK)". "</td></tr>";
			
		}
		else{////judge the number of "Number_of_Unit", if more than 100 
			echo "<tr><td>".$row["WF_Name"]. "</td><td>" . $row["Number_of_Unit"]. "</td></tr>";
		}
	}
}
else
{
echo "<tr><td>0 results</td></tr>";//if database is empty, will display "0 results"
}
echo "</table>";//close table bolder
?>
      