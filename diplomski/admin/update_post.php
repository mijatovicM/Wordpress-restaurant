<?php
global $connection;
if(isset($_POST['editor'])){
$editorText=$_POST['editor'];
    $editorTitle=$_POST['editortitle'];
    $editorCaption=$_POST['editorcaption'];
    $editorAlt=$_POST['editoralt'];
    $editorNewstype=$_POST['editornewstype'];
    $editor_Important_news=$_POST['editor_important_news'];


    $id= $_POST['id'];
    include "../config/dbconfig.php";

    $query=mysqli_query($connection,"UPDATE news SET content='$editorText',title='$editorTitle',caption='$editorCaption',alt='$editorAlt',newstype='$editorNewstype',important_news='$editor_Important_news'  WHERE id='$id'");
    if($query){
        header ("Location: index.php?success=changed_news");


    }
    else{
        header ("Location: index.php?error=error_change_news");
    }
}
else{
    //Not performing any action
}
?>