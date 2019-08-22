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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

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
    <style>
        button.btn.btn-default.multiselect-clear-filter{
            visibility: hidden;
        }
    </style>
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
    if ($_GET['success'] == "deleted_hashtag") {
        echo "<div class='successdiv'> Uspešno ste izbrisali željene hashtagove!</div>";
    }
}
if(isset($_GET['success'])) {
    if ($_GET['success'] == "hashtag_changed") {
        echo "<div class='successdiv'> Uspešno ste izmenili hashtagove!</div>";
    }
}
?>
<div style="padding-left: 3%;padding-right: 3%;padding-bottom: 4%;padding-top: 2%;">
<form action="update_post.php" method="post">
    <h1 style="text-align: center">IZMENA VESTI</h1>

    <textarea class="ckeditor" name="editor">
        <?php
        $query=mysqli_query($connection,"SELECT * FROM news WHERE id='$id'");
        $row=mysqli_fetch_array($query);
        $content=$row['content'];
        echo $content;
        ?>
    </textarea>
    <table class='userchangetable' >
        <tr>
        <th style="text-align: center !important;">
    Naslov:
        </th>
        <?php
        $query=mysqli_query($connection,"SELECT * FROM news WHERE id='$id'");
        $row=mysqli_fetch_array($query);
        $title=$row['title'];
        echo '<td style="text-align: center !important;"><textarea name="editortitle" rows="4" cols="30">';
        echo $title;
        echo '</textarea></td>';
        ?>
        </tr>

    <br/>
        <tr>
        <th style="text-align: center !important;">
    Opis:
        </th>
    <?php
    $query=mysqli_query($connection,"SELECT * FROM news WHERE id='$id'");
    $row=mysqli_fetch_array($query);
    $caption=$row['caption'];
    echo '<td style="text-align: center !important;"><textarea name="editorcaption" rows="2" cols="30">';
    echo $caption;
    echo ' </textarea></td>';
    ?>
        </tr>
    <br/>
        <tr>
        <th style="text-align: center !important;">
    Opis slike:
        </th>

    <?php
    $query=mysqli_query($connection,"SELECT * FROM news WHERE id='$id'");
    $row=mysqli_fetch_array($query);
    echo '<td style="text-align: center !important;"><textarea name="editoralt" rows="1" cols="30">';
    $alt=$row['alt'];
    echo $alt;
    echo "</textarea></td>";
    ?>
        </tr>

<br/>


        <br/>
        <tr>
        <th style="text-align: center !important;">
        Tip vesti:</th>

    <td style="text-align: center !important;"><select name="editornewstype">

       <option> <?php
           $sql = "SELECT * FROM news WHERE id='$id'";
           $currentnewstype= $row["newstype"];
           $sql2 = "SELECT DISTINCT newstype FROM news WHERE newstype!='$currentnewstype'";
           $result = mysqli_query($connection, $sql);

           if (mysqli_num_rows($result) > 0) {

       echo $currentnewstype;
    }
    $result2 = mysqli_query($connection, $sql2);
    while ($row = mysqli_fetch_array($result2)) {
        $restnewstype=$row{'newstype'};
        echo "<option>" . $restnewstype . "</option>";
    }
        ?></option>
    </select></td>
        </tr>



    <br/>
        <tr>
   <th style="text-align: center !important;">Bitna vest:</th>
    <?php
    $query=mysqli_query($connection,"SELECT * FROM news WHERE id='$id'");
    $row=mysqli_fetch_array($query);
    $important_news=$row['important_news'];
    if($important_news==1) {
        echo '<input type="hidden" id="text1" value='.$important_news.' name="editor_important_news"/>';
        echo '<td style="text-align: center !important;"><input type="checkbox" id="checkbox1" checked style="transform: scale(2);"/></td>';
    }
    elseif ($important_news==0){
        echo '<input type="hidden" id="text1" value='.$important_news.' name="editor_important_news"/>';
        echo '<td style="text-align: center !important;"><input type="checkbox" id="checkbox1" style="transform: scale(2);"/></td>';

    }
    ?>
        </tr>

    <script>
        $("#checkbox1").click(function () {
            if ($(this).prop("checked")) {
                $("#text1").val("1");
            }
            else {
                $("#text1").val("0");
            }
        });
    </script>



    <input type="hidden" name="id" value="<?= $id ?>"/>
    <br/>
        <tr>
            <th style="text-align: center !important;">Izmena</th>
    <td style="text-align: center !important;"><button type="submit" class="btn btn-info">Izmeni vest</button></td>
        </tr>
    </table>

</form>

    <form action="" method="post">
        <table class='userchangetable table-responsive' >
            <tr>
                <th style="text-align: center !important;">
                    Hashtagovi:
                </th>
                <?php  echo '<td style="text-align: center !important;">';
                echo '<select id="search" name="search[]" multiple class="form-control" >';
                    global $connection;
                    $sql = "SELECT   h.*, m.*, n.* FROM hashtags h INNER JOIN hashtags_middle_table m  ON h.hashtags_id = m.hashtags_id INNER JOIN news n ON m.id = n.id  WHERE n.id='$id'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option>".$row['hashtags']."</option>";
                        }
                    } else {
                        echo "0 results";
                    }
                    if (isset($_POST['search'])) {
                        $search = $_POST['search'];


        echo '</select>';
        echo "</td>";

        foreach ($search as $search_temp) {
            $sql = "SELECT * FROM hashtags WHERE hashtags='$search_temp'";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $hashtags_id = $row['hashtags_id'];
                    $query = mysqli_query($connection, "DELETE FROM hashtags_middle_table WHERE id='$id' AND hashtags_id='$hashtags_id' ''");
                }
                if ($query){
                    echo ('<script>location.replace("updatenews.php?id='.$id.'&success=deleted_hashtag");</script>');


                }
                else{
                    echo "Došlo je do greške";
                }
            } else {
                echo "0 results";
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
            </tr>
                <tr>
                    <th style="text-align: center !important;">
                        Izbrišite hashtagove:
                    </th>
                <td style="text-align: center !important;"><button type="submit" class="btn btn-danger">Izbriši <i class="fas fa-trash-alt"></i></button></td>
            </tr>


        </table>
    </form>

            <form  action="update_hashtags_post.php" method="post">
                <table class='userchangetable'>
            <tr>
                <th style="text-align: center !important;">
                    Hashtagovi:
                </th>
                <?php
                $sql = "SELECT   h.*, m.*, n.* FROM hashtags h INNER JOIN hashtags_middle_table m  ON h.hashtags_id = m.hashtags_id INNER JOIN news n ON m.id = n.id  WHERE n.id='$id'";
                $result = mysqli_query($connection,$sql);
                echo '<td style="text-align: center !important;"><textarea name="editorhashtags" rows="4" cols="30">';
                while($row = mysqli_fetch_array($result)) {
                    $hashtags = $row['hashtags'];

                    echo $hashtags." ";

                }
                echo '</textarea> <p>(primer: #najnovije #vesti )</p></td>';
                ?>
            </tr>

            <br/>
            <input type="hidden" name="id" value="<?= $id ?>"/>
            <br/>

            <tr>
                <th style="text-align: center !important;">Izmeni</th>
                <td style="text-align: center !important;"><button type="submit" class="btn btn-info">Dodaj hastagove</button></td>
            </tr>
        </table>
    </form>


</div>
    <?php
    require "../footer.php";
    ?>
</div>
    </div>
</div>
</body>
</html>
<?php }?>