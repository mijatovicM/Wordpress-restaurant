<?php
session_start();
include_once("config/dbconfig.php");
global $connection;
$userid=$_SESSION['userId'];
$username= $_SESSION['userUid'];
$select = "DELETE FROM saved_news WHERE id='".$_GET['delsnews_id']."' AND users_id='$userid'";
$query = mysqli_query($connection, $select) or die($select);
header("Location: saved.php")
?>