<?php
include_once("config/dbconfig.php");


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

    <style>
        .footer{
            margin-top: 5%; padding-top: 2%;padding-bottom: 2%;
        }

    </style>
</head>
<body>
<div>
    <div style="position: fixed; z-index: 1;" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div style="background-color: white;margin-right: 11%; margin-left: 11%;position: relative; z-index: 2;">

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3; min-height: 100vh;
 overflow: hidden;
 display: block; ">
            <!--Clearfix,quickly and easily clears floated content within a container.Easily clears floats by adding .clearfix to the parent element. -->

    <?php
    require "header.php";
    ?> <!-- WEATHER WIDGET -->

    <a class="weatherwidget-io" href="https://forecast7.com/sr/46d1019d67/subotica/" data-label_1="SUBOTICA" data-label_2="VREME" data-icons="Climacons Animated" data-theme="metallic" >SUBOTICA VREME</a>
    <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
    </script>

    <?php
    global $connection;
    $userid=$_SESSION['userId'];
    $username= $_SESSION['userUid'];

    $sql = "SELECT news.id, news.title, news.caption, news.images, news.alt, news.newstype
FROM news INNER JOIN saved_news ON news.id=saved_news.id WHERE users_id='$userid'  ORDER BY saved_news_id DESC ";
    $result = mysqli_query($connection, $sql);
    $number_of_results=mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='cardsection' style='overflow: hidden;display: block;display: flex; 
    flex-direction: column; '>";
            echo "<div class=\"horizontalCard card horizdiv\" style='margin-top: 5%;margin-bottom: 5%'>";
            echo "<div class=\"row horizcontentdiv\">";
            echo "<div class=\"col-md-4 \">";
            echo "<img class='card-img-top img-fluid horizimage' alt=\"" . $row['alt'] . "\" src=\"" . $row['images'] . "\">";


            echo "</div>";

            echo "<div class=\"col-md-8 px-3 horiz\">";
            echo "<div class=\"card-block px-3  \">";
            echo" <p class='newstype'>".$row["newstype"]."</p>";

            echo "<h4 class=\"card-title \">". $row["title"] . "</h4>";
            echo "<p class=\"card-text \">". $row["caption"] . "</p>";
            $id=$row["id"];

            echo '<a class="btn btn-secondary buttonMore" href="news.php?id='.$id.'">Pročitajte više..</a>';
            echo "<br/><br/>";
            echo "<button class='btn btn-danger' onClick='deletesnewss($id)' name='Delete'>Uklonite ovu sačuvanu vest <i class=\"fas fa-trash-alt\"></i></button>";
            deletesnews();
            echo "</div>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<br>";
        }

    } else {
        echo "<div style='min-height: 55vh;overflow: hidden;display: block;'>";
        echo "<div class='commentedh1' style='width: 80%;border-radius: 7px 7px;margin: 15% auto 0 auto;font-size: 40px'>Niste sačuvali nijednu vest</div>";
        echo "</div>";

    }




function deletesnews(){?>
    <!-- Javascript function for deleting comments from news page -->
    <script language="javascript">
        function deletesnewss(delsnewsid)
        {
            if(confirm("Da li sigurno želite da uklonite ovu sačuvanu vest?")){
                window.location.href='delete_saved_onprofile.php?delsnews_id=' +delsnewsid+'';
                alert('Uspešno ste uklonili sačuvanu vest');
                return true;
            }
        }


    </script>


<?php }?>

            <?php
            require "footer.php";
            ?>

        </div>
    </div>
</div>
</body>
</html>