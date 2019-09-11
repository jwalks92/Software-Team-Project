<?php 
   	include("connect.php");
	session_start();
 
 //gets the place to provide the data for from login information
	   $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
	
				$place=$row['branch'];
			}
		}
		
 
 /*************************************************************************************/
 
 //takes information from newStock.php to add to the database
	$updateId = filter_input(INPUT_POST, 'ID');
    $updateName = filter_input(INPUT_POST, 'name');
    $updateUnit = filter_input(INPUT_POST, 'unit');
	$useByDate= filter_input(INPUT_POST, 'useByDate');
	
	
	/*******************************************************************************/
	
	//genetates a new stock id for restaurant storage by taking the greatest id in restaurant storage and adding 1
	
	$aQuery="select max(AutoIncrementID) AS aID from RestaurantStorage";
	$resultAQ=$conn->query($aQuery);
		
		if($resultAQ->num_rows>0)
		{
			while($row=$resultAQ->fetch_assoc())
			{
				$bigID=$row['aID'];
			}
		}
		else{echo "0 results";}
		
		$newID=$bigID+1;
		
		
		
	//finds the branch id  for the place the user works
	
	$bQuery="select Res_ID from Restaurant where Res_Branch_Name='".$place."'";
	
	$resultBQ=$conn->query($bQuery);
		
		if($resultBQ->num_rows>0)
		{
			while($row=$resultBQ->fetch_assoc())
			{
				$resID=$row['Res_ID'];
			}
		}
		else{echo "0 results";}
				
		
		
	
	
	//finds the item id of the food they are adding
	
		$fQuery="select WF_ID from WarehouseFood where WF_Name='".$updateName."'";
		
		$resultFQ=$conn->query($fQuery);
		
		if($resultFQ->num_rows>0)
		{
			while($row=$resultFQ->fetch_assoc())
			{
				$foodID=$row['WF_ID'];
			}
		}
		else{echo "0 results";}
				
	
		
		
	//converts units to quamntity based on how much there is per unit delivered
	
		$qQuery="select WF_Amount_Per_Unit * ".$updateUnit." AS unity from WarehouseFood where WF_Name='".$updateName."'";
		
		$resultQQ=$conn->query($qQuery);
		
			if($resultQQ->num_rows>0)
		{
			while($row=$resultQQ->fetch_assoc())
			{
				$finalQuanity=$row['unity'];
			}
		}
		else{echo "0 results";}
				
		
	
	//inserts the stock into restaurant storgae based on the previous data
	
	$updateStock="INSERT INTO RestaurantStorage (AutoIncrementID, BranchID, Date, ItemID, Quantity) VALUES (".$newID.", ".$resID.", '".$useByDate."', ".$foodID.", ".$finalQuanity.")";
	if($conn->query($updateStock)===TRUE){
			echo "Record updated successfully; ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
		
		
		//updates Approve table to let the warehouse know that the order has been delivered.
	
	$updateApprove="update Approve set ApprovingStatus='DELIVERED' where OrderID=$updateId";
	
		if($conn->query($updateApprove)===TRUE){
			echo "Record updated successfully; ";
		}
				
		else
		{
			echo "Error updating record: ".$conn->error;
		}
	
	$conn->close();
		
    header("Location:ordersToWarehouse.php");
	?>
