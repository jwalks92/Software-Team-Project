<?php include 'connect.php';

//Make sure that the global variable for username can get to this page then set it as a local variable
if(isset($_POST ['username']))
{
  $_SESSION['username'] = filter_input(INPUT_POST, 'username');
  $getUser = $_SESSION['username'];
}
else 
{
  $getUser = $_SESSION['username'];
}
			
//A MySql statement to get user's workplace to limit user's navigation bar
$selectUserWorkplace = "SELECT Workplace FROM Staff WHERE ID = '$getUser'";		
$resultUserWorkplace = $conn->query($selectUserWorkplace);
			
if ($resultUserWorkplace->num_rows > 0) 
{
  while($row = $resultUserWorkplace->fetch_assoc()) 
	{
		$UserWorkplace = $row['Workplace'];
		$_SESSION['UserWorkplace'] = $UserWorkplace;
	}
}
else 
{
  echo "";              
}

//If user works on a restaurant side, user will see a restaurant version of the navigation bar
if($_SESSION['UserWorkplace']=='R')
{
	echo '<div class="navbar">
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
	</div>';
}
//If user does not work on a restaurant side, user will see a warehouse version of the navigation bar
else 
{ 
	echo '<div class="navbar">
      <a href="Homepage.html"><img src="img/logo.jpg" class="navbar__logo" alt="CLUK Logo"></a>
    <input type="checkbox" id="navbar__hamburger" class="navbar__hamburger">
	<label for="navbar__hamburger" class="navbar__hamburger__label">
	<span>|||</span>
	</label>
	<nav class="sidebar">
	<ul>
      <li><a href="Homepage.html" class="sidebar__menu">Home</a></li>
      <li><a href="Deliveries.html" class="sidebar__stock">Deliveries</a></li>
        <li><a href="Dashboard.html" class="sidebar__received">Dashboard</a></li>
        <li> <a href="Inventories.html" class="sidebar__completed">Inventories</a></li>
        <li> <a href="date.php" class="sidebar__track">Track</a></li>
	  <li><a href="Manage.php" class="sidebar__about">Manage Staff</a></li>
	  <li><a href="about-w.html" class="sidebar__about">About</a></li>
	  <li><a href="logOut.php" class="sidebar__logout">Log Out</a></li>
	  
	  </ul>
    </nav>
	</div>';
}
	
?>
