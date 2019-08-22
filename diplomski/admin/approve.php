<?php
include_once("../config/dbconfig.php");
global $connection;
$select = "UPDATE news SET approved='1' WHERE id='".$_GET['approve_id']."'";
$query = mysqli_query($connection, $select) or die($select);

$sql="SELECT * FROM news WHERE id='".$_GET['approve_id']."' AND important_news=1";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0) {
// output data of each row
while ($row = mysqli_fetch_assoc($result)) {
$title = $row['title'];
$images= $row['images'];

$sql2="SELECT * FROM users WHERE Status='active' AND newsletter='yes'";
$result = mysqli_query($connection, $sql2);
if (mysqli_num_rows($result) > 0) {
// output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $mails = $row['email'];

    $current_path = 'localhost/diplomski/news.php?id=';
    $url = "http://" . $current_path . $_GET['approve_id'] . "";
    mail($mails, "Bitna vest", "$title\r\n\r\nKliknite na link kako biste detaljnije procitali vest: $url", "From: izvestavajme@gmail.com\r\n");
}}}}
header ("Location: index.php");
?>
