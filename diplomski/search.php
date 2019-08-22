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


</head>
<body>
<div>
    <div style="position: fixed; z-index: 1;" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div style="background-color: white;margin-right: 11%; margin-left: 11%;position: relative; z-index: 2;">

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3; ">
            <!--Clearfix,quickly and easily clears floated content within a container.Easily clears floats by adding .clearfix to the parent element. -->


    <?php
    require "header.php";
    ?>

    <!-- WEATHER WIDGET -->

    <a class="weatherwidget-io" href="https://forecast7.com/sr/46d1019d67/subotica/" data-label_1="SUBOTICA" data-label_2="VREME" data-icons="Climacons Animated" data-theme="metallic" >SUBOTICA VREME</a>
    <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
    </script>

    <!-- END OF WEATHER WIDGET -->
    <?php
        if (!empty($_GET['search'])) {
              ($_GET['search']);
        }
        $hashtag=($_GET['search']);
        echo "<div class='hashtag' style='width: 80%;border-radius: 7px 7px;margin: 4% auto 0 auto;'>Rezultati za reč: ".$hashtag."</div>";

//defining how many results we want per page
$results_per_page=6;
$sql = "SELECT   h.*, m.*, n.* FROM hashtags h INNER JOIN hashtags_middle_table m  ON h.hashtags_id = m.hashtags_id INNER JOIN news n ON m.id = n.id  WHERE h.hashtags='$hashtag' AND approved=1  ORDER BY n.id DESC";
/*
 SELECT news.id, news.title, news.caption, news.images, news.alt, news.newstype
FROM news LEFT JOIN hashtags ON news.id=hashtags.id WHERE hashtags='$hashtag' ORDER BY id DESC
 */
$result = mysqli_query($connection, $sql);
$number_of_results=mysqli_num_rows($result);

//determine number of total pages available
$number_of_pages=ceil($number_of_results/$results_per_page);
//determine which page number visitor is currently on
if(!isset($_GET['page'])){
    $page=1;
}else{
    $page=$_GET['page'];
}
//determine the sql LIMIT starting number for the results on the displaying page
$this_page_first_result=($page-1)*$results_per_page;
//retrieve selected results from database and display them on the page

    $sql = "SELECT   h.*, m.*, n.* FROM hashtags h INNER JOIN hashtags_middle_table m  ON h.hashtags_id = m.hashtags_id INNER JOIN news n ON m.id = n.id WHERE h.hashtags='$hashtag' AND approved=1 ORDER BY n.id DESC LIMIT ".$this_page_first_result.','.$results_per_page;
    $result = mysqli_query($connection, $sql);
    $number_of_results=mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class=\"horizontalCard card horizdiv\">";
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
            echo "</div>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
            echo "<br>";
        }

    } else {
        echo "<div style='min-height: 45vh;overflow: hidden;display: block; ' class='hashtag'>Nema rezultata</div>";

    }

    $sql = "SELECT * FROM hashtags";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {

        $hashtags = $row['hashtags'];

        $trimmedhashtag = trim($hashtag, '#');
    }
    echo "<ul class='justify-content-center pagination'>";
    if(isset($_GET['page'])) {
    if ($_GET['page'] > 1) {
        echo "<li><a href='search.php?search=%23" . $trimmedhashtag . "&submit=click&page=" . ($page - 1) . "'style='font-size: 25px;padding-top: 3%;'  class='button'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
    }}
    else echo "";
    if(!isset($_GET['page'])){
        echo "";
    }
//display the links to the pages
    echo '<div>';
    echo '<ul class="justify-content-center pagination">';

for($i=1;$i<=$number_of_pages;$i++) {

    if ($i == $page) {
        echo '<a class="active">' . $i . '</a>';
    } else {
        $sql = "SELECT * FROM hashtags";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result)) {

            $hashtags = $row['hashtags'];
        }
        $trimmedhashtag = trim($hashtag, '#');

        echo '<a href="search.php?search=%23' . $trimmedhashtag . '&submit=click&page=' . $i . '">' . $i . '</a>';

    }}
    if(isset($_GET['page'])) {
        if ($_GET['page'] < $number_of_pages) {
            echo "<li><a  href='search.php?search=%23" . $trimmedhashtag . "&submit=click&page=" . ($page + 1) . "' style='font-size: 25px;padding-top: 3%;' class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
        }}
    elseif (!isset($_GET['page']) && $number_of_pages>1){
        echo "<li><a  href='search.php?search=%23" . $trimmedhashtag . "&submit=click&page=" . ($page + 1) . "'  style='font-size: 25px;padding-top: 3%;'  class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
    }
    elseif(!isset($_GET['page']) && $number_of_pages==1){
        echo "";
    }
    else
        echo "";
    echo "</ul>";

    echo '</ul>';
    echo '</div>';


?>




<?php
require "footer.php";
?>
    </div>
    </div>
</div>
</body>
</html>