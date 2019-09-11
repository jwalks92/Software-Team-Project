<!DOCTYPE html>
<html>
<head>
<title>Order</title>

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
<div class="navbar"><!--the top style-->
      <a href="Homepage.html"><img src="img/logo.jpg" class="navbar__logo" alt="CLUK Logo"></a>
    <input type="checkbox" id="navbar__hamburger" class="navbar__hamburger">
	<label for="navbar__hamburger" class="navbar__hamburger__label">
	<span>|||</span>
	</label>
	<nav class="sidebar"><!--this sidebar on the left-->
	<ul>
      <li><a href="Homepage.html" class="sidebar__menu">Home</a></li>
      <li><a href="Deliveries.html" class="sidebar__stock">Deliveries</a></li>
        <li><a href="Dashboard.html" class="sidebar__received">Dashboard</a></li>
        <li> <a href="Inventories.html" class="sidebar__completed">Inventories</a></li>
        <li> <a href="track-driver.html" class="sidebar__track">Track</a> </li>
	  <li><a href="Manage.php" class="sidebar__about">Manage Staff</a></li>
	  <li><a href="about.html" class="sidebar__about">About</a></li>
        <li><a href="help.html" class="navbar__help">Help</a></li>
	  <li><a href="logout.html" class="sidebar__logout">Log Out</a></li>
	  
	  </ul>
    </nav>
	</div>
    
    <main>

<table><!--table the fist row display Restaurant,Food,Units,Date-->
<tr>
<th>Restaurant</th>
<th>Food</th>
<th>Units</th>
<th>Date</th>
</tr>

<?php include ("connect.php");//use connect.php connect database
session_start();
$sql="SELECT r.Res_Branch_Name, f.WF_Name, n.Unit, l.Order_Date FROM Restaurant r, OrderList l, WarehouseFood f, OrderLine n, Approve a WHERE r.Res_ID=l.Res_ID AND f.WF_ID=n.Food_Item_ID AND n.OrderID=l.OrderID AND l.OrderID=a.OrderID and a.ApprovingStatus='REQUEST'";//sql statement to display restaurant name which approve status is "request" and display warehouse food which they need
$result=$conn->query($sql);
if($result->num_rows>0){
	
	while($rows=$result->fetch_assoc())//while loop
	{
		$res=$rows['Res_Branch_Name'];
		$food=$rows['WF_Name'];
		$unit=$rows['Unit'];
		$order=$rows['Order_Date'];
		
		
		echo "<tr><td>$res</td><td>$food</td><td>$unit</td><td>$order</td></tr>";
		
		
	}//display restaurant name, warehouse food name, unit and order date in a table
}
else
{
	echo "<tr><td>0 results</td></tr>";//if database was empty, will display "0 results"
}
$conn->close();//close database
?>
</main>
</body>
</html>