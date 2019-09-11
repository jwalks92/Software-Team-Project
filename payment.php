<?php include ("connect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> CLUK Stock Management </title>
 <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
    <script src="JavaScript.js"></script>
</head>

<body>
<!--Payment taken from total store table every time.  -->
<?php
$paymentDue = "select sum(Total) from Store";
	//super total takes variables and  converts string to float for placement in database. 
    // this is then stored for later formatting and echoing in the later echo seen shortly below. 
		$result2=$conn->query($paymentDue);
		
		if($result2->num_rows>0)
		{
			while($row=$result2->fetch_assoc()){
				$money=$row['sum(Total)'];
				$superTotal=number_format((float)$money, 2, '.', '');
			}
		}
?>

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
            <h1>Payment Page</h1>
            <div class="payment">
                <form method="post" action="receiptPage.php">
            <input type="reset" class="payment-button" value="Reset" />

			<!--uses cash input for number type, echo money which has been converted from integer.  -->
                    <div id="total">
                        <p id="totalSetter">The total to pay is: £<?php echo $money ?></p>
                    </div>
                    <p>Enter how much money the customer pays:</p>
                <!--Payment is set to numberical only values and increments by a single penny every time -->
                    <input name="cashInput" type="number" min="0" placeholder="£0.00" value="" step="0.01" required="required"/>

                    <br>

                    <input type="submit" class="payment-button" value="Submit" />
                </form>
            </div>
        </div>
    </main>
</body>
</html>
