<?php
session_start();
$userid=$_SESSION['userId'];
$username= $_SESSION['userUid'];
$news_id=$_GET['likenews_id'];

include_once("config/dbconfig.php");
global $connection;
$sql = "INSERT INTO liked_news(users_id,username,id) VALUES ('$userid','$username','$news_id')";
$result = mysqli_query($connection, $sql) or die($sql);

if(mysqli_num_rows($result2)==0) {

    header("Location: news.php?id=$news_id");
}

?>