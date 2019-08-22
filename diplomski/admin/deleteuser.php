<?php
include_once("../config/dbconfig.php");
global $connection;
$sql = "DELETE FROM liked_news WHERE users_id='".$_GET['delu_id']."'";
$sql1 = "DELETE FROM saved_news WHERE users_id='".$_GET['delu_id']."'";
$select = "DELETE FROM users WHERE users_id='".$_GET['delu_id']."'";
$result = mysqli_query($connection, $sql) or die($sql);
$result1 = mysqli_query($connection, $sql1) or die($sql1);
$query = mysqli_query($connection, $select) or die($select);
header ("Location: index.php");

?>