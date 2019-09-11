<?php include ("connect.php");
session_start();
?>
<!DOCTYPE html>

<html>
    
    <head>
    <Title>Receipt</Title>
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
    
    </head>
<body>

<!--navigation bar -->
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
    <main></main>

<?php
 
 //Calculates how much the customer owes
 $paymentDue = "select sum(Total) from Store";
	
		$result2=$conn->query($paymentDue);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$money=$row['sum(Total)'];
				$superTotal=number_format((float)$money, 2, '.', '');
			}
		}
 
 //Takes information from the previous page about what the customer has paid
 $cash=$_POST["cashInput"]; 
 
 //calculates how much change is given to the cutsomer
$change=$cash-$superTotal;
 echo "You owe the customer &pound".$change."."; 
 
 /******************************************************************************************************/
 //finds todays date, is used to populate receipt tables
 $now=date('Y-m-d H:i:s');
 
 //uses the users data to find out which restaurant the food has been sold from

 $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
	
				$place=$row['branch'];
			}
		}
 
 
 

 //Takes the information from the database table Store about which food is has been ordered. It checks through every item in the menu.
 $sqlCheck = "SELECT S.Name, S.Ammount FROM csc8005_team03.Store S";
    
    $resultSet=$conn->query($sqlCheck);
if($resultSet->num_rows>0){
    
    while($rows=$resultSet->fetch_assoc())
	{
		$food=$rows['Name'];
		$quantity=$rows['Ammount'];

		//generates a receipt id by adding one to the greatest value receiptID currently in the database
		
			$aQuery="select max(ReceiptID) AS aID from ReceiptLine";
	$resultAQ=$conn->query($aQuery);
		
		if($resultAQ->num_rows>0)
		{
			while($row=$resultAQ->fetch_assoc())
			{
				$bigID=$row['aID'];
			}
		}
		else{echo "0 results";}
		
		$recID=$bigID+1;
	
	        
		/********************************************* 3 Pieces of Southern Fried Chicken ********************************/
		
		
		
		if($food=='3 Pieces of Southern Fried Chicken')
	{
		
		//finds use by date of the oldest usable stock in restaurant storage
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Pieces' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
	
				$earlyDate=$row['earlyDate'];
			}
		}
		
		//generates how much stock would be left if the stock used to create the food was removed from restaurant storage
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
		
	//updates restaurant storage with the new quantity of stock once the item has been sold.
			$sql="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValue." 
			WHERE w.WF_Name='Chicken Pieces' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
		
			if($conn->query($sql)===TRUE){
				echo " ";
			}
			
			else
			{
				echo "Error updating record: ".$conn->error;
			}
			
			//inserts data about the items sold into receipt list
			$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";//adds recipts
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		//inserts data into receiptline about the item sold
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='".$food."'), '".$quantity."')";//adds receipt
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
	}
	else{echo " ";}
	
	
	/**********************************3 Boneless Southern Fried Chicken Strips*********************************************************/
		//the prior functions were carried out for all items sold
	
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
		
		
		
		
			$sql="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValue." 
				WHERE w.WF_Name='Chicken Strips' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
				AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
			
			if($conn->query($sql)===TRUE){
				echo " ";
			}
			
			else
			{
				echo "Error updating record: ".$conn->error;
			}
			
			$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
			$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='3 Pieces of Southern Fried Chicken Strips'), '".$quantity."')";
				if($conn->query($recFood)===TRUE){
				echo " ";
			}
					
			else
			{
				echo "Error updating record: ".$conn->error;
			}
		
	}
	
	else{echo " ";}
		
		/******************cluk burger***********************************************************************************************/
		
		if($food=='CLUK Burger')
	{
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateA=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$fillet = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
	
		$result2=$conn->query($fillet);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueA=$row['newValue'];
			}
		}
		else{echo "0 results";}
						
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateB=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$bun = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
	
		$result2=$conn->query($bun);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueB=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateC=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$mayo = "SELECT s.Quantity-10*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
	
		$result2=$conn->query($mayo);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueC=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateD=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$lettuce = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
	
		$result2=$conn->query($lettuce);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueD=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		
		
		$sqlA="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueA." 
			WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
		
		if($conn->query($sqlA)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlB="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueB." 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
		
		if($conn->query($sqlB)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlC="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueC." 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
		
		if($conn->query($sqlC)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlD="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueD." 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
		
		if($conn->query($sqlD)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='".$food."'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		
		
	}
	
	/****super burger********************************************************/
		
		if($food=='S-Burger')
	{
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateA=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$fillet = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
	
		$result2=$conn->query($fillet);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueA=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateB=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$bun = "SELECT s.Quantity-1*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
	
		$result2=$conn->query($bun);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueB=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateC=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$mayo = "SELECT s.Quantity-10*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
	
		$result2=$conn->query($mayo);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueC=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$newDate="SELECT MIN(s.Date) AS 'earlyDate' FROM RestaurantStorage s, WarehouseFood w, Restaurant r WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID 
			AND s.BranchID=r.Res_ID AND r.Res_Branch_Name='".$place."'";
		
		$result1=$conn->query($newDate);
		
		if($result1->num_rows>0)
		{
			while($row=$result1->fetch_assoc()){
				$earlyDateD=$row['earlyDate'];
			}
		}
		else{echo "0 results";}
		
		$lettuce = "SELECT s.Quantity-5*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
	
		$result2=$conn->query($lettuce);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValueD=$row['newValue'];
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
		
		
	
		$sqlA="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueA." 
			WHERE w.WF_Name='Chicken Breast Fillets' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
		
		if($conn->query($sqlA)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
	$sqlB="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueB." 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
		
		if($conn->query($sqlB)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
	
	$sqlC="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueC." 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
		
		if($conn->query($sqlC)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlD="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueD." 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
		
		if($conn->query($sqlD)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlE="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueE." 
			WHERE w.WF_Name='Hash Browns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateE."'";
		
		if($conn->query($sqlE)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlF="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueF." 
			WHERE w.WF_Name='Cheese slices' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateF."'";
		
		if($conn->query($sqlF)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='CLUK Super Burger'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
	}
	
	else {echo "";}	
		
		/****veg strips**************************************************************************/
		
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
		
		
		
		$sql="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValue." 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried Strips' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
		
		if($conn->query($sql)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='3 Vegetarian Southern Fried Strips'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		
	}
	
	else{echo " ";}
		
		/*******veg-burger*****************************************************************************/
		
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
				$newValueD=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		
		$sqlA="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueA." 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
		
		if($conn->query($sqlA)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
	$sqlB="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueB." 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
		
		if($conn->query($sqlB)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlC="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueC." 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
		
		if($conn->query($sqlC)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$sqlD="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueD." 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
		
		if($conn->query($sqlD)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='CLUK Vegetarian Burger'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		
	}
	
	}
	
	else {echo " ";}
		
		
		/********veg super burger***********************************************************************/
		
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
				$newValueD=$row['newValue'];
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
		
			
		$sqlA="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueA." 
			WHERE w.WF_Name='Sesame seed buns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateA."'";
		
		if($conn->query($sqlA)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}		
		
	$sqlB="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueB." 
			WHERE w.WF_Name='Mayonnaise' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateB."'";
		
		if($conn->query($sqlB)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
	
		$sqlC="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueC." 
			WHERE w.WF_Name='Shredded iceberg lettuce' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateC."'";
		
		if($conn->query($sqlC)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
	$sqlD="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueD." 
			WHERE w.WF_Name='Mycoprotein based meat substitute Southern fried burgur' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateD."'";
		
		if($conn->query($sqlD)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
	$sqlE="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueE." 
			WHERE w.WF_Name='Hash Browns' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateE."'";
		
		if($conn->query($sqlE)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
	
	$sqlF="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValueF." 
			WHERE w.WF_Name='Cheese slices' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDateF."'";
		
		if($conn->query($sqlF)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='CLUK Vegetarian Super Burger'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
	}
	
	
	else {echo " ";}
		
	/*******fries****************************************************************/
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
		else{echo "0 results";}
		
		$sql="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValue." 
			WHERE w.WF_Name='Uncooked French Fries' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
		
		if($conn->query($sql)===TRUE){
			echo " ";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='".$food."'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
	
	}
	else{echo " ";}
	
		
		
	/*****cola*************************************************************************************************************/	
		
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
		else{echo "0 results";}
		
		$cola = "SELECT s.Quantity-50*".$quantity." AS 'newValue' FROM RestaurantStorage s, WarehouseFood w, Restaurant r 
			WHERE w.WF_Name='Cola syrup' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
	
		$result2=$conn->query($cola);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$newValue=$row['newValue'];
			}
		}
		else{echo "0 results";}
		
		$sql="UPDATE RestaurantStorage s, WarehouseFood w, Restaurant r SET s.Quantity=".$newValue." 
			WHERE w.WF_Name='Cola syrup' AND w.WF_ID=s.ItemID AND s.BranchID=r.Res_ID 
			AND r.Res_Branch_Name='".$place."' AND s.Date='".$earlyDate."'";
		
		if($conn->query($sql)===TRUE){
			echo "Record updated successfully";
		}
		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recBranch="INSERT INTO ReceiptList(ReceiptID, Branch_ID, Date) values('".$recID."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'), '".$now."')";
			if($conn->query($recBranch)===TRUE){
			echo "Record updated successfully; ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		$recFood="INSERT INTO ReceiptLine(ReceiptID, MenuID, Unit) values('".$recID."',(SELECT RF_ID FROM RestaurantFood WHERE RF_Name='Cola'), '".$quantity."')";
			if($conn->query($recFood)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		
		
	}
	else{echo " ";}
		
		
	}
	}
 
    $conn->close();
    ?>
	
	  <form action="menu.php">
		<input type="submit" value="Submit">
		<form>
		
	</form>
	
	</main>
	
</body>
</html>
