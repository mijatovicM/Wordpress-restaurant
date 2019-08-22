
<?php
include_once("../config/dbconfig.php");
global $connection;
$select = "UPDATE comments SET approved='1' WHERE comments_id='".$_GET['approvecomm_id']."'";

$query = mysqli_query($connection, $select) or die($select);
header ("Location: index.php");
?>
