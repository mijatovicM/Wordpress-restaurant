<?php
if(!isset($_SESSION))
{
    session_start();
}
include_once("../config/dbconfig.php");
include_once("functions.php");

if(!isset($_SESSION['userId']) || $_SESSION['userType'] == 'korisnik' || $_SESSION['userType'] == 'urednik') {
    header("refresh: 2; url=../index.php");
} else {
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
        <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="../src/css/main.css"/>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../src/bootstrap/js/bootstrap.min.js"></script>
        <!--GOOGLE FONTS-->
        <link href="https://fonts.googleapis.com/css?family=Teko|PT+Sans|Permanent+Marker" rel="stylesheet">
        <!--FONT AWESOME-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../src/bootstrap/js/jquery-3.3.1.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </head>
<body>


<div>
    <div style="position: fixed; z-index: 1;" >
        <a href="http://www.vts.su.ac.rs" ><img src="../src/images/banner.jpg" /></a></div>
    <div style="background-color: white;margin-right: 11%; margin-left: 11%;position: relative; z-index: 2;">

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3; ">
            <!--Clearfix,quickly and easily clears floated content within a container.Easily clears floats by adding .clearfix to the parent element. -->

    <?php
    require "header.php";

    if(isset($_GET['success'])) {
        if ($_GET['success'] == "changed_news") {
            echo "<div class='successdiv'> Uspešno ste izmenili vest!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "error_change_news") {
            echo "<div class='errordiv'> Dogodila se greška pri menjanju vesti!</div>";
        }
    }
    if(isset($_GET['success'])) {
        if ($_GET['success'] == "users_updated") {
            echo "<div class='successdiv'> Uspešno ste ažurirali korisnika!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "users_updated") {
            echo "<div class='errordiv'> Dogodila se greška pri ažuriranju korisnika!</div>";
        }
    }
    ?>
    <div style="padding-left: 3%;padding-right: 3%;padding-bottom: 4%;padding-top: 2%;">

<!-- Tabs -->

<section id="tabs" class="clearfix" style="box-shadow: 1px 1px 2px 2px #cdcdcd;border-radius: 8px 8px;">
    <div class="container ">
        <h1 class="section-title" >Redakcija</h1>
        <div class="row" >
            <div class="col-sm-12 ">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Vesti urednika</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Komentari</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Članovi </a>
                        <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Vesti korisnika</a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <!--HORIZONTAL CARDS-->

            <?php
            global $connection;

            $sql = "SELECT * FROM news WHERE approved=0 AND creator='urednik' ORDER BY id DESC";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id=$row["id"];
                    echo "<div class=\"horizontalCard card horizdiv\">";
                    echo "<div class=\"row horizcontentdiv\">";
                    echo "<div class=\"col-md-4 \">";
                    echo "<img class='card-img-top img-fluid ' alt=\"" . $row['alt'] . "\" src=\"../" . $row['images'] . "\">";
                    if($row['important_news']==1){
                        echo "<div>";
                        echo "<div class='importantadmin'>Bitna vest</div>";
                        echo "<div class='importantadminbutton'><a href='updateimage.php?id=$id' class='btn btn-info'>Promeni sliku <i class=\"fas fa-edit\"></i></a></div>";
                        echo "</div>";

                    }
                    elseif($row['important_news']==0){
                        echo "<div>";
                        echo "<div class='importantadmin'>Obična vest</div>";
                        echo "<div class='importantadminbutton'><a href='updateimage.php?id=$id' class='btn btn-info'>Promeni sliku <i class=\"fas fa-edit\"></i></a></div>";
                        echo "</div>";
                    }
                    echo "</div>";

                    echo "<div class=\"col-md-8 px-3 horiz\">";
                    echo "<div class=\"card-block px-3 \" >";
                    echo" <p class='newstype'>".$row["newstype"]."</p>";


                    echo "<h4 class=\"card-title \">". $row["title"] . "</h4>";
                    echo "<p class=\"card-text \">". $row["caption"] . "</p>";



                    $id=$row["id"];
                    echo '<div>';

                    echo '<a class=" btn btn-secondary buttonMore"  href="../news.php?id='.$id.' ">Pročitajte više ...</a>';
                    echo '<div style="margin: 2%  auto 0% auto;text-align: center;"/>';

                    echo "<button class='btn btn-danger' onClick='deleteme($id )' name='Delete'>Izbrišite <i class=\"fas fa-trash-alt\"></i></button> &nbsp;";
                    delete();

                    echo "<a href='updatenews.php?id=$id' class='btn btn-secondary'>Izmenite <i class=\"fas fa-edit\"></i></a> &nbsp;";


                    echo "<button class='btn btn-success' onClick='approveme($id )' >Odobrite <i class=\"fas fa-check-circle\"></i></button>";
                    approve();



                    echo '</div>';


                    echo "</div>";
                    echo "</div>";

                    echo "</div>";

                    echo "</div>";

                    echo "</div>";

                    echo '<br/>';




                    }
            }
            else
                {
                    echo "<div style='height: 200px;'>";
                    echo "<div class='commentedh1' style='width: 80%;border-radius: 7px 7px;margin: 10% auto 0 auto;font-size:40px'>Nema vesti urednika</div>";
                    echo "</div>";
                }
                ?>





        <!--END OF HORIZONTAL CARDS-->
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="commentsection" style="margin-top: 5%;">

            <?php


            $sql="SELECT * FROM comments WHERE approved=0 ORDER BY comments_id DESC";
            $result=mysqli_query($connection,$sql)or die(mysqli_error($connection));
            if(mysqli_num_rows($result)>0){

                while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                    $originalDate =  $row['timeofcomment'];
                    $newDate = date("d.m.Y H:i", strtotime($originalDate));
                    $nickname=$row['nickname'];
                    $comments=$row['comments'];
                    $approved=$row['approved'];
                    $id=$row['id'];
                    $commid=$row['comments_id'];
                    echo "<div class='col-lg-6 commentspan' style='background-color: #f8f8f8;box-shadow: 1px 1px 2px 2px #ceddda;border-radius: 7px 7px;'><span class='nickname'>$nickname</span><span class='timeofcomment'> $newDate </span><br/>
<span class='commentpart' >$comments</span>  </div> ";

                    echo "<div style='margin-top: 1%;margin-bottom: 3%;'>";
                    echo '<a class="btn btn-secondary" href="../news.php?id='.$id.'">Pročitajte vest</a>&nbsp;';
                    echo "<button class='btn btn-success' onClick='approvecomm($commid )' > <i class=\"fas fa-check-circle\"></i></button>&nbsp;";
                    approvecomment();
                    echo "<button class='btn btn-danger' onClick='deletecomm($commid )' name='Delete'> <i class=\"fas fa-trash-alt\"></i></button>";
                    deletecomment();
                    echo "<br/>";
                    echo "</div>";
                    echo"<hr style='margin-bottom: 2%;width: 70%'/>";
                }

            }
            else{
                echo "<div style='height: 200px;'>";
                echo "<div class='commentedh1' style='width: 80%;border-radius: 7px 7px;margin: 10% auto 0 auto;font-size:40px'>Nema komentara za odobravanje</div>";
                echo "</div>";
            }

            ?>
                        </div>
                        </div>
                    <!--        **********************AZURIRANJE KORISNIKA************************************************ -->

                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                            <!-- Tabs -->

                                <div class="container">
                                    <div class="row" style="display:block;">
                                        <div class="col-xs-12 ">
                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-redakcija" role="tab" aria-controls="nav-home" aria-selected="true" >Redakcija/Urednici</a>
                                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-korisnici" role="tab" aria-controls="nav-profile" aria-selected="false">Korisnici</a>

                                                </div>
                                            </nav>

                        <div class="tab-content py-3 px-3 px-sm-0" style="margin: auto;width: 52%;" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-redakcija" role="tabpanel" aria-labelledby="nav-redakcija-tab">
                                <?php
                                echo '<div>';
                                     echo "<table class=\"table-responsive\" style='width: 100%;'>";
                                        echo "<tr>";
                                        echo "<th>Korisničko ime</th>";
                                        echo "<th>E-mail</th>";
                                        echo "<th>Vrsta</th>";
                                        echo "<th>Izmena</th>";
                                         echo "<th>Izbriši</th>";

                                echo "</tr>";


                                $sql="SELECT * FROM users WHERE type='redakcija' OR type='urednik'";

                                $result=mysqli_query($connection,$sql)or die(mysqli_error($connection));
                                if(mysqli_num_rows($result)>0){

                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {

                                        $username = $row['username'];
                                        $email = $row['email'];
                                        $type = $row['type'];
                                        $id=$row['users_id'];



                                        echo "<tr>";
                                        echo " <td>$username</td>";
                                        echo "<td>$email</td>";
                                        echo "<td>$type</td>";


                                        echo "<td><form action=\"updateuser.php\" method=\"post\"><select name=\"editoruser\"> ";


                                            $sql2="SELECT * FROM users WHERE users_id='$id'";
                                            $result2 = mysqli_query($connection, $sql2)or die(mysqli_error($connection));


                                                if (mysqli_num_rows($result2) > 0) {

                                                    if ($type == 'redakcija') {
                                                        echo "<option>urednik</option>";
                                                        echo "<option>korisnik</option>";
                                                    } elseif ($type == 'urednik') {
                                                        echo "<option>redakcija</option>";
                                                        echo "<option>korisnik</option>";
                                                    }
                                                }

                                        echo '<input type="hidden" name="id" value="'.$id.'"/><br/></select>
                                            <button style="margin-top: 3%" class="btn btn-info" type=\"submit\">Ažuriraj</button></form></td>';
                                        echo "<td><button class='btn btn-danger' onClick='deleteu($id )' name='Delete'><i class=\"fas fa-trash-alt\"></i></button></td> &nbsp;";
                                        deleteuser();

                                        echo "</tr>";
                                        echo "<br/>";
}}
                                echo "</table>";
                                echo "</div>";
                                ?>

                            </div>


                            <div class="tab-pane fade" id="nav-korisnici" role="tabpanel" aria-labelledby="nav-korisnici-tab">

                                <?php
                                echo "<table class='table-responsive' style='width: 100%;margin: auto;'>";
                                echo "<tr>";
                                echo "<th>Korisničko ime</th>";
                                echo "<th>E-mail</th>";
                                echo "<th>Vrsta</th>";
                                echo "<th>Izmena</th>";
                                echo "<th>Izbriši</th>";
                                echo "</tr>";


                                $sql="SELECT * FROM users WHERE type='korisnik'";

                                $result=mysqli_query($connection,$sql)or die(mysqli_error($connection));
                                if(mysqli_num_rows($result)>0){

                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {

                                        $username = $row['username'];
                                        $email = $row['email'];
                                        $type = $row['type'];
                                        $id=$row['users_id'];



                                        echo "<tr>";
                                        echo " <td>$username</td>";
                                        echo "<td>$email</td>";
                                        echo "<td>$type</td>";

                                        echo "<td><form action=\"updateuser.php\" method=\"post\"><select name=\"editoruser\"> ";


                                        $sql2="SELECT * FROM users WHERE users_id='$id'";
                                        $result2 = mysqli_query($connection, $sql2)or die(mysqli_error($connection));


                                        if (mysqli_num_rows($result2) > 0) {

                                            echo "<option>urednik</option>";
                                            echo "<option>redakcija</option>";
                                        }
                                        echo '<input type="hidden" name="id" value="'.$id.'"/><br/></select>
                                            <button style="margin-top: 3%" class="btn btn-info" type=\"submit\">Ažuriraj</button></form></td>';
                                        echo "<td><button class='btn btn-danger' onClick='deleteu($id )' name='Delete'><i class=\"fas fa-trash-alt\"></i></button></td> &nbsp;";
                                        deleteuser();

                                        echo "</tr>";
                                        echo "<br/>";
                                        }}
                                echo "</table>";
                                ?>


                                <!-- **************************** DODAVANJE KORISNIKA ***************************************-->
                                <?php
                                if(isset($_GET['error'])){
                                    if($_GET['error']=="emptyfields"){
                                        echo '<script>alert("Popunite sva polja")</script>';
                                    }
                                    elseif ($_GET['error']=="invaliduidmail"){
                                        echo '<script>alert("Netačno korisničko ime i e-mail!")</script>';
                                    }
                                    elseif ($_GET['error']=="invaliduid"){
                                        echo '<script>alert("Netačno korisničko ime!")</script>';
                                    }
                                    elseif ($_GET['error']=="invalidmail"){
                                        echo '<script>alert("Netačan e-mail!")</script>';
                                    }
                                    elseif ($_GET['error']=="passwordcheck"){
                                        echo '<script>alert("Unete lozinke se ne podudaraju!")</script>';
                                    }
                                    elseif ($_GET['error']=="usertaken"){
                                        echo '<script>alert("Korisničko ime već postoji!")</script>';
                                    }
                                }
                                if(isset($_GET['signup'])){
                                    if ($_GET['signup']=="success") {
                                        echo '<script>alert("Uspešno ste se registrovali!")</script>';
                                    }
                                }
                                ?>

                                <div class="registrationh3">
                                    <h3>Dodavanje novih korisnika</>
                                </div>
                                <form class="form-signup2" action="../includes/signup.inc.php" method="post">
                                    <div class="input-group">
                                        <span class="input-group-addon2" style="margin-left: 20%;"><i class="fas fa-user icons2"></i></span>
                                        <input type="text" class="form-control"  name="uid" placeholder="Korisničko ime"/>
                                    </div>

                                    <br/><br/>
                                    <div class="input-group">
                                        <span class="input-group-addon2"  style="margin-left: 20%;"><i class="fas fa-envelope icons2"></i></span>
                                        <input type="text" class="form-control"  name="mail" placeholder="E-mail"/>
                                    </div>

                                    <br/><br/>
                                    <div class="input-group">
                                        <span class="input-group-addon2"  style="margin-left: 20%;"> <i class="fas fa-lock icons2"></i></span>
                                        <input  type="password" class="form-control" name="pwd" placeholder="Lozinka"/>
                                    </div>

                                    <br/><br/>
                                    <div class="input-group">
                                        <span class="input-group-addon2"  style="margin-left: 20%;"><i class="fas fa-lock icons2"></i></span>
                                        <input type="password" class="form-control" name="pwd-repeat" placeholder="Unesite ponovo lozinku"/>
                                    </div>
                                    <div>
                                        <p><img src="../captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
                                        <p><input type="text" size="6" maxlength="5" name="captcha" value="" style="border-radius: 0%;margin-right: 0%;"/><br/><br/>
                                            <small style="font-family: 'Kalam', cursive;font-size: 15px">Unesite sigurnosni kod koji se nalazi u polju iznad</small></p>

                                    </div>

                                    <script>

                                        function checkForm(form) {
                                            var captcha = form.captcha.value;
                                            if(!captcha.match(/^\d{5}$/)) {
                                                alert('Unesite sigurnosni kod koji se nalazi u polju iznad');
                                                form.captcha.focus();
                                                return false;
                                            }

                                            return true;


                                        }

                                    </script>


                                    <br/><br/>
                                    <button type="submit" class="btn btn-info" name="signup-submit">Dodaj korisnika</button>

                                </form>

                            </div>

                            </div>





                                            </div>

                                        </div>
                                    </div>
                                </div>


        <!-- ./Tabs -->




       <!--        ******************************************************************************************************** -->

                <!*************************** VESTI KORISNIKA******************************************-->
                        <div class="tab-pane fade " id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">

                            <!--HORIZONTAL CARDS-->

                            <?php
                            global $connection;

                            $sql = "SELECT * FROM news WHERE approved=0 AND creator='korisnik' ORDER BY id DESC";
                            $result = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {

                                    $id=$row["id"];
                                    echo "<div class=\"horizontalCard card horizdiv\">";
                                    echo "<div class=\"row horizcontentdiv\">";
                                    echo "<div class=\"col-md-4 \">";
                                    echo "<img class='card-img-top img-fluid ' alt=\"" . $row['alt'] . "\" src=\"../" . $row['images'] . "\">";
                                    if($row['important_news']==1){
                                        echo "<div>";
                                        echo "<div class='importantadmin'>Bitna vest</div>";
                                        echo "<div class='importantadminbutton'><a href='updateimage.php?id=$id' class='btn btn-info'>Promeni sliku <i class=\"fas fa-edit\"></i></a></div>";
                                        echo "</div>";

                                    }
                                    elseif($row['important_news']==0){
                                        echo "<div>";
                                        echo "<div class='importantadmin'>Obična vest</div>";
                                        echo "<div class='importantadminbutton'><a href='updateimage.php?id=$id' class='btn btn-info'>Promeni sliku <i class=\"fas fa-edit\"></i></a></div>";
                                        echo "</div>";
                                    }
                                    echo "</div>";

                                    echo "<div class=\"col-md-8 px-3 horiz\">";
                                    echo "<div class=\"card-block px-3 \" >";
                                    echo" <p class='newstype'>".$row["newstype"]."</p>";

                                    echo "<h4 class=\"card-title \">". $row["title"] . "</h4>";
                                    echo "<p class=\"card-text \">". $row["caption"] . "</p>";



                                    $id=$row["id"];
                                    echo '<div>';

                                    echo '<a class=" btn btn-secondary buttonMore"  href="../news.php?id='.$id.' ">Pročitajte više ...</a>';
                                    echo '<div style="margin: 2%  auto 0% auto;text-align: center;"/>';

                                    echo "<button class='btn btn-danger' onClick='deleteme($id )' name='Delete'>Izbrišite <i class=\"fas fa-trash-alt\"></i></button> &nbsp;";
                                    delete();

                                    echo "<a href='updatenews.php?id=$id' class='btn btn-secondary'>Izmenite <i class=\"fas fa-edit\"></i></a> &nbsp;";


                                    echo "<button class='btn btn-success' onClick='approveme($id )' >Odobrite <i class=\"fas fa-check-circle\"></i></button>";
                                    approve();



                                    echo '</div>';

                                    echo "</div>";
                                    echo "</div>";

                                    echo "</div>";

                                    echo "</div>";

                                    echo "</div>";

                                    echo '<br/>';




                                }
                            }
                    else
                    {
                        echo "<div style='height: 200px;'>";
                        echo "<div class='commentedh1' style='width: 80%;border-radius: 7px 7px;margin: 10% auto 0 auto;font-size:40px'>Nema vesti korisnika</div>";
                        echo "</div>";
                    }
                    ?>





                            <!--END OF HORIZONTAL CARDS-->

                        </div>
                </div>
                    </div>
            </div>
                </div>

    </section>
    <!-- ./Tabs -->

</div>
    <?php
    require "../footer.php";
    ?>
</div>
    </div>
</div>
</body>
    </html>


    <?php

}?>