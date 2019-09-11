<?php
//makes sure that the username and password entered in the login page are not harmful
require "loginPage.php";
$uname = htmlspecialchars($_POST["username"]);
$pword = htmlspecialchars($_POST["Password"]);
?>

<main>
<p> Please check username and password are correct!<p>
</main>