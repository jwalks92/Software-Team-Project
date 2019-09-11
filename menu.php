<?php include ("connect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title> CLUK Stock Management </title>
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<!-- jquery utilised for AJAX purposes. -->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="finalSoftwareDevelopment.js"></script>
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
<!--clears the database every time an order is made, means that customers are not receiving orders made by other customers.   -->
	<?php
	
	$delete="delete from Store";
			
			if($conn->query($delete)===TRUE){
			echo "";
			}
	
	?>
	
	<!--form uses validate method to first store information into menu array and then pass through to the database, is stored in AJAX call,
so will not be passed until necessary.-->
      <form onsubmit="validate();" method="post" action="loading.php">
          <!--for purposes of both JS and CSS. Placed in multiple classes to make styling and access of information eaiser and simpler.   -->
        <section class="menu">
          <div class="menu__chicken" name="food" value="menuOption('chicken')">
            <h4 class="menu__chicken__heading">3 Pieces of Southern Fried Chicken</h4>
            <!-- <img src="img/chicken.png" class="menu__chicken__img"> -->
            <p class="menu__chicken__desc">Random mix of chicken thigh, drumstick and wing pieces.</p>
              <!-- price converted in JS by removing pound sign and parsing to a float to be stored into SQl database. -->
            <span class="price">£2.50</span>

            <button type="button" name="button2" onclick="increase('inc1')">+</button>
            <button type="button" name="button2" onclick="decrease('inc1')">-</button>
            <input type="text" id="inc1" name="3 Pieces of Southern Fried Chicken" value="0"></input>
          </div>
          <div class="menu__chicken-nobone" name="food" value="menuOption('chicken-nobone')">
            <h4 class="menu__chicken-nobone__heading">3 Boneless Southern Fried Chicken Strips</h4>
            <!-- <img src="img/chicken-nobone.png" class="menu__chicken-nobone__img"> -->
            <p class="menu__chicken-nobone__desc">Strips of boneless southern fried chicken.</p>
            <span class="price">£2.50</span>

            <button type="button" onclick="increase('inc2')">+</button>
            <button type="button" onclick="decrease('inc2')">-</button>
            <input type="text" id="inc2" name="3 Boneless Southern Fried Chicken Strips" value="0"></input>
          </div>
          <div class="menu__burger" name="food" value="menuOption('burger')">
            <h4 class="menu__burger__heading">CLUK Burger</h4>
            <!-- <img src="img/burger.png" class="menu__burger__img"> -->
            <p class="menu__burger__desc">Sesame seed bun, boneless southern fried chicken breast fillet, mayonnaise and lettuce.</p>
            <span class="price">£3.50</span>

            <button type="button" onclick="increase('inc3')">+</button>
            <button type="button" onclick="decrease('inc3')">-</button>
            <input type="text" id="inc3" name="CLUK Burger" value="0"></input>
          </div>
          <div class="menu__s-burger" name="food" value="menuOption('s-burger')">
            <h4 class="menu__s-burger__heading">CLUK Super Burger</h4>
            <!-- <img src="img/s-burger.png" class="menu__s-burger__img"> -->
            <p class="menu__s-burger__desc">Sesame seed bun, boneless southern fried chicken breast fillet, mayonnaise, cheese, hash brown and lettuce.</p>
            <span class="price">£4.50</span>

            <button type="button" onclick="increase('inc4')">+</button>
            <button type="button" onclick="decrease('inc4')">-</button>
            <input type="text" id="inc4" name="S-Burger" value="0"></input>
          </div>
          <div class="menu__veg-strips" name="food" value="menuOption('veg-strips')">
            <h4 class="menu__veg-strips__heading">3 Vegetarian Southern Fried Strips</h4>
            <!-- <img src="img/veg-strips.png" class="menu__veg-strips__img"> -->
            <p class="menu__veg-strips__desc">Mycoprotein based meat substitute southern fried strips.</p>
            <span class="price">£2.50</span>

            <button type="button" onclick="increase('inc5')">+</button>
            <button type="button" onclick="decrease('inc5')">-</button>
            <input type="text" id="inc5" name="Veg-Strips" value="0"></input>
          </div>
          <div class="menu__veg-burger" name="food" value="menuOption('veg-burger')">
            <h4 class="menu__veg-burger__heading">CLUK Vegetarian Burger</h4>
            <!-- <img src="img/veg-burger.png" class="menu__veg-burger__img"> -->
            <p class="menu__veg-burger__desc">Sesame seed bun, mycoprotein based meat substitute Southern fried burger, mayonnaise and lettuce.</p>
            <span class="price">£3.50</span>

            <button type="button" onclick="increase('inc6')">+</button>
            <button type="button" onclick="decrease('inc6')">-</button>
            <input type="text" id="inc6" name="Veg-Burger" value="0"></input>
          </div>
          <div class="menu__veg-s-burger" name="food" value="menuOption('veg-s-burger')">
            <h4 class="menu__veg-s-burger__heading">CLUK Vegetarian Super Burger</h4>
            <!-- <img src="img/veg-s-burger.png" class="menu_veg-s-burger__img"> -->
            <p class="menu__veg-s-burger__desc">Sesame seed bun, mycoprotein based meat substitute southern fried burger, mayonnaise, cheese, hash brown and lettuce.</p>
            <span class="price">£4.50</span>

            <button type="button" onclick="increase('inc7')">+</button>
            <button type="button" onclick="decrease('inc7')">-</button>
            <input type="text" id="inc7" name="Veg-S-Burger" value="0"></input>
          </div>
          <div class="menu__fries" name="food" value="menuOption('fries')">
            <h4 class="menu__fries__heading">Portion of Fries</h4>
            <!-- <img src="img/fries.png" class="menu__fries__img"> -->
            <p class="menu__fries__desc">120g serving of cooked fries.</p>
            <span class="price">£0.99</span>

            <button type="button" onclick="increase('inc8')">+</button>
            <button type="button" onclick="decrease('inc8')">-</button>
            <input type="text" id="inc8" name="Fries" value="0"></input>
          </div>
          <div class="menu__cola" name="food" value="menuOption('cola')" onclick="increase()">
            <h4 class="menu__cola__heading">Cola Flavoured Drink</h4>
            <!-- <img src="img/cola.png" class="menu__cola__img"> -->
            <p class="menu__cola__desc">750ml serving. Contains approximately 50ml of cola syrup.</p>
            <span class="price">£0.99</span>

            <button type="button" onclick="increase('inc9')">+</button>
            <button type="button" onclick="decrease('inc9')">-</button>
            <input type="text" id="inc9" name="Cola" value="0"></input>
          </div>

          <input type="submit" id="submit" class="button" value="Submit" onclick="sendToServerWithAjax()" /> <input type="reset" class="button" value="Reset" />
          
        </section>
      </form>
	  
    </main>

<!--If the post has been placed, have location passed over to loading.php  -->
	<?php
		
		if(isset($_POST["submit"]))
		{
			header("location:loading.php");
		}
		
		$conn->close();
	  ?>
  </body>
</html>
