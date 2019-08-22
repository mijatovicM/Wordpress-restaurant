
<?php
include_once("config/dbconfig.php");
global $connection;
$sql = "DELETE FROM hashtags_middle_table WHERE id='".$_GET['delnews_id']."'";
$sql1 = "DELETE FROM saved_news WHERE id='".$_GET['delnews_id']."'";
$sql3 = "DELETE FROM liked_news WHERE id='".$_GET['delnews_id']."'";
$sql2 = "DELETE FROM news WHERE id='".$_GET['delnews_id']."'";
$result = mysqli_query($connection, $sql) or die($sql);
$result1 = mysqli_query($connection, $sql1) or die($sql1);
$result3 = mysqli_query($connection, $sql3) or die($sql3);
$result2 = mysqli_query($connection, $sql2) or die($sql2);
if(mysqli_num_rows($result2)==0) {

    header("Location: admin/index.php");
}

?>