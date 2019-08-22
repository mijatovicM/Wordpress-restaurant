<?php
session_start();

include_once("config/dbconfig.php");
include_once("admin/functions.php");
global $connection;
$id = $_GET['id'];
$id = mysqli_real_escape_string($connection,$id);
    include_once("config/dbconfig.php");
    global $connection;
    $sql = "SELECT * FROM news WHERE id='$id' ";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            if(!isset($_COOKIE['count'.$id])){
                $content=$row["cookie_count"];
                $val=$content+1;
                $query = mysqli_query($connection, "UPDATE news SET cookie_count='$val' WHERE id='$id'");
                setcookie("count".$id,$val,time()+600);
            }

        }}



if(isset($_POST['notloggedin'])) {
if(!isset($_SESSION['userId'])) {
    header("Location: news.php?like=notlogged&id=" . $id . "");
}
}
if(isset($_POST['komentarisi']) && !isset($_SESSION['userId'])){
    header("Location: news.php?comment=notlogged&id=" . $id . "");
}
if(isset($_POST['komentarisi']) ) {
    if (isset($_SESSION['userId'])) {
        header("Location: news.php?comment=success&id=" . $id . "");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Izveštavaj - Najnovije vesti iz sveta i regiona</title>


    <!-- Bootstrap -->
    <link href="src/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="src/css/main.css" />
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <!--GOOGLE FONTS-->
    <link href="https://fonts.googleapis.com/css?family=Teko|PT+Sans|Permanent+Marker" rel="stylesheet">
    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="src/bootstrap/js/jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="ckeditor/ckeditor.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js"></script>
<style>
    .img-fluid {
        max-width: 100%;
        height: auto !important;
    }
</style>


</head>
<body>
<div>
    <div style="position: fixed; z-index: 1;" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div style="background-color: white;margin-right: 11%; margin-left: 11%;position: relative; z-index: 2;">

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3; ">

    <?php
    require "newsheader.php";


    if(isset($_GET['like'])) {
        if ($_GET['like'] == "notlogged") {
            echo '<div class="errordiv">Morate biti prijavljeni da biste lajkovali vest!</div>';
        }
    }

    if(isset($_GET['comment'])) {
        if ($_GET['comment'] == "notlogged") {
            echo '<div class="errordiv">Morate biti prijavljeni da biste poslali komentar!</div>';
        }
    }

    if(isset($_GET['comment'])) {
        if ($_GET['comment'] == "success") {
            $messagecomment = "Uspešno ste poslali komentar. Sačekajte da administratori odobre vaš komentar.";
            echo "<div class='successdiv'>$messagecomment</div>";
        }
    }


    ?>





            <?php
            global $connection;

            $id = $_GET['id'];
            $id = mysqli_real_escape_string($connection,$id);
            $sql = "SELECT * FROM news WHERE `id`='" . $id . "'";
            $result = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($result)) {
                echo "<br>";
                echo "<div class='news'>";
                echo $row['content'];

                $originalDate =  $row['timeofinsert'];
                $newDate = date("d/M/Y H:i", strtotime($originalDate));
                echo "<div style='text-align: right'>$newDate";
                echo "<br/>";
                echo "<p>Urednik: ".$row['creatorname']."</p> ";
                echo "<p style='font-size: 17px'>".$row['cookie_count']."&nbsp<i class=\"far fa-eye\" style='color: #4B250F'></i>&nbsp&nbsp&nbsp";
            }

            $sql = "SELECT * FROM liked_news WHERE id='$id';";
            $result = mysqli_query($connection,$sql);

            if($row = mysqli_fetch_array($result)) {
                $num_rows = mysqli_num_rows($result);
                echo $num_rows."&nbsp<i class=\"far fa-thumbs-up\" style='color: #1e6eff'></i></p> ";
            }
            else{
                echo "0"."&nbsp<i class=\"far fa-thumbs-up\" style='color: #1e6eff'></i></p> ";
            }

            //SELECT news.id, news.title, news.caption, news.images, news.alt, news.newstype
           // FROM news INNER JOIN hashtags ON news.id=hashtags.id WHERE hashtags.hashtags='$hashtag'
            $sql = "SELECT * FROM hashtags h INNER JOIN hashtags_middle_table m  ON h.hashtags_id = m.hashtags_id INNER JOIN news n ON m.id = n.id ";
            $result = mysqli_query($connection,$sql);
            while($row = mysqli_fetch_array($result)) {
                if($row['id']==$id) {

                    $hashtags = $row['hashtags'];
                    $trimmedhashtags = trim($hashtags, '#');
                    echo '<a href="search.php?search=%23' . $trimmedhashtags . '">' . $hashtags . '</a>';
                }
            }


            echo "</div>";

            if(isset($_SESSION['userId'])) {
                $userid=$_SESSION['userId'];
                echo '<div style="text-align: center;margin-top: 2%"/>';
            $sql = "SELECT * FROM saved_news WHERE id='$id' AND users_id='$userid'";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "<button class='btn btn-secondary' onClick='savenews($id)' name='save' style='display: none;'>Sačuvajte vest na svom profilu <i class=\"fas fa-bookmark\"></i></button> &nbsp;";
                    save();
                }
            }
            else{
                echo "<button class='btn btn-secondary' onClick='savenews($id)' name='save'>Sačuvajte vest na svom profilu <i class=\"fas fa-bookmark\"></i></button> &nbsp;";
                save();
            }

                echo "</div>";
                $sql = "SELECT * FROM news WHERE id='$id'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                    }
                }
            }


            if(!isset($_SESSION['userId']) ){
                echo '<div style="text-align: center;margin-top: 2%">';
                echo "<form action='' method='post'><button class='btn btn-info' type='submit' name='notloggedin'>Sviđa mi se <i class=\"fas fa-thumbs-up\"></i></button></form> &nbsp;";
                echo '</div>';

            }

            elseif(isset($_SESSION['userId'])) {
                $userid=$_SESSION['userId'];
                echo '<div style="text-align: center;margin-top: 2%"/>';
                $sql = "SELECT * FROM liked_news WHERE id='$id' AND users_id='$userid'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                        echo "<button class='btn btn-info' onClick='likenews($id)' name='like' style='display: none;'>Sviđa mi se <i class=\"far fa-thumbs-up\"></i></button> &nbsp;";
                        like();
                    }
                }
                else{
                    echo "<button class='btn btn-info' onClick='likenews($id)' name='like'>Sviđa mi se <i class=\"fas fa-thumbs-up\"'></i></button> &nbsp;";
                    like();
                }

                echo "</div>";
                $sql = "SELECT * FROM news WHERE id='$id'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                    }
                }
            }





            if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija') {
                echo '<div style="text-align: center;margin-top: 2%"/>';

                echo "<button class='btn btn-danger' onClick='deletenewsme($id)' name='Delete'>Izbrišite <i class=\"fas fa-trash-alt\"></i></button> &nbsp;";
                deletenews();

                echo "<a href='admin/updatenews.php?id=$id' class='btn btn-secondary'>Izmenite vest <i class=\"fas fa-edit\"></i></a> &nbsp;";
                echo "<a href='admin/updateimage.php?id=$id' class='btn btn-primary'>Izmenite sliku <i class=\"far fa-images\"></i></a> &nbsp;";

                echo "</div>";
                $sql = "SELECT * FROM news WHERE id='$id'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['important_news'] == 1) {
                            echo "<div class='important'>Bitna vest</div>";
                        } elseif ($row['important_news'] == 0) {
                            echo "<div class='important'> Obična vest</div>";
                        }
                    }
                }
            }



            function save(){?>
                <!-- Javascript function for deleting news -->
                <script language="javascript">
                    function savenews(savenewsid)
                    {
                        if(confirm("Da li želite da sačuvate ovu vest na svom profilu?")){
                            window.location.href='savenews.php?savenews_id=' +savenewsid+'';
                            alert('Uspešno ste sačuvali ovu vest na svoj profil');
                            return true;
                        }
                    }

                </script>
            <?php }

            function like(){?>
                <!-- Javascript function for deleting news -->
                <script language="javascript">
                    function likenews(likenewsid)
                    {
                        if(confirm("Da li želite da lajkujete ovu vest?")){
                            window.location.href='likenews.php?likenews_id=' +likenewsid+'';
                            alert('Lajkovali ste ovu vest');
                            return true;
                        }
                    }

                </script>
            <?php }


            function deletenews(){?>
                <!-- Javascript function for deleting news -->
                <script language="javascript">
                    function deletenewsme(delnewsid)
                    {
                        if(confirm("Da li sigurno želite da obrišete ovu vest?")){
                            window.location.href='deletenews.php?delnews_id=' +delnewsid+'';
                            alert('Uspešno ste izbrisali vest');
                            return true;
                        }
                    }



                </script>
            <?php }

            echo "</div>";
            ?>


        <!-- SIDE BAR-->
        <div class="vertical-menu2">


            <p>Najnovije</p>
            <?php
                $sql = "SELECT * FROM news WHERE approved=1 ORDER BY id DESC LIMIT 0,12";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $id=$row["id"];
                        echo '<a href="news.php?id='.$id.'">'.$row["title"].'</a>';
                    }
                } else {
                    echo "0 results";
                }
                ?>

        <!--END OF SIDE BAR-->

    </div>






    <div class="commentsection" >
        <h3>Postavite komentar</h3>

        <form action="" method="post">

            <div style="width: 40%;   margin: 0 auto;">
                <textarea name="user_input" id="user_input"  cols="30" rows="3" placeholder="Upišite komentar..." required maxlength="500" class="commentsinput" ></textarea>
            </div>
            <br/>
            <p>Max. 500 karaktera</p>
            <input type="submit"  name="komentarisi" value="Postavite komentar" class="responsive-width btn btn-primary">
        </form>


        <hr style="border-bottom: 1px solid #c2d0cd;width: 70%;"/>

        <?php

        if($_POST) {
            $id = $_GET['id'];

            if (isset($_SESSION['userId'])){
                $nickname= $_SESSION['userUid'];

            $find = array('idiot', 'kreten', 'moron','retard','imbecil');
            $replace =array('<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>','<b>*cenzurisano*</b>','<b>*cenzurisano*</b>');

            if (isset($_POST['user_input']) && !empty($_POST['user_input'])) {
                $user_input = $_POST['user_input'];
                $user_input_new = str_ireplace($find, $replace, $user_input);


            $query = mysqli_query($connection, "INSERT INTO comments (nickname,comments,approved,id,timeofcomment) VALUES ('$nickname','$user_input_new',0,'$id',NOW())");
            mysqli_query($connection,$query);







                }
        }
        }



        ?>




        <?php

        $id = $_GET['id'];

        $sql="SELECT * FROM comments WHERE approved=1 AND id='$id' ORDER BY comments_id DESC LIMIT 0,5";
        $result=mysqli_query($connection,$sql)or die(mysqli_error($connection));
        if(mysqli_num_rows($result)>0){

            while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                $originalDate =  $row['timeofcomment'];
                $newDate = date("d.m.Y H:i", strtotime($originalDate));
                $nickname=$row['nickname'];
                $comments=$row['comments'];
                $approved=$row['approved'];

                echo "<div style='position: relative'>";
                echo "<div class='col-lg-6 commentspan' style='background-color: #f8f8f8;box-shadow: 1px 1px 2px 2px #ceddda;border-radius: 7px 7px;'><span class='nickname'>$nickname</span><span class='timeofcomment'> $newDate </span><br/>
 <span class='commentpart' >$comments</span>";

                if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija') {
                    $commid=$row['comments_id'];
                    echo "<hr/><div style='text-align: right;padding: 1%;'>";
                    echo "<button class='btn btn-danger' onClick='deletecommm($commid )' name='Delete'> <i class=\"fas fa-trash-alt\"></i></button></div>";
                    deletecomm();
                }


                echo "</div> ";
                echo "</div>";
                echo "<br/>";

            }

        }

        echo '<div style="text-align: center;"/>';
        echo '<a class="allcommentslink" href="comments.php?id='.$id.'">Pročitajte sve komentare</a><br/>';
        echo '</div>';

     ?>


    </div>
    <?php
    require "footer.php";
    ?>
</div>
    </div>
</div>
</body>
<script>
    $("#user_input").emojioneArea({
        pickerPosition:"bottom"
    });
</script>
</html>
