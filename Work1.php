<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/work.css" />
     <script type="text/javascript" src="Work1.js"></script>
<title> Ordering Page</title>
    
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    
    <script>
        
    var firstArray = [];
    var lastArray = [];
        
// first array and last array were used accordingly and will be discussed in the linked JS file.  
        </script>
    
     
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
        <section class="order-system">
           <?php 
        include ("connect.php"); 
        
session_start();
    // deletes infomation from test to that array orders are deleted after all use so customer orders are not interlaved with one another. 
	$delete="delete from Test";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}

	// takes all relevant information and stores into html table. 
            
    $sql="SELECT w.WF_ID AS 'ID', w.WF_Name AS 'Ingredient', w.WF_Amount_Per_Unit AS 'Unit' FROM csc8005_team03.WarehouseFood w";
    
    $resultSet=$conn->query($sql);
    ?>
    <h1> Ordering System</h1>
    <p>Please select a date of delivery:<input type="date" name="date" id="date"></p>

        <table id="table">
	
		<tr>
            <th>ID</th>
			<th>Ingredients</th>
			<th>Quantity Per Unit</th>
			<th>Unit Number</th>
            <th>Confirm</th>
		</tr>
        
        <?php if($resultSet->num_rows>0){ while ($rows=$resultSet->fetch_assoc()) { 
        
        $id=$rows['ID'];
        $ingredients=$rows['Ingredient'];
		$quantity=$rows['Unit'];
        
        ?>
        <tr>
			<td><?php echo $id; ?></td>
			<td class="table-ingrd"><?php echo $ingredients; ?></td>
            <td class="table-quantity"><?php echo $quantity; ?></td>
            <!--below uses integrated PHP functioanlity to take ID for each food type. -->
            <td><input type = "number" min="0" step="1" placeholder="0" value="0" name="number" class="number" id="inputField<?php echo $id; ?>" ></td>
            <td> <button type ="button" class="button" onclick="confirm(this)">Confirm</button></td>
			<td>
           
		</tr>
        <?php } }?>
  
    </table>
        
        <table id ="list">
            
        <tbody>
        </tbody>
            
    </table>
	
	<table id ="editing">
	
        <tbody>
        </tbody>
            
    </table>
	<!--necessary to make each input type equal readable only so that the user cannot input or manipulate date -->
         <p> ID <input type="text" readonly = "readonly" id="id"/> </p>
        <p> IngredientName: <input type="text" readonly = "readonly" id="name"/> </p>
        <p> Units: <input type="text"  id="units"/> </p>
	    <button type ="button" class="button" onclick="changeInformation()">Edit Units</button>
		<p></p>
	
		
	
          
<form method="post" class="order-submit" onSubmit="return sendToServerWithAjax()" action="WorkVault.php">
     <p></p>
    <input type="submit" value="Submit"> 
   
</form>

<div id="tableArea"></div>
        
        </section>

</body>
</html>
