<?php
global $connection;
if(isset($_POST['editoruser'])){
    $editorUser=$_POST['editoruser'];

    $id= $_POST['id'];
    include "../config/dbconfig.php";

    $query=mysqli_query($connection,"UPDATE users SET type ='$editorUser' WHERE users_id='$id'");
    if($query){
     header ("Location: index.php?success=users_updated");



    }
    else{
      header ("Location: index.php?error=users_updated");

    }
}
else{
    //Not performing any action
}
?>