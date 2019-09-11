<!DOCTYPE html>
<html>
<head>
<title>Stock</title>
    <meta charset="utf-8">
    
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
<style>
table,tr,td{
	border: 1px solid black;
	border-collapse: collapse;
	background-color: white;
	color: black;
}
</style>
</head>
<body>
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


<?php include("connect.php");
session_start();
    error_reporting(0);
//echo $array;
// decodes both the JSON strigified objects menu - the array lastArray and date. 
 $array = json_decode($_POST['menu'],true);
 $date = json_decode($_POST['date'],true);

    // takes the username that the person used in the login page and the following sql can be used to identify where they work
	
    $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
	
				$place=$row['branch'];
			}
		}
    // iterating loop for the array to create id, name and units columns for a table.  
    for ($index=0;$index<count($array);$index++)
   {
     $id = $array[$index]["IngredientID"];
     $name = $array[$index]["IngredientName"];
	 $unit = $array[$index]["UnitAmmount"];
	 
        $ajax =  "INSERT INTO Test (ID,Name,Unit,DeliveryDate) Values('$id','$name','$unit','$date')";
    
if($conn->query($ajax)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
   }   
  /*******************************************************************************************************************/
    // information is then placed into the database 
	$sqlCheck="SELECT * FROM Test";
	$resultSet=$conn->query($sqlCheck);
		
	if($resultSet->num_rows>0){
			
		while($rows=$resultSet->fetch_assoc())
		{
			$foodID=$rows['ID'];
			$uQuantity=$rows['Unit'];
			$dDay=$rows['DeliveryDate'];
   // checks order id for each food type 
				$aQuery="select max(OrderID) AS aID from OrderLine";
	$resultAQ=$conn->query($aQuery);
		
		if($resultAQ->num_rows>0)
		{
			while($row=$resultAQ->fetch_assoc())
			{
				$bigID=$row['aID'];
			}
		}
		else{echo "0 results";}
		//utilizes incrementing order id and then inserts the information from the associated javascript menu into the following tables.
		$ordID=$bigID+1;
		$ordBranch="INSERT INTO OrderList(OrderID, Order_Date, Res_ID) values('".$ordID."','".$dDay."',(SELECT Res_ID FROM Restaurant WHERE Res_Branch_Name='".$place."'))";
			
		if($conn->query($ordBranch)===TRUE){
			echo " ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
        
        //inserts the above into a food line. 
		
		$ordFood="INSERT INTO OrderLine(OrderID, Food_Item_ID, Unit) values(".$ordID.",'".$foodID."', '".$uQuantity."')";
		if($conn->query($ordFood)===TRUE){
			echo " ";
		}
		
        // if order id is applicable, order is approved and dealt with accoridngly.    
            
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		$approve="INSERT INTO Approve(OrderID, ApprovingStatus) VALUES(".$ordID.", 'REQUEST')";
		if($conn->query($approve)===TRUE){
			echo " ";
		}
		// utilizes error syntax to make user aware of any particular malfunctions. 		
		else
		{
			echo "Error updating record: ".$conn->error;
		}
   
   
		}
	}
   
$conn->close();
?>
<!-- if successful is token to the following page and offered opportunity to return, if succesful the above PHP is passed through -->
<form action="Work1.php">
    <p>Your order has successfully gone through.</p>
  <input type="submit" value="Back to ordering page">
</form> 
    </main>
</body>
</html>
