<?php
include_once("config/dbconfig.php");
if(isset($_SESSION))
{
    session_destroy();
}
session_start();
if(!isset($_SESSION['userId']) || $_SESSION['userType'] == 'korisnik' || $_SESSION['userType'] == 'redakcija') {
    header("refresh: 2; url=index.php");
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />


    <script src="ckeditor/ckeditor.js"></script>

    <style>
        ul.multiselect-container.dropdown-menu.show{
            height: 250px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        button.btn.btn-default.multiselect-clear-filter{
            visibility: hidden;
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
    require "createnewsheader.php";
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "badtype") {
            echo "<div class='errordiv'>Ne možete da dodate ovaj tip fajla!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "imageerror") {
            echo "<div class='errordiv'>Dogodila se greška pri dodavanju slike!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "imagesize") {
            echo "<div class='errordiv'>Slika je prevelika!</div>";
        }
    }

    if(isset($_GET['success'])) {
        if ($_GET['success'] == "newssuccess") {
            echo "<div class='successdiv'>Uspešno ste poslali vest,sačekajte da redakcija odobri vašu vest!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "errornews") {
            echo "<div class='errordiv'>Greška pri dodavanju!</div>";
        }
    }
    ?>
<form action="" method="post" class="createnewsform" enctype="multipart/form-data">
<textarea class="ckeditor" name="editor" required></textarea>
    <br/><br/>
    <table class='userchangetable table-responsive'>
        <tr>
            <th style="text-align: center !important;">Naslov</th>
    <td style="text-align: center !important;"><input type="text"  name="title" required ></td>
        </tr>
        <tr>
            <th style="text-align: center !important;">Opis</th>
            <td style="text-align: center !important;"><input type="text" name="caption"  required ></td>
        </tr>
        <tr>
            <th style="text-align: center !important;">Opis slike</th>
            <td style="text-align: center !important;"><input type="text" name="alt"  required ></td>
        </tr>
        <tr>
            <th style="text-align: center !important;">Novi hashtagovi</th>
            <td style="text-align: center !important;"><input type="text" name="hashtags"  >
                <p>(primer: #najnovije #vesti )</p></td>
        </tr>
        <tr>
            <th style="text-align: center !important;">Postojeći hashtagovi</th>
            <td style="text-align: center !important;">
    <select id="search" name="search[]" multiple class="form-control" >

        <?php
        global $connection;
        $sql = "SELECT DISTINCT hashtags FROM hashtags ORDER BY hashtags_id";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "<option>".$row['hashtags']."</option>";
            }
        } else {
            echo "0 results";
        }
        ?>
    </select></td>
        </tr>


        <tr>
            <th style="text-align: center !important;">Tip vesti</th>
            <td style="text-align: center !important;">
    <select name="newstype">
        <option>SRBIJA</option>
        <option>POLITIKA</option>
        <option>SPORT</option>
        <option>ZABAVA</option>
        <option>SVET</option>
        <option>POZNATI</option>
    </select>
            </td>
        </tr>

        <tr>
            <th style="text-align: center !important;">Naslovna slika</th>
            <td style="text-align: center !important;"><input type="file" name="images" required style="width: 70%;"></td>
        </tr>

        <tr>
            <th style="text-align: center !important;">Bitna vest</th>
            <td style="text-align: center !important;"><input type="checkbox" name="important_news" value="true" style="transform: scale(2);"></td>
        </tr>

        <tr>
            <th style="text-align: center !important;">Dodaj vest</th>
            <td style="text-align: center !important;">
                <input type="submit" class="btn btn-info" name="submit" value="Dodaj vest"></td>
        </tr>

    </table>
</form>
    <?php


    if(isset($_POST['editor']) && isset($_POST['title']) && isset($_POST['caption']) && isset($_POST['submit']) && isset($_POST['alt']) && isset($_POST['newstype']) && isset($_POST['hashtags'])  && isset($_SESSION['userId'])) {
        $creatorname= $_SESSION['userUid'];
        $text = $_POST['editor'];
        $title = $_POST['title'];
        $caption = $_POST['caption'];
        $images = $_FILES['images'];
        $imageName=$_FILES['images']['name'];
        $imageTmpName=$_FILES['images']['tmp_name'];
        $imageSize=$_FILES['images']['size'];
        $imageError=$_FILES['images']['error'];
        $imageType=$_FILES['images']['type'];

        $imageExt=explode('.',$imageName);
        $imageActualExt= strtolower(end($imageExt));

        $allowed=array('jpg','jpeg','png');
        if(in_array($imageActualExt, $allowed)){
            if($imageError===0){
                if($imageSize<10000000 ){
                    $imageNameNew=uniqid('',true).".".$imageActualExt;
                    $imageDestination='src/images/'.$imageNameNew;
                    move_uploaded_file($imageTmpName,$imageDestination);
                }
                else{

                    exit('<script>location.replace("createnews.php?error=imagesize");</script>');


                }
            }else{

                exit ('<script>location.replace("createnews.php?error=imageerror");</script>');
            }
        }
        else{
            exit ('<script>location.replace("createnews.php?error=badtype");</script>');
        }

        $alt = $_POST['alt'];
        $newstype = $_POST['newstype'];
        $hashtags = $_POST['hashtags'];

        if (isset($_POST['important_news'])) {
            $important_news = $_POST['important_news'];
        } else
            $important_news = 0;

        $error = NULL;
        if (!$error) {
            global $connection;


            $output_dir = "src/images/";

            $query = mysqli_query($connection, "INSERT INTO news (title,caption,images,alt,timeofinsert,newstype,content,important_news,approved,creator,creatorname,cookie_count) VALUES ('$title','$caption','$output_dir$imageNameNew','$alt',NOW(),'$newstype','$text',$important_news,0,'urednik','$creatorname',0)");

            if ($query) {
                $last_id = mysqli_insert_id($connection);
                echo  '<script>location.replace("createnews.php?success=newssuccess");</script>';

            } else {
                echo  '<script>location.replace("createnews.php?error=errornews");</script>';
            }

//pravljenje niza od stringa, a zatim izvlacenje svake vrednosti iz niza i upisivanje u bazu
   /* brojanje koliko ima hashtagova odnosno reci*/
   $number_of_hashtags = str_word_count($hashtags);
   /* razbijanje stringa u vrednosti koje se sada nalaze u nizu*/
   $exploded_hashtags= explode(" ",$hashtags);
   /*for petlja se vrti onoliko puta koliko ima hashtagova, i svaki put u promenljivu $hashtag stavlja novu vrednost iz niza*/
            for($i=0;$i<$number_of_hashtags;$i++) {
                $hashtag = $exploded_hashtags[$i];
                $sql = "SELECT * FROM hashtags WHERE hashtags='$hashtag'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "";
                    }
                } elseif (mysqli_num_rows($result) == 0) {
                    $query = mysqli_query($connection, "INSERT INTO hashtags (hashtags) VALUES ('$hashtag')");
                    if ($query) {
                        $sql = "SELECT * FROM hashtags WHERE hashtags='$hashtag'";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $hashtags_id = $row['hashtags_id'];
                                $query = mysqli_query($connection, "INSERT INTO hashtags_middle_table (hashtags_id,id) VALUES ('$hashtags_id','$last_id')");

                            }
                        }
                    }
                }
            }

            }
        //postojeci hashtagovi
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            foreach ($search as $search_temp) {
                $sql = "SELECT * FROM hashtags WHERE hashtags='$search_temp'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        $hashtags_id = $row['hashtags_id'];
                        $query = mysqli_query($connection, "INSERT INTO hashtags_middle_table (hashtags_id,id) VALUES ('$hashtags_id',$last_id)");
                    }
                } else {
                    echo "0 results";
                }
            }
        }

    }
    ?>

<script>
    //postojeci hashtagovi
    $(document).ready(function(){
        $('#search').multiselect({
            nonSelectedText: 'Izaberi hashtag',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth:'400px'
        });

        $('#search_form').on('submit', function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url:"createnews.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    $('#search option:selected').each(function(){
                        $(this).prop('selected', false);
                    });
                    $('#search').multiselect('refresh');
                    alert(data);
                }
            });
        });


    });
</script>


    <?php
    require "footer.php";
    ?>

</div>

    </div>
</div>

</body>

</html>
<?php } ?>