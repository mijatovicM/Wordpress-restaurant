
<?php
include_once("../config/dbconfig.php");
global $connection;
$select = "DELETE FROM comments WHERE comments_id='".$_GET['delcomm_id']."'";
$query = mysqli_query($connection, $select) or die($select);
header ("Location: index.php");

echo $_GET['delcomm_id'];

?>