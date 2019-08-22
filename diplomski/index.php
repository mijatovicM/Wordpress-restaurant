
<?php

include_once("config/dbconfig.php");

//autocomplete part
global $connection;
if(isset($_POST['search'])){
    $response= "<h6 class='searchBox'>Nema rezultata</h4 class='searchBox'>";

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
        #index{
            background-color: #49505b;
            border-radius:6px 6px;
        }
        @media only screen and (max-width: 1200px) {
        .cardss.img-fluid {
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
        if(isset($_GET['error'])) {
            if ($_GET['error'] == "nouser") {
                echo '<div class="errordiv">Ne postoji korisnik sa tim korisničkim imenom!</div>';
            }
            elseif ($_GET['error'] == "wrongpassword") {
                echo '<div class="errordiv">Pogrešna lozinka!</div>';
            }
            elseif ($_GET['error'] == "emptyfields") {
                echo '<div class="errordiv">Popunite sva polja</div>';
            }
            elseif ($_GET['error'] == "inactive") {
                echo '<div class="errordiv">Nalog nije aktiviran!</div>';

            }
        }
        if(isset($_GET['success'])) {
            if ($_GET['success'] == "changed") {
                echo "<div class='successdiv'> Uspešno ste izmenili svoje informacije. Odjavili smo Vas kako biste videli sve izmene. Prijavite se opet!</div>";
            }
        }
        if(isset($_GET['success'])) {
            if ($_GET['success'] == "errorchange") {
                echo "<div class='errordiv'>Dоšlo je do greške</div>";
            }
        }
        if(isset($_GET['error'])) {
            if ($_GET['error'] == "notlogged") {
                echo "<div class='errordiv'>Morate biti prijavljeni da biste se prijavili na newsletter!</div>";
            }
        }
        if(isset($_GET['signup'])){
            if ($_GET['signup']=="success_forgot_password_change") {
                echo '<div class="successdiv">Uspešno ste promenili lozinku!</div>';
            }
        }


        ?>



        <!-- WEATHER WIDGET -->

        <a class="weatherwidget-io" href="https://forecast7.com/sr/46d1019d67/subotica/" data-label_1="SUBOTICA" data-label_2="VREME" data-icons="Climacons Animated" data-theme="metallic" >SUBOTICA VREME</a>
        <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>

        <!-- END OF WEATHER WIDGET -->

        <!-- NEWSLETTER AND USER NEWS DIV -->
        <div class="wrapper clearfix newsletter_user_div">

            <div style="float: left;width: 50%;border-right: 1px solid #b7b7b7;">
                    <form method="post" action="">
                        <button type="submit" name="newsletterbutton" class="newsletter_button_div">Prijavi se na newsletter</button>
                    </form>
                </div>

            <a href="usernews.php"><div style="float: right;width: 50%;">
                    Vesti naših korisnika
                </div></a>

        </div>
        <?php
        if($_POST) {
            if (!isset($_SESSION['userId'])) {
                echo ('<script>location.replace("index.php?error=notlogged");</script>');

            } elseif (isset($_SESSION['userId'])) {
                echo "<script>location.replace('changeinfo.php');</script>";
            }
        }
        ?>

        <!--END OF NEWSLETTER AND USER NEWS DIV -->

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
                                url:'index.php',
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


    <!-- CAROUSEL -->

    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
        </ol>
        <div class="carousel-inner">
            <!--prvo uzimam prvu vest jer mora da bude carousel-item active posto inace nece da prebacuje na ostale vesti -->
                    <?php
                    echo "<div class=\"carousel-item active\">";
                    $sql_select="SELECT * FROM news WHERE newstype='srbija' AND important_news=1 AND approved=1 ORDER BY id DESC LIMIT 1";
                    $result = mysqli_query($connection,$sql_select);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $id=$row["id"];
                            echo '<a  href="news.php?id='.$id.'">';
                            echo "<img class=\"d-block w-100\"  alt=\"".$row['alt']."\" src=\"".$row['images']."\">";
                            echo "<div class=\"corner-ribbon orange\">".$row['newstype']."</div>";
                            echo "<div class=\"carousel-caption \"><p>".$row['title']."</p></div>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else echo "No result";
                    echo "</a>";

            /*a zatim sam napravio funkciju koja nema klasu active kao i gore,i samo se prosledjuju podaci koji se nalaze u pozivu funkcije
                tj SELECT-ovi koji imaju razlicite newstype-ove    */
                    function carousel($sql_select){
                        echo "<div class=\"carousel-item \">";
                        echo " <a href=\"http://www.google.com\">";
                        global $connection;
                        $result = mysqli_query($connection,$sql_select);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $id=$row["id"];
                                echo '<a  href="news.php?id='.$id.'">';
                                echo "<img class=\"d-block w-100\"  alt=\"".$row['alt']."\" src=\"".$row['images']."\">";
                                echo "<div class=\"corner-ribbon orange\">".$row['newstype']."</div>";
                                echo "<div class=\"carousel-caption \"><p>".$row['title']."</p></div>";
                                echo "</a>";
                                echo "</div>";
                            }
                        } else echo "No result";
                        echo "</a>";
                    }
                    carousel("SELECT * FROM news WHERE newstype='poznati' AND important_news=1 AND approved=1 ORDER BY id DESC LIMIT 1");
                    carousel("SELECT * FROM news WHERE newstype='zabava' AND important_news=1 AND approved=1  ORDER BY id DESC LIMIT 1");
                    carousel("SELECT * FROM news WHERE newstype='svet' AND important_news=1 AND approved=1 ORDER BY id DESC LIMIT 1");
                    carousel("SELECT * FROM news WHERE newstype='sport' AND important_news=1 AND approved=1 ORDER BY id DESC LIMIT 1");
                    carousel("SELECT * FROM news WHERE newstype='politika' AND important_news=1 AND approved=1 ORDER BY id DESC LIMIT 1");
                    ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- END OF CAROUSEL-->

    <!-- SIDE BAR-->
        <nav class="vertical-menu" style="background-color: #353942;color: #ffcb00;border-radius: 0px 0px;">
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link" id="nav-najnovije-tab" data-toggle="tab" href="#nav-najnovije" role="tab" aria-controls="nav-najnovije" aria-selected="true">Najnovije</a>
                <a class="nav-item nav-link" id="nav-najpregledanije-tab" data-toggle="tab" href="#nav-najpregledanije" role="tab" aria-controls="nav-najpregledanije" aria-selected="false">Najpregledanije</a>
                <a class="nav-item nav-link" id="nav-kursnalista-tab" data-toggle="tab" href="#nav-kursnalista" role="tab" aria-controls="nav-kursnalista" aria-selected="false">Kursna lista</a>

            </div>
        </nav>
        <div class="tab-content vertical-menu" id="nav-tabContent">
            <div class="tab-pane fade show active "  id="nav-najnovije" role="tabpanel" aria-labelledby="nav-najnovije-tab">



                    <?php
                    $sql = "SELECT * FROM news WHERE approved=1 ORDER BY id DESC LIMIT 0,5";
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

            </div>
            <div class="tab-pane fade" id="nav-najpregledanije" role="tabpanel" aria-labelledby="nav-najpregledanije-tab">
                <?php
                $sql = "SELECT * FROM news WHERE approved=1 ORDER BY cookie_count DESC LIMIT 0,5";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $id=$row["id"];
                        echo '<a href="news.php?id='.$id.'">'.$row["title"].'<div style="float: right">'.$row["cookie_count"].'&nbsp;<i class="far fa-eye"></i></div>'.'</a>';
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
            <div class="tab-pane fade" id="nav-kursnalista" role="tabpanel" aria-labelledby="nav-kursnalista-tab">
                <iframe src="http://www.kursna-lista.info/resources/kursna-lista.php?format=4&br_decimala=4&promene=1&procenat=1" width="325px" height="225px" frameborder="0" scrolling="no" style="margin: auto;width: 100%;"></iframe>
            </div>

        </div>

        <!--END OF SIDE BAR-->



    </div>

        <!--CARDS DIV-->

    <div class="wrapper clearfix" style="margin-right: 0%;margin-left: 0%;padding: 1%">
        <div class="card-deck">

               <?php
                    $sql = "SELECT * FROM news  WHERE approved=1   ORDER BY id DESC LIMIT 5,3";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            echo  "<div class='card'>";
                            echo "<img class='card-img-top cardss img-fluid' alt=\"".$row['alt']."\" src=\"".$row['images']."\">"."</a>";
                    echo  "<div class='card-body'>";
                    echo  "<h5 class='card-title'>".$row["title"]."</h5>";
                    echo  "<p class='card-text'>".$row["caption"]."</p>";

                            $originalDate =  $row['timeofinsert'];
                            $newDate = date("d/M/Y H:i", strtotime($originalDate));
                    echo  " <p class='card-text'><small class='text-muted'>$newDate</small></p>";
                            $id=$row["id"];
                            echo '<a class="btn btn-secondary buttonMore" style="display:block;text-overflow:ellipsis; overflow: hidden;" href="news.php?id='.$id.'">Pročitajte više..</a>';
                    echo"</div>";
                    echo "</div>";
                        }
                    } else {
                        echo "0 results";
                    }

        echo "</div>";
       echo "<div class='card-deck'>";

                $sql = "SELECT * FROM news  WHERE approved=1   ORDER BY id DESC LIMIT 8,3";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        echo  "<div class='card'>";
                        echo "<img class='card-img-top cardss img-fluid' alt=\"".$row['alt']."\" src=\"".$row['images']."\">"."</a>";
                        echo  "<div class='card-body'>";
                        echo  "<h5 class='card-title'>".$row["title"]."</h5>";
                        echo  "<p class='card-text'>".$row["caption"]."</p>";
                        $originalDate =  $row['timeofinsert'];
                        $newDate = date("d/M/Y H:i", strtotime($originalDate));
                        echo  " <p class='card-text'><small class='text-muted'>$newDate</small></p>";
                        $id=$row["id"];
                        echo '<a class="btn btn-secondary buttonMore" style="display:block;text-overflow:ellipsis; overflow: hidden;" href="news.php?id='.$id.'">Pročitajte više..</a>';
                        echo"</div>";
                        echo "</div>";
                    }
                } else {
                    echo "0 results";
                }
                ?>
        </div>
    </div>

        <script type="text/javascript">
            $("h5.card-title").text(function(index, currentText) {
                return currentText.substr(0, 65).concat("...");
            });
            $("p.card-text").text(function(index, currentText) {
                return currentText.substr(0, 36).concat("...");
            });
        </script>

    <!--END OF CARDS DIV-->

    <!--HORIZONTAL CARDS-->

    <div class="wrapper clearfix" style="margin-right: 0%;margin-left: 0%;padding: 1%">
        <?php
        //defining how many results we want per page
        $results_per_page=6;
            $sql = "SELECT title,images,caption,alt,newstype FROM news  WHERE approved=1  ORDER BY id DESC";
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
        $sql = "SELECT * FROM news  WHERE approved=1   ORDER BY id DESC
LIMIT " .$this_page_first_result.','.$results_per_page;
        $result = mysqli_query($connection, $sql);
        $number_of_results=mysqli_num_rows($result);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                echo "<div class=\"horizontalCard card horizdiv\">";
                echo "<div class=\"row horizcontentdiv\">";
                echo "<div class=\"col-md-4 \">";
                echo "<img class='card-img-top img-fluid
                ' alt=\"" . $row['alt'] . "\" src=\"" . $row['images'] . "\">";


                echo "</div>";

                echo "<div class=\"col-md-8 px-3 horiz\">";
                echo "<div class=\"card-block px-3  \">";
                echo" <p class='newstype'>".$row["newstype"]."</p>";

                echo "<h4 class=\"card-title \">". $row["title"] . "</h4>";
                echo "<p class=\"card-text \">". $row["caption"] . "</p>";

                $id=$row["id"];
                echo '<a style="margin-top: 8%;float: right;" class=" btn btn-secondary buttonMore" href="news.php?id='.$id.'">Pročitajte više ...</a>';
                echo "</div>";
                echo "</div>";

                echo "</div>";
                echo "</div>";
                echo "<br>";
            }

        } else {
            echo "0 results";

        }



        //display the links to the pages
        //komentarisani delovi su resenje za prikazivanje previous i next dugmica
        echo "<ul class='justify-content-center pagination'>";
        if(isset($_GET['page'])) {
        if ($_GET['page'] > 1) {
            echo "<li><a href='index.php?page=" . ($page - 1) . "'style='font-size: 25px;padding-top: 3%;'  class='button'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
        }}
        else echo "";
        if(!isset($_GET['page'])){
            echo "";
        }
        if($page<=4 ){
        for($i=1;$i<=4;$i++){
            echo '<div>';
            echo '<ul class="pagination">';

            if($i==$page)
                echo '<a class="active">'.$i.'</a>';
            else
                echo '<a href="index.php?page='.$i.'">'.$i.'</a>';
        }
        }
        if($page>4 ) {
            echo '<a class="active" href="index.php?page=' . $page . '">' . $page . '</a>';
            if(isset($_GET['page'])) {
                if ($_GET['page'] < $number_of_pages) {
                    echo "<li><a href='index.php?page=" . ($page + 1) . "' style='font-size: 25px;padding-top: 3%;' class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
                }}
            elseif (!isset($_GET['page'])){
                echo "<li><a href='index.php?page=" . ($page + 1) . "'  style='font-size: 25px;padding-top: 3%;'  class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
            }
            echo '</div>';
    require "footer.php";
    exit();
        }
        if(isset($_GET['page'])) {
        if ($_GET['page'] < $number_of_pages) {
            echo "<li><a href='index.php?page=" . ($page + 1) . "' style='font-size: 25px;padding-top: 3%;' class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
        }}
        elseif (!isset($_GET['page'])){
            echo "<li><a href='index.php?page=" . ($page + 1) . "'  style='font-size: 25px;padding-top: 3%;'  class='button'><i   class=\"fas fa-chevron-circle-right\"></i></a></li>";
        }
        else
            echo "";
        echo "</ul>";

        echo '</ul>';

        if($page<=4 ) {
            echo '</div>';
            echo '</div>';
        }

        ?>

     <!--   mysqli_close($connection); -->






</div>
    </div>

    <!--END OF HORIZONTAL CARDS-->

       <?php
    require "footer.php";
    ?>

    </div>
    </body>

</html>