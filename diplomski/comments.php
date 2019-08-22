
<?php

include_once("config/dbconfig.php");
include_once("admin/functions.php");
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

    <link type="text/css" rel="stylesheet" href="src/css/main.css"/>
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


    <link href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js"></script>

    <style>
        @media screen and (min-width: 200px) {
            .commentsection {
                padding-bottom: 10%;
                position: relative;
                min-height: 100%;
                margin-bottom: 25%;
            }

        }
        @media screen and (min-width: 400px) {
            .commentsection {
                position: relative;
                min-height: 100%;
                margin-bottom: 10%;
            }
        }
    </style>
</head>
<body>


<div>
    <div style="position: fixed; z-index: 1;" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div style="background-color: white;margin-right: 11%; margin-left: 11%;position: relative; z-index: 2;">

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3;
        min-height: 100vh;
 overflow: hidden;
 display: block;
 ">
    <?php
    require "header.php";
    ?>

    <div class="commentsection" style="position: relative; min-height: 100%;">

        <?php

        $id = $_GET['id'];

        $sql="SELECT * FROM comments WHERE approved=1 AND id='$id' ORDER BY comments_id DESC";
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
        else{
            echo "<div class='hashtag' style='background-color: transparent;height: 230px;margin-top: 17%'>Nema komentara. Budite prvi i ostavite komentar.</div>";
        }

    ?>




</div>

    <?php
    require "footer2.php";
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