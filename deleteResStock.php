<?php include("connect.php");
//takes the variable sent from displayResStock.php
$aiID=intval($_GET['AutoIncrementID']);

//deletes the item from restaurant storage with the corresponding id
$sql="DELETE FROM RestaurantStorage WHERE AutoIncrementID=$aiID";
if($conn->query($sql)===TRUE)
{
    echo "Record updated successfully; ";
	header("location:displayResStock.php");
}
else
{
    echo "Error updating record: ".$conn->error;
}
$conn->close()
?>