<?php
session_start();
include_once("config/dbconfig.php");
global $connection;
$userid=$_SESSION['userId'];
$username= $_SESSION['userUid'];
$select = "DELETE FROM liked_news WHERE id='".$_GET['dellike_id']."' AND users_id='$userid'";
$query = mysqli_query($connection, $select) or die($select);
header("Location: liked.php")

?>
