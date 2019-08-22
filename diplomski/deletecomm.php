
<?php
include_once("config/dbconfig.php");
global $connection;
$select = "DELETE FROM comments WHERE comments_id='".$_GET['delcommm_id']."'";
$query = mysqli_query($connection, $select) or die($select);
header ("Location: commented.php");

?>