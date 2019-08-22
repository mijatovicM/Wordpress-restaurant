<?php
global $connection;
if(isset($_POST['editorhashtags'])){
    $editorHashtags=$_POST['editorhashtags'];
    $id= $_POST['id'];
    include "../config/dbconfig.php";
$number_of_hashtags = str_word_count($editorHashtags);
/* razbijanje stringa u vrednosti koje se sada nalaze u nizu*/
$exploded_hashtags= explode(" ",$editorHashtags);
/*for petlja se vrti onoliko puta koliko ima hashtagova, i svaki put u promenljivu $hashtag stavlja novu vrednost iz niza*/
for($i=0;$i<$number_of_hashtags;$i++){
    $editorHashtags=$exploded_hashtags[$i];
    $sql = "SELECT * FROM hashtags WHERE hashtags='$editorHashtags'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "";
            $hashtags_id=$row['hashtags_id'];
            $sql2 = "SELECT * FROM hashtags_middle_table WHERE hashtags_id='$hashtags_id' AND id='$id'";
            $result2 = mysqli_query($connection, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "";
                }
                }
                else{
                    $query = mysqli_query($connection, "INSERT INTO hashtags_middle_table (hashtags_id,id) VALUES ('$hashtags_id','$id')");

                }
        }
    } elseif(mysqli_num_rows($result)==0){
        $query = mysqli_query($connection, "INSERT INTO hashtags (hashtags) VALUES ('$editorHashtags')");
        if($query){
            $sql = "SELECT * FROM hashtags WHERE hashtags='$editorHashtags'";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $hashtags_id=$row['hashtags_id'];
                    $query = mysqli_query($connection, "INSERT INTO hashtags_middle_table (hashtags_id,id) VALUES ('$hashtags_id','$id')");

                }
            }
        }
    }


}
        header ("Location: updatenews.php?id=$id&success=hashtag_changed");
}
?>