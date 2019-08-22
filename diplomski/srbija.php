<?php
include_once("config/dbconfig.php");

//autocomplete part
if(isset($_POST['search'])){
    $response= "<h6 class='searchBox'>Nema rezultata</h4 class='searchBoxNo'>";

    $q=$connection->real_escape_string($_POST['q']);
    $sql=$connection->query("SELECT DISTINCT hashtags FROM hashtags WHERE hashtags LIKE '%$q%' ");


    if($sql->num_rows>0){
        $response="<ul class='searchBox'>";

        while ($data=$sql->fetch_array())

            $response .="<h6 class='searchBox'>".$data['hashtags']."</h6>";
        $response.="</ul>";
    }
    exit($response);
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
        #srbija{
            background-color: #49505b;
            border-radius:6px 6px;
        }
        @media only screen and (max-width: 1200px) {
            .cardsimage {
                max-width: 100%;
                height: auto !important;
            }}
    </style>

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

    <!-- SEARCH BOX -->
    <form action="search.php" method="get">
        <div class="card-body row no-gutters align-items-center">
            <div class="col">
                <input type="text" id="searchBox" class="form-control form-control-lg form-control-borderless" name="search" placeholder="Pretražite vesti, pokušajte sa ključnim rečima . . .">
            </div>
            <div class="col-auto">&nbsp;
                <button class="btn btn-md" name="submit" type="submit" value="click"><i class="fas fa-search h4 text-body"></i></button>
            </div>
        </div>
    </form>
    <div id="response" class="searchBox" style="overflow-y: scroll;">
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#searchBox").keyup(function () {
                var query=$("#searchBox").val();

                if(query.length>0){
                    $.ajax({
                            url:'srbija.php',
                            method:'POST',
                            data:{
                                search:1,
                                q:query
                            },
                            success:function (data) {
                                $("#response").html(data).height("200px");
                            },
                            dataType:'text'
                        }
                    );
                }
            });
            $(document).on('click','h6',function () {
                var news = $(this).text();
                $("#searchBox").val(news);
                $("#response").html("");
            })
        });
    </script>
    <!--END OF SEARCH BOX-->

    <!--4 CARDS-->
    <div class="cardscontainer" style='margin: 2%;'>
        <div class="row">
            <?php
            $sql = "SELECT * FROM news WHERE newstype='srbija'  AND approved=1  ORDER BY id DESC LIMIT 0,4 ";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo  "<div class=\"col-xl-6\">";
                    echo "<img class=\"cardsimage\"  alt=\"".$row['alt']."\" src=\"".$row['images']."\">"."</a>";
                    echo  "<div class=\"cardstext\">";
                    echo  "<h5>".$row["title"]."</h5>";
                    echo  "<p>".$row["caption"]."</p>";
                    $id=$row["id"];
                    echo '<a class="btn btn-secondary buttonMore" href="news.php?id='.$id.'">Pročitajte više..</a>';
                    echo"</div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }


            //END OF 4 CARDS
?>
        </div>
    </div>
            <script type="text/javascript">
                $("h5").text(function(index, currentText) {
                    return currentText.substr(0, 70).concat("...");
                });
                $("p").text(function(index, currentText) {
                    return currentText.substr(0, 40).concat("...");
                });
            </script>
            <?php

            //HORIZONTAL CARDS


            //defining how many results we want per page
            $results_per_page=6;
            $sql = "SELECT * FROM news WHERE newstype='srbija'  AND approved=1  ORDER BY id DESC";
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
            $this_page_first_result=($page-1)*$results_per_page+4;
            //retrieve selected results from database and display them on the page
            $sql = "SELECT * FROM news  WHERE newstype='srbija'  AND approved=1  ORDER BY id DESC LIMIT " .$this_page_first_result.','.$results_per_page;
            $result = mysqli_query($connection, $sql);
            $number_of_results=mysqli_num_rows($result);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<div class=\"horizontalCard card horizdiv\" style='margin: 2%;'>";
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
                    echo '<a class=" btn btn-secondary buttonMore" href="news.php?id='.$id.'">Pročitajte više ...</a>';
                    echo "</div>";
                    echo "</div>";

                    echo "</div>";
                    echo "</div>";
                    echo "<br>";
                }

            } else {
                echo "Nema rezultata</>";

            }

            //display the links to the pages
            echo "<ul class='justify-content-center pagination'>";
            if(isset($_GET['page'])) {
                if ($_GET['page'] > 1) {
                    echo "<li><a href='srbija.php?page=" . ($page - 1) . "'style='font-size: 25px;padding-top: 3%;'  class='button'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
                }}
            else echo "";
            if(!isset($_GET['page'])){
                echo "";
            }
            if($page<=2 ){
                for($i=1;$i<=2;$i++){
                    echo '<div>';
                    echo '<ul class="pagination">';

                    if($i==$page)
                        echo '<a class="active">'.$i.'</a>';
                    else
                        echo '<a href="srbija.php?page='.$i.'">'.$i.'</a>';
                }
            }
            if($page>2 ) {
                echo '<a class="active" href="srbija.php?page=' . $page . '">' . $page . '</a>';
            }
            if(isset($_GET['page'])) {
                if ($_GET['page'] < $number_of_pages) {
                    echo "<li><a href='srbija.php?page=" . ($page + 1) . "' style='font-size: 25px;padding-top: 3%;' class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
                }}
            elseif (!isset($_GET['page'])){
                echo "<li><a href='srbija.php?page=" . ($page + 1) . "'  style='font-size: 25px;padding-top: 3%;'  class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
            }
            else
                echo "";
            echo "</ul>";

            echo '</ul>';

            if($page<=2 ) {
                echo '</div>';
                echo '</div>';
            }

            ?>

            <!--   mysqli_close($connection); -->
            <?php
            require "footer.php";
            ?>

        </div>



        <!--END OF HORIZONTAL CARDS-->
    </div>
        </div>

</body>

</html>