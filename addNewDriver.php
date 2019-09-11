<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Adding New Driver Profile</title>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
</head>

<body>
    <!––Add navigation bar––>
    <?php
    include 'ManageNavBar.php';
    ?>
    <main>
        <div class="content__form">
            <h1>Adding New Driver Profile</h1>
            <!––Form for adding new Driver––>
             <form method="post" action="addDriver.php">
                Full Name:<br>
             <!––This field is required and limit to only 50 characters––>
             <input type="text" name="name" maxlength="50" required><br><br>
                Telephone:<br>
             <!––Limit the length of the characters in this field––>
             <input type="text" name="telephone" maxlength="15"><br>
             <br>
             <br>
                <em>Please check your information carefully before submitting the form</em>
                <br>
                <br>
             <input type="submit" value="Submit">
            </form> 
        </div>
    </main>

</body>

</html>
