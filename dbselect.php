<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /><!--import ManageCSS.css file-->
<title>dbselect.php</title>
</head>
<body>
     <div class="navbar"><!--navbar on the top of website-->
      <a href="Homepage.html"><img src="img/logo.jpg" class="navbar__logo" alt="CLUK Logo"></a>
    <input type="checkbox" id="navbar__hamburger" class="navbar__hamburger">
	<label for="navbar__hamburger" class="navbar__hamburger__label">
	<span>|||</span>
	</label>
	<nav class="sidebar"><!--navbar on the left of website-->
	<ul>
      <li><a href="Homepage.html" class="sidebar__menu">Home</a></li>
      <li><a href="Deliveries.html" class="sidebar__stock">Deliveries</a></li>
        <li><a href="Dashboard.html" class="sidebar__received">Dashboard</a></li>
        <li> <a href="Inventories.html" class="sidebar__completed">Inventories</a></li>
        <li> <a href="date.php" class="sidebar__track">Track</a>
	  <li><a href="Manage.php" class="sidebar__about">Manage Staff</a></li>
	  <li><a href="about.html" class="sidebar__about">About</a></li>
	  <li><a href="logOut.php" class="sidebar__logout">Log Out</a></li>
	  
	  </ul>
    </nav>
	</div>
    <main>
<h2>WarehouseFood Table：</h2>

<?php include ("connect.php");
session_start();//connect to the database
$sql="SELECT WF_ID, WF_Name, WF_Amount_Per_Unit, WF_Quanity_Name_Per_Unit , WF_Price_Per_Unit FROM WarehouseFood;";
echo "<table>";
$total;
$result=$conn->query("SELECT COUNT(*) AS total FROM WarehouseFood");//Select the warehouseFood and ready to print below.
list($row_num)=$result->fetch_row();
while($row=mysqli_fetch_row($result))
{
	$total=$row["total"];
}
$result=$conn->query($sql);
if($result->num_rows>0)
{
echo"<tr><td>ID </td><td>Name </td><td>Amount </td><td>QuanityName </td><td>Price(&pound;) </td></tr>";
	while($row=$result->fetch_assoc())
	{		
		//Print the each row in WarehouseFood database
		echo "<tr><td>".$row["WF_ID"]. "</td><td>" . $row["WF_Name"]. "</td><td>" . $row["WF_Amount_Per_Unit"]. "</td><td>" . $row["WF_Quanity_Name_Per_Unit"]. "</td><td>" . $row["WF_Price_Per_Unit"]. "</td></tr>";
	}
}
else
{
echo "<tr><td>0 results</td></tr>";
}
echo "</table>";
?>
</table>
<br /> 
<!--The following are three forms-->
Insert data：<!--Insert data to database-->
<form action="dbinsert.php" method="get">
ID:<input type="text" name="WF_ID" /><br><br><!--Give the input box to user to input, the same below -->
Name:<input type="text" name="WF_Name" /><br><br>
Amount:<input type="text" name="WF_Amount_Per_Unit" /><br><br>
QuanityName:<input type="text" name="WF_Quanity_Name_Per_Unit" /><br><br>
Price:<input type="text" name="WF_Price_Per_Unit" /><br><br>
<input type="submit" value="Confirm" /><br><br><!--Cofirm button-->
<input type="reset" value="Reset" /><br><br>
</form> <br>
Modify data：<!--Modify data in database-->
<form action="dbupdate.php" method="get"><br>
ID:<input type="text" name="WF_ID" /><br><br><!--Give the input box to user to input -->
<select name="rowname"><br><!--Give the input box to user to choose -->
<option value="WF_Name">Name</option><br>
<option value="WF_Amount_Per_Unit">Amount</option><br>
<option value="WF_Quanity_Name_Per_Unit">QuanityName</option><br>
<option value="WF_Price_Per_Unit">Price</option><br>
</select>
<br><br>
<input type="text" name="rowtext" /><br><br><!--Give the input box to user to input -->
<input type="submit" value="Confirm" /><br><br>
<input type="reset" value="Reset"  /><br><br>
</form> 
Delete data:<!--Delete data from database-->
<form action="dbdelete.php" method="get"><br>
ID:<input type="text" name="WF_ID" /><br><!--Give the input box to user to input -->
<input type="submit" value="Confirm" /><br><br>
<input type="reset" value="Reset"  /><br><br>
</form>
    </main>
</body>
</html>