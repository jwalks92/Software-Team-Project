<?php
// Start the session
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>CLUK Staff Management</title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
	<!––style of the add button––>
	<style>
        .select__button input[type=submit] {
        width: 100%;
        background-color: rgb(119, 119, 119);
        color: white;
        padding: 14px 20px;
        margin: 20px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size:16px;

        }

        .select__button input[type=submit]:hover {
        background-color: rgb(66, 66, 66);
}
    </style>
</head>
<body>

	
 <!––Add navigation bar––>
 <?php include 'ManageNavBar.php'; ?>

 
	<main>

            <h1>CLUK Staff Records</h1>
            <!––Create a hidden form to post data into DisplayResSelect.php––>
            <div class="select__button">
            <form method="post" action="DisplayResSelect.php?ID">
            <input type="text" name="username" hidden readonly value="<?php 
	//Make sure that the global variable for username can get to this page
	if(isset($_POST ['username']))
	{
		$_SESSION['username'] = filter_input(INPUT_POST, 'username');
		$_SESSION['getUser'] = $_SESSION['username'];
	} else {
		$_SESSION['getUser'] = $_SESSION['username'];
	} ?>"><br>
            <input type = "submit" value = "Restaurant Staff">
            </form>
            </div>

	    <!––Create a hidden form to post data into DisplayWareStaff.php––>
            <div class="select__button">
            <form method="post" action="DisplayWareStaff.php?ID">
            <input type="text" name="username" hidden readonly value="<?php 
	//Make sure that the global variable for username can get to this page
	if(isset($_POST ['username']))
	{
		$_SESSION['username'] = filter_input(INPUT_POST, 'username');
		$_SESSION['getUser'] = $_SESSION['username'];
	} else {
		$_SESSION['getUser'] = $_SESSION['username'];
	} ?>"><br>
            <input type = "submit" value = "Warehouse Staff">
            </form>
            </div>
            
	    <!––Create a hidden form to post data into DisplayDriver.php––>
            <div class="select__button">
            <form method="post" action="DisplayDriver.php?ID">
            <input type="text" name="username" hidden readonly value="<?php 
	//Make sure that the global variable for username can get to this page
	if(isset($_POST ['username']))
	{
		$_SESSION['username'] = filter_input(INPUT_POST, 'username');
		$_SESSION['getUser'] = $_SESSION['username'];
	} else {
		$_SESSION['getUser'] = $_SESSION['username'];
	} ?>"><br>
            <input type = "submit" value = "Drivers">
            </form>
            </div>
        

        </div>
        <?php //For checking username in this page only 
	$getUser = filter_input(INPUT_POST,'username');?>
	</main>

</body>
</html>
