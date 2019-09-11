<html>
<head>
    <meta charset="utf-8">
    <title>Add restaurant stock</title>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
	<script src="JavaScript.js"></script>
    <style>
        table, th, td 
        {           
            border: 1px solid black;
            border-collapse: collapse;
            background-color: white;
            color: black;
            padding: 10px;
        }
    </style>
</head>
<body>

	<!--navbar-->
    <nav class="navbar">
     
        <a href="about.html" class="navbar__about">About</a>
       
        
        <a href="menu.php"><img src="img/logo.jpg" class="navbar__logo" alt="CLUK logo"></a>
    </nav>
    <nav class="sidebar">
        <a href="menu.php" class="sidebar__menu">Menu</a>
        <a href="ordersToWarehouse.php" class="sidebar__receipt">Update stock</a>
        <a href="displayResStock.php" class="sidebar__stock">Show stock</a>
        <a href="orders.html" class="sidebar__orders">Create orders</a>
    </nav>
    <main>




<?php 
	
	include("connect.php");
	session_start();
			
			
//finds the which restaurant the information should be generated for based on the username 			
			   $username=$_SESSION['username'];
	$placeql="SELECT r.Res_Branch_Name AS branch FROM Staff s, Restaurant r WHERE s.BranchID=r.Res_ID AND s.ID='".$username."'";
	
	$result=$conn->query($placeql);
		
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
	
				$place=$row['branch'];
			}
		}
		
			
//Generates the information about the food the user wants to add to the system			
			if(!empty($_GET['OrderID']))
			{
				
				$getid = $_GET['OrderID'];
			
				
				$selectid = "select s.OrderID, f.WF_Name AS 'Ingredient', n.Unit from OrderList s, Restaurant r, OrderLine n, WarehouseFood f, 
				Approve a where s.Res_ID=r.Res_ID and r.Res_Branch_Name='".$place."' and n.Food_Item_ID=f.WF_ID and n.OrderID=s.OrderID and 
				a.OrderID=n.OrderID and not ApprovingStatus='DELIVERED' and s.OrderID=$getid";
		
				$result = $conn->query($selectid);
        
				while ($row = $result->fetch_assoc()) 
				{
					$id = $row["OrderID"];              
					$name = $row['Ingredient'];
					$unit = $row['Unit'];             
				}
			}
			
		
    
    ?>
	<!-- Creates a form which holds the information about the food which needs to be added to the system. The id, name and quantity cannot be changed. 
			The user will submit the use by date of the delivered food. -->
	<div class = "content__form">
        <h1>Add stock</h1>
        <form method="post" action="newStockServer.php">
		ID: <em> *You cannot change ID, ingredient and input</em><br>
		<input type = "text" name="ID" readonly value = "<?php echo $id?>"><br><br>
        Ingredient:<br>
        <input required type = "text" name="name" readonly value = "<?php echo $name?>"><br><br>
        Unit:<br>
        <input type = "text" name="unit" readonly value = "<?php echo $unit?>"><br><br>
        <br>      
		Use by date:<br>
		<input required type="date" name="useByDate">
		
		
        <em>Please check your information carefully before submitting the form</em>
        <br>
        <br>
        <input type = "submit" value = "Submit">
		
    </form> 
	
	<?php
	
	$conn->close();
	?>
	
    </main>
</body>
</html>
