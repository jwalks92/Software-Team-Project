<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> CLUK Staff Management </title>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
    <script src="JavaScript.js"></script>
    <!––style of the table and the add button––>
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
  <!––Add navigation bar––>
  <?php
    include 'ManageNavBar.php';
  ?>
    <main>  
         
        <h2>Restaurant Staff Records</h2>
	
	<!––The select form for different restaurant branches––>
        <div class="select">
        <form method="post" action="DisplayResStaff.php">
        Please select the branch: <br><br>
        <input type="radio" name="BranchID" value="1" checked> 1. Seaton Burn Services<br>
        <input type="radio" name="BranchID" value="2"> 2. Alnwick Town Centre<br>
        <input type="radio" name="BranchID" value="3"> 3. Newton Aycliffe<br>
        <input type="radio" name="BranchID" value="4"> 4. Thirsk Town Centre<br>
        <input type="radio" name="BranchID" value="5"> 5. Whitby Town Centre<br>
	<!––Get a global variable into form––>
	<input type="text" name="username" hidden readonly value="<?php $_SESSION['getUser'] = $_SESSION['getUser'];?>"><br>
        <input type = "submit" value = "Submit">
        </form>   
        </div>

</main>
</body>
</html>
