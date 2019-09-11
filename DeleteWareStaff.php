<?php
// Start the session
session_start();
?>
<?php include("connect.php");

//Get Warehouse Staff ID of the selected staff and set this id as a variable
$id = $_GET['ID'];

//MySQL statement to delete that staff profile from the database
//Return the result instantly to the display table
$sql = "DELETE FROM Staff WHERE ID=$id";
if($conn->query($sql)===TRUE)
{
    echo "Record updated successfully; ";
    header("location:DisplayWareStaff.php");
}
else
{
    echo "Error updating record: ".$conn->error;
}
