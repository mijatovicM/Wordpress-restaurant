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
<?php
if(!isset($_SESSION))
{
    session_start();
}
include('../config/dbconfig.php');
if(!isset($_SESSION['userId']) || $_SESSION['userType'] == 'korisnik' || $_SESSION['userType'] == 'urednik') {
    header("refresh: 2; url=index.php");
} else {

    global $connection;
    if(isset($_GET['id'])){
        $id=$_GET['id'];
    }
    else{
        header ("Location: index.php?success=0");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="UTF-8">
        <title>Izmena vesti</title>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
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
                if(isset($_GET['error'])) {
                    if ($_GET['error'] == "bigimage") {
                        echo "<div class='errordiv'>Slika je prevelika!</div>";
                    }
                }
                if(isset($_GET['error'])) {
                    if ($_GET['error'] == "imageerror") {
                        echo "<div class='errordiv'>Dogodila se greška pri dodavanju slike!</div>";
                    }
                }
                if(isset($_GET['error'])) {
                    if ($_GET['error'] == "wrongtype") {
                        echo "<div class='errordiv'>Ne možete da dodate ovaj tip fajla!</div>";
                    }
                }
                if(isset($_GET['success'])) {
                    if ($_GET['success'] == "imagechanged") {
                        echo "<div class='successdiv'>Uspešno ste izmenili sliku!</div>";
                    }
                }
        ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class='hashtag' style='width: 80%;border-radius: 7px 7px;margin: 2% auto 0 auto;font-size:40px;background-color: #dfdfdf'>IZMENA NASLOVNE SLIKE VESTI</div>
                <br/>


                        <?php
                        $query=mysqli_query($connection,"SELECT * FROM news WHERE id='$id'");
                        $row=mysqli_fetch_array($query);
                        $images=$row['images'];
                        echo "<div style='text-align: center'>";

                        echo "<img class='img-fluid' alt=\"" . $row['alt'] . "\" src=\"../" . $row['images'] . "\" style='height:400px;'>";
                        echo '<br/><br/><input type="file" name="images" >';
                        echo "</div>";
                        ?>

                <br/><br/>
                <div style='text-align: center'>
                    <input type="hidden" name="id" value="<?= $id ?>"/>
                        <button type="submit" name="submit" class="btn btn-info">Izmeni sliku</button>
                </div>
            </form>


        <?php
        if(isset($_POST['submit'])){
            $id= $_POST['id'];

            if(isset($_FILES['images']['name']) && ($_FILES['images']['name']) !="") {

                $images = $_FILES['images'];
                $imageName = $_FILES['images']['name'];
                $imageTmpName = $_FILES['images']['tmp_name'];
                $imageSize = $_FILES['images']['size'];
                $imageError = $_FILES['images']['error'];
                $imageType = $_FILES['images']['type'];

                $imageExt = explode('.', $imageName);
                $imageActualExt = strtolower(end($imageExt));

                $allowed = array('jpg', 'jpeg', 'png');
                if (in_array($imageActualExt, $allowed)) {
                    if ($imageError === 0) {
                        if ($imageSize < 10000000) {
                            $imageNameNew = uniqid('', true) . "." . $imageActualExt;
                            $imageDestination = 'C:/wamp64/www/diplomski/src/images/' . $imageNameNew;

                            move_uploaded_file($imageTmpName, $imageDestination);
                        } else {

                            exit('<script>location.replace("updateimage.php?id='.$id.'&error=bigimage");</script>');


                        }
                    } else {

                        exit ('<script>location.replace("updateimage.php?id='.$id.'&error=imageerror");</script>');
                    }
                } else {
                    exit ('<script>location.replace("updateimage.php?id='.$id.'&error=wrongtype");</script>');
                }


                $output_dir = "src/images/";

                $query = mysqli_query($connection, "UPDATE news SET images='$output_dir$imageNameNew'  WHERE id='$id'");
                if ($query) {
                    echo('<script>location.replace("updateimage.php?id='.$id.'&success=imagechanged");</script>');




                }
            }
        }
        require "../footer.php";
        ?>
            </div>
        </div>
    </div>

    </body>
    </html>
<?php }?>