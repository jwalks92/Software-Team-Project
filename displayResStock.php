<!DOCTYPE html>
<html>
<head>
<title>Stock</title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />

</head>
<body>

<!--Navigation bar-->
 <div class="navbar">
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
            <h1>Restaurant Stock</h1>
            
            
        <h2>To Do:</h2>


<table>
<tr>
<th>ID</th>
<th>Ingredient</th>
<th>Quantity</th>
<th>Use by date</th>
<th>Delete</th>
</tr>

 

<?php include ("connect.php");
session_start();

//gets todays date, used for finding out whether the food is expired
$now=date('Y-m-d H:i:s');
$convertNow=strtotime($now);

//finds out the correct restaurant to get the stock of
   $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
				$place=$row['branch'];
			}
		}
    
   
        
        
//creates a table of the infomration of restaurant storage.
$sql="SELECT s.AutoIncrementID AS 'ID', w.WF_Name AS 'Ingredient', s.Quantity AS 'Quantity', s.Date AS 'Date' FROM WarehouseFood w, RestaurantStorage s, Restaurant r WHERE w.WF_ID=s.ItemID AND r.Res_Branch_Name='".$place."' AND r.Res_ID=s.BranchID";
$resultSet=$conn->query($sql);
if($resultSet->num_rows>0){
	
	while($rows=$resultSet->fetch_assoc())
	{
		$aiID=$rows['ID'];
		$ingredients=$rows['Ingredient'];
		$quantity=$rows['Quantity'];
		$date=$rows['Date'];
		
		//echoes the data in the table. Adds a columns to delete the stock. This is done in deleteResStock.php
		echo "<tr><td>$aiID</td><td>$ingredients</td><td>$quantity</td><td>$date</td>
		<td><a href='deleteResStock.php?AutoIncrementID=$aiID'>Delete</td>
		</tr>";
	}
}
else
{
	echo "<tr><td>0 results</td></tr>";
}


//searches through the list of all possible foods in the restaurant
//checks the use by date and quantity of each food
$query="SELECT WF_Name FROM WarehouseFood";
$resultSet=$conn->query($query);
if($resultSet->num_rows>0)
{
	while($row=$resultSet->fetch_assoc())
	{
		$food=$row['WF_Name'];
		//finds the use by date of the stock for the food	
		$Date="SELECT s.Date AS Date FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='".$food."' 
			AND w.WF_ID=s.ItemID AND r.Res_Branch_Name='".$place."' AND r.Res_ID=s.BranchID";
			
			$result=$conn->query($Date);
		
		if($result->num_rows>0)
		{
			while($row2=$result->fetch_assoc()){
	
				$DateFormat=$row2['Date'];
			}
		}
		
		//does nothing if there is no stock
		if(empty($DateFormat)){
			echo "";
		}
		
		else{
		//checks the difference between todays date and the stock. If the difference is negative, it needs to be thrown away
		$convert=strtotime($DateFormat);
	
		$Difference=$convert-$convertNow;	
		
		$Time=$Difference/(60*60*24);			
		
		$ID="SELECT s.AutoIncrementID FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='".$food."' 
			AND w.WF_ID=s.ItemID AND r.Res_Branch_Name='".$place."' AND r.Res_ID=s.BranchID";
		$result2=$conn->query($ID);
		
		if($result2->num_rows>0)
		{
			while($row3=$result2->fetch_assoc()){
	
				$IDformat=$row3['AutoIncrementID'];
			}
		}	
		
			if($Time<0)
			{	
				echo "<br>";
				echo "Throw ".$food." with the ID '".$IDformat."' away.";
				echo "<br>";
			}
			else
			{
				echo " ";
			}
		}
		
//tells you when you are low on stock	
//finds the quantity of each stock. It adds them together if there are several different deliveries of stock.	
		$quantity="SELECT sum(s.Quantity) as 'Quantity' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='".$food."' 
			AND w.WF_ID=s.ItemID AND r.Res_Branch_Name='".$place."' AND r.Res_ID=s.BranchID";
			
			$result=$conn->query($quantity);
		
		if($result->num_rows>0)
		{
			while($row2=$result->fetch_assoc()){
				$quantityFormat=$row2['Quantity'];
			}
		}
		
		//alerts to order more food if there is none
		if(empty($quantityFormat)){
			echo "<br>";
			echo "Order more $food";
			echo "<br>";
		}
		
		//alerts to order more food if there is less than 1 unit
		else{
		
		$unit="SELECT WF_Amount_Per_Unit FROM WarehouseFood WHERE WF_Name='".$food."'";
		
			$resultU=$conn->query($unit);
		
		if($resultU->num_rows>0)
		{
			while($row3=$resultU->fetch_assoc()){
	
				$unitFormat=$row3['WF_Amount_Per_Unit'];
			}
		}
		
		$quanDiff=$quantityFormat-$unitFormat;
		
		if($quanDiff<1)
		{
			echo "<br>";
			echo "Order more ".$food.".";
			echo "<br>";
			
		}
		}
		
	}
}
$conn->close();
?>
    
    </div>
            </main>
</body>
</html>
