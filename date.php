<!DOCTYPE html> 
<html>
<head>
<!--Role of the page is essentially to act as a gate in order to pass date asa variable into api4.php -->
<meta charset="utf-8">
    <title>CLUK Staff Management</title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /></head>
<body>
   <div class="navbar">
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
	</div>
    <main>
<h1>Date Page</h1>

<!--Role of the page is essentially to act as a gate in order to pass date asa variable into api4.php  -->

<form method="post" action="api4.php">
Enter date:
<input type="date" name="dDay">
<input type="submit" value="Submit">
</form>



</main>
</body>
</html>
