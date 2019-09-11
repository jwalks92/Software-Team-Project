<!DOCTYPE html>
<html>
<head>
<title>Stock</title>
    <meta charset="utf-8">
    <title>Receipt</title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />

    
</head>
<body>
<!--navbar-->
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
	  <li><a href="logOut.html" class="sidebar__logout">Log Out</a></li>
	  
	  </ul>
    </nav>
	</div>
<main>

<!-- styles the table which holds infomration about the order -->
<table>
<tr>
<th>Name</th>
<th>Price</th>
<th>Ammount</th>
    <th>Total</th>
</tr>
    
 
<?php
    
    include ("connect.php");
session_start();
    error_reporting(0);
    
	//gets the array of orders from menu.php

  $array = json_decode($_POST['menu'],true);
   
   //gets the branch the order was made in
    $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
	
				$place=$row['branch'];
			}
		}
   
  
   
   
//adds information from the array to a table in the database called stock    
    for ($index=0;$index<count($array);$index++)
   {
     $name = $array[$index]['name'];
     $price = $array[$index]['price'];
     $ammount = $array[$index]['ammount'];
     $total =$array[$index]['total'];
     $floatPrice = (double)$price;
     $floatAmmount = (double)$ammount;
     $floatTotal = (double)$total;
        
         $ajax =  "INSERT INTO Store (Name,Price, Ammount, Total) Values('$name','$floatPrice', '$floatAmmount', '$floatTotal')";
    
if($conn->query($ajax)===TRUE){
			echo "Record updated successfully ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
    
   }
    

	//This checks that there is enough stock to make the item. If there is not, it is deleted from the table.
	//It does this for every item.
	
	$sqlCheck = "SELECT S.Name, S.Price, S.Ammount, S.Total
 FROM csc8005_team03.Store S";
    
    $resultSet=$conn->query($sqlCheck);
if($resultSet->num_rows>0){
    
    while($rows=$resultSet->fetch_assoc())
	{
		$food=$rows['Name'];
		$price=$rows['Price'];
		$quantity=$rows['Ammount'];
        $total=$rows['Total'];
		
		/* 3 Boneless Southern Fried Chicken Strips ******************/
		
if($food=='3 Boneless Southern Fried Chicken Strips')
	{
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Strips' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDate=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$cStrip = "SELECT s.Quantity-3*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Chicken Strips' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
	
		$result2=$conn->query($cStrip);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
			
				$newValue=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		
		
		if(empty($newValue)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		
		
		if($newValue<0){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		}
		
		
	}
		
	/**3 pieces of southern fried chickern***********************************************************************/
if($food=='3 Pieces of Southern Fried Chicken')
	{
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Pieces' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
	
				$earlyDate=$row['earlyDate'];
			}
		}
		
		
		$cPiece = "SELECT s.Quantity-3*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Chicken Pieces' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
	
		$result2=$conn->query($cPiece);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValue=$row['newValue'];
			}
		}
		
		
		if(empty($newValue)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		
		if($newValue<0){
	
		
			
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		}
		
		
	}
	
	/*************************************************************************/
		if($food=='CLUK Burger')
		{				
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateA=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$bun = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
	
		$result2=$conn->query($bun);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueA=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateB=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$mayo = "SELECT s.Quantity-10*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
	
		$result2=$conn->query($mayo);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueB=$row['newValue'];
			}
		}
		else{echo "0 results";}
			
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateC=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$lettuce = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
	
		$result2=$conn->query($lettuce);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueC=$row['newValue'];
			}
			
		}
		else{echo "0 results";}
		
			$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateD=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$vBurger = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
	
		$result2=$conn->query($vBurger);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$valueD=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
	
		
		//LOOK HERE
		
		if(empty($newValueA)||empty($newValueB)||empty($newValueC)||empty($valueD)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		
		
		if($newValueA<0||$newValueB<0||$newValueC<0||$valueD<0){
				
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
		}
		
		
	/*cluk super burger***************************************************************/
	if($food=='S-Burger')
	{				
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateA=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$bun = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
	
		$result2=$conn->query($bun);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueA=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateB=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$mayo = "SELECT s.Quantity-10*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
	
		$result2=$conn->query($mayo);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueB=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateC=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$lettuce = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
	
		$result2=$conn->query($lettuce);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueC=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
			$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateD=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$vBurger = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
	
		$result2=$conn->query($vBurger);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$valueD=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
		WHERE w.WF_Name='Hash Browns' AND w.WF_ID=s.ItemID 
		AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateE=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$hb = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Hash Browns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateE."'";
	
		$result2=$conn->query($hb);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueE=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
	$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
		WHERE w.WF_Name='Cheese slices' AND w.WF_ID=s.ItemID 
		AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateF=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$cheese = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Cheese slices' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateF."'";
	
		$result2=$conn->query($cheese);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueF=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		if(empty($newValueA)||empty($newValueB)||empty($newValueC)||empty($valueD)||empty($newValueE)||empty($newValueF)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		
		if($newValueA<0||$newValueB<0||$newValueC<0||$valueD<0||$newValueE<0||$newValueF<0){
	
		
			
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
			
	} 
/***3 vegetarian southern fried strips *********************************************************/
if($food=='Veg-Strips')
	{
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried Strips' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDate=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$vStrip = "SELECT s.Quantity-3*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried Strips' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
	
		$result2=$conn->query($vStrip);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValue=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		if(empty($newValue)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		if($newValue<0){
	
		
			
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
		
	}
/***veg burger************************************************************/
if($food=='Veg-Burger')
		{				
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateA=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$bun = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
	
		$result2=$conn->query($bun);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueA=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateB=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$mayo = "SELECT s.Quantity-10*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
	
		$result2=$conn->query($mayo);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueB=$row['newValue'];
			}
		}
		else{echo "0 results";}
			
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateC=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$lettuce = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
	
		$result2=$conn->query($lettuce);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueC=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
			$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateD=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$vBurger = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
	
		$result2=$conn->query($vBurger);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$valueD=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		if(empty($newValueA)||empty($newValueB)||empty($newValueC)||empty($valueD)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		
		if($newValueA<0||$newValueB<0||$newValueC<0||$valueD<0){
				
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
		}
		
		/***vegetarian super burger****************************************************/
		if($food=='Veg-S-Burger')
	{				
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateA=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$bun = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
	
		$result2=$conn->query($bun);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueA=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateB=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$mayo = "SELECT s.Quantity-10*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
	
		$result2=$conn->query($mayo);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueB=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateC=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$lettuce = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
	
		$result2=$conn->query($lettuce);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueC=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
			$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateD=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$vBurger = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
	
		$result2=$conn->query($vBurger);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$valueD=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
		WHERE w.WF_Name='Hash Browns' AND w.WF_ID=s.ItemID 
		AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateE=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$hb = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Hash Browns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateE."'";
	
		$result2=$conn->query($hb);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueE=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
	$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
		WHERE w.WF_Name='Cheese slices' AND w.WF_ID=s.ItemID 
		AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateF=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$cheese = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Cheese slices' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateF."'";
	
		$result2=$conn->query($cheese);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueF=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		if(empty($newValueA)||empty($newValueB)||empty($newValueC)||empty($valueD)||empty($newValueE)||empty($newValueF)){
	
			$delete="delete from Store where Name='".$food."'";
	
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		
		if($newValueA<0||$newValueB<0||$newValueC<0||$valueD<0||$newValueE<0||$newValueF<0){
	
		
			
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
			
	}
	/**************************************************************/
	if($food=='Fries')
	{
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Uncooked French Fries' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
	
				$earlyDate=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$fries = "SELECT s.Quantity-120*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Uncooked French Fries' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
	
		$result2=$conn->query($fries);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValue=$row['newValue'];
			}
		}
		//else{echo "0 results";}
		
		if(empty($newValue)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		if($newValue<0){
		
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
	}
	/*Cola*********************************************************/
	if($food=='Cola')
	{
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Cola syrup' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
	
				$earlyDate=$row['earlyDate'];
			}
		}
	//	else{echo "0 results";}
		
		$coke = "SELECT s.Quantity-120*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Cola syrup' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
	
		$result2=$conn->query($coke);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValue=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		if(empty($newValue)){
	
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
		}
		if($newValue<0){
		
			$delete="delete from Store where Name='".$food."'";
			
			if($conn->query($delete)===TRUE){
			echo "";
		}
		
		else{
			echo "Error updating record: ".$conn->error;
		}
		}
	}
	
	
		
		

		
		}
    }
	
	
	//echoes the final information in store which the customer can purchase
	
$sql = "SELECT S.Name, S.Price, S.Ammount, S.Total
 FROM csc8005_team03.Store S";
    
    $resultSet=$conn->query($sql);
if($resultSet->num_rows>0){
    
    while($rows=$resultSet->fetch_assoc())
	{
		$row1=$rows['Name'];
		$row2=$rows['Price'];
		$row3=$rows['Ammount'];
        $row4=$rows['Total'];
		
		echo "<tr><td>$row1</td><td>$row2</td><td>$row3</td><td>$row4</td></tr>";
		
			}
			
			
			//if the customer is happy with the order they can submit, if they are not happy with the order 
			//(there is not enough stock), they can go back and chnage there order. The database and array are cleared on the previous page. 
			
			?><form action="payment.php">
		<input type="submit" value="Submit">
		 <input type="button" value="Go back!" onclick="history.back()">
		
		
	</form><?php
			
			
			
			
			
    }

	//if there is no stock, there is no submit button.
	
	else
{
	echo "<tr><td>0 results</td></tr>";
	
	?><form>
		
		 <input type="button" value="Go back!" onclick="history.back()">
		
		
	</form><?php
	
	
}
    
 
    $conn->close();
    ?>
	
	
	
	
	
	
	
    </table>
    
	<!--Converts the array list from a php object to a javascript object-->
     <script>
var obj = JSON.parse('<?php echo json_encode($dataInfo) ?>');
</script>
    
    </main>
    </body>
</html>