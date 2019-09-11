<!DOCTYPE html>
<html>
<head>
<title>Pending orders</title>
<style>
table,tr,td{
/*
	border: 1px solid black;
	border-collapse: collapse;
	background-color: white;
	color: black;
*/
}
</style>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
</head>
<body>

<div class="navbar">
      
	  <!--navigation bar-->
	  <a href="menu.php"><img src="img/logo.jpg" class="navbar__logo" alt="CLUK Logo"></a>
    <input type="checkbox" id="navbar__hamburger" class="navbar__hamburger">
	<label for="navbar__hamburger" class="navbar__hamburger__label">
	<span>|||</span>
	</label>
	<nav class="sidebar">
	<ul>
      <li><a href="menu.php" class="sidebar__menu">Menu</a></li>
      <li><a href="displayResStock.php" class="sidebar__stock">Stock</a></li>
      <li><a href="ordersToWarehouse.php" class="sidebar__update">Stock Update</a></li>
	  <li><a href="Work1.php" class="sidebar__orders">Orders</a></li>
	  <li><a href="Manage.php" class="sidebar__about">Manage Staff</a></li>
	  <li><a href="about-r.html" class="sidebar__about">About</a></li>
	  <li><a href="logOut.php" class="sidebar__logout">Log Out</a></li>
	  
	  </ul>
    </nav>
	</div>
    <main>
        <div class="content">
            <h1>Order Receipts</h1>
        </div>
		
		<table>
		<tr>
		<th>Order ID</th>
		<th>Requested order date</th>
		<th>Ingredient</th>
		<th>Unit</th>
		<th>Order status</th>
		<th>Add to stock</th>
		</tr>
		

<?php include ("connect.php");
session_start();

//finds the branch name the use works in
   $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
	
				$place=$row['branch'];
			}
		}
//creates a table of orders the restautant has made. Information includes the orderID, when they have requested the order to be delivered by, what food they have 
//ordered, whether the warehouse has accepted the order and the option to add the stock once it has been delivered
//Optional delivery statuses are APPROVED, REQUEST and DELIVERED. DELIVERED are not shown as this table only shows pending requests.
	
$sql="select s.OrderID, s.Order_Date AS 'Requested order date', f.WF_Name AS 'Ingredient', n.Unit, a.ApprovingStatus AS 'Order status' from OrderList s, Restaurant r, OrderLine n, WarehouseFood f, Approve a where s.Res_ID=r.Res_ID and r.Res_Branch_Name='".$place."' and n.Food_Item_ID=f.WF_ID and n.OrderID=s.OrderID and a.OrderID=n.OrderID and not ApprovingStatus='DELIVERED'";
$result=$conn->query($sql);
if($result->num_rows>0){
	while($rows=$result->fetch_assoc())
	{
		$oID=$rows['OrderID'];
		$orderDate=$rows['Requested order date'];
		$ingredient=$rows['Ingredient'];
		$unit=$rows['Unit'];
		$status=$rows['Order status'];
		
		
		//Only gives the hyperlink to add stock to those with an approval status of APPROVE
		if($status=='APPROVE')
		{
			$link="p><a href='newStock.php?OrderID=$oID'";
		}
		else{
			$link="p";
		}
		
		echo "<tr><td>$oID</td><td>$orderDate</td><td>$ingredient</td><td>$unit</td><td>$status</td>
			<td><$link>Update</td></tr>";
		
	}
}
else
{
	echo "<tr><td>0 results</td></tr>";
}
?>