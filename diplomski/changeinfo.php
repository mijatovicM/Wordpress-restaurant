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


</head>
<body>
<div>
    <div style="position: fixed; z-index: 1;" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div style="background-color: white;margin-right: 11%; margin-left: 11%;position: relative; z-index: 2;">

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3; ">
    <?php
    global $connection;
    require "header.php";

    if(isset($_GET['error'])) {
        if ($_GET['error'] == "usernameexist") {
            $messagecomment = "Korisnik sa tim korisničkim imenom već postoji!";
            echo "<div class='errordiv'>$messagecomment</div>";
        }
    }
    if(isset($_GET['success'])) {
        if ($_GET['success'] == "passwordchanged") {
            echo "<div class='successdiv'>Lozinka promenjena!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "passwordnotmatching") {
            echo "<div class='errordiv'>Lozinke se ne podudaraju!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "passwordlength") {
            echo "<div class='errordiv'>Lozinka mora biti dužine najmanje 6 karaktera!</div>";
        }
    }
    if(isset($_GET['error'])) {
        if ($_GET['error'] == "passwordcurrent") {
            echo "<div class='errordiv'>Netačna trenutna lozinka!</div>";
        }
    }
    if(isset($_GET['success'])) {
        if ($_GET['success'] == "newsletteryes") {
            echo "<div class='successdiv'>Prijavili ste se na newsletter!</div>";
        }
    }
    if(isset($_GET['success'])) {
        if ($_GET['success'] == "newsletterno") {
            echo "<div class='successdiv'>Odjavili ste se sa newslettera!</div>";
        }
    }



                        $userid=$_SESSION['userId'];
                        $username= $_SESSION['userUid'];
                        echo "<form action='' method='post' style='margin-top: 7%;margin-bottom: 3%;'>";

                                echo "<table class='userchangetable'>";
                                echo "<tr>";
                                echo "<th style='border: '>Korisničko ime</th>";
                                echo "<th>Izmena</th>";
                                echo "</tr>";


                                $sql="SELECT * FROM users WHERE users_id='$userid'";

                                $result=mysqli_query($connection,$sql)or die(mysqli_error($connection));
                                if(mysqli_num_rows($result)>0){

                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {

                                        $username = $row['username'];
                                        $email = $row['email'];
                                        $type = $row['type'];
                                        $id=$row['users_id'];
                                        echo "<tr>";

                                            $query=mysqli_query($connection,"SELECT * FROM users WHERE username='$username'");
                                            $row=mysqli_fetch_array($query);
                                            echo "<td><textarea rows=\"1\" cols=\"30\" name=\"username\">";
                                            echo $username;
                                            echo "</textarea></td>";
                                            echo "<td><button style='margin-top: 3%' class='btn btn-info' type='submit'>Ažuriraj</button> </td>";
                                        usernameupdate($connection);
                                        ?>
                                        <input type="hidden" name="id" value="<?= $userid ?>"/>
                                        <?php
                                        echo "</table>";
                                        echo "</form>";


                                    }}


function usernameupdate($connection)
{
    if (isset($_POST['username'])) {
        $editorUsername = $_POST['username'];

        $id = $_POST['id'];
        include "config/dbconfig.php";

        $sql = "SELECT * FROM users WHERE username='$editorUsername'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                exit ('<script> location.replace("changeinfo.php?error=usernameexist");</script>');

            }
        }

        $query = mysqli_query($connection, "UPDATE users SET username='$editorUsername' WHERE users_id='$id'");
        if ($query) {
            echo '<script> location.replace("index.php?success=changed");</script>';
            session_destroy();
        } else {
            echo '<script>location.replace("index.php?success=errrorchange");</script>';
        }
    } else {
        //Not performing any action
    }
}





?>


    <form action="" method="post" style="margin-top: 7%;margin-bottom: 3%;">
        <table class='userchangetable'>
            <tr>
                <th style="text-align: center !important;">Izmena lozinke</th>
            </tr>
                <tr>
               <td style="text-align: center !important;">
                   <input type="password" name="currentpassword" placeholder="Trenutna lozinka"
               </td>
                </tr>
            <tr>
                <td style="text-align: center !important;">
                    <input type="password" name="newpassword" placeholder="Nova lozinka"
                </td>
            </tr>
            <tr>
                <td style="text-align: center !important;">
                    <input type="password" name="confirmpassword" placeholder="Ponovi lozinku"
                </td>
            </tr>
            <tr>

                <td style="text-align: center !important;">
                    <button type="submit"  class='btn btn-info' name="submit_password" value="Change">Promeni lozinku</button>
                </td>

            </tr>
        </table>

    </form>

    <?php
    if(isset($_POST['currentpassword']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword'])) {
        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];


        if (isset($_POST['submit_password'])) {
            $sql = "SELECT * FROM users WHERE username='$username'";

            $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $get_pass = $row['password'];
                    $pwdCheck = password_verify($currentpassword, $row['password']);
                    $newPwd=password_hash($newpassword, PASSWORD_DEFAULT);

                    if ($pwdCheck == $get_pass) {
                        if (strlen($newpassword) >= 6) {
                            if ($confirmpassword == $newpassword) {
                                $sql = mysqli_query($connection, "UPDATE users SET password='$newPwd' WHERE username='$username'");
                                echo '<script>location.replace("changeinfo.php?success=passwordchanged");</script>';
                            }
                            else {
                                echo '<script>location.replace("changeinfo.php?error=passwordnotmatching");</script>';
                            }
                        } else {
                            echo '<script>location.replace("changeinfo.php?error=passwordlength");</script>';
                        }
                    }
                     else {
                        echo '<script>location.replace("changeinfo.php?error=passwordcurrent");</script>';
                    }
                }
            }
        }
    }
    ?>
    <form action="" method="post" style="margin-top: 7%;margin-bottom: 3%;">
        <table class='userchangetable'>
            <tr>
                <th style="text-align: center !important;">Newsletter</th>
                <td style="text-align: center !important;">
                    <?php
                    $sql = "SELECT * FROM users WHERE users_id='$userid'";
                    $result = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $newsletter=$row['newsletter'];
                            if($newsletter=='no') {
                                echo ' <button type="submit" class="btn btn-info" name="newsletteryes">Prijavi se</button>';
                            }
                            elseif($newsletter=='yes'){
                                echo ' <button type="submit" class="btn btn-danger" name="newsletterno">Odjavi se</button>';

                            }
                        }
                    }

                    ?>
                </td>
            </tr>
        </table>
    </form>
    <?php
    if(isset($_POST['newsletteryes'])) {
        $newsletteryes = $_POST['newsletteryes'];
        $select = "UPDATE users SET newsletter='yes' WHERE users_id='$userid'";
        $query = mysqli_query($connection, $select) or die($select);
        echo "<script>location.replace('changeinfo.php?success=newsletteryes');</script>";
    }
    elseif(isset($_POST['newsletterno'])) {
        $newsletterno = $_POST['newsletterno'];
        $select = "UPDATE users SET newsletter='no' WHERE users_id='$userid'";
        $query = mysqli_query($connection, $select) or die($select);
        echo "<script>location.replace('changeinfo.php?success=newsletterno');</script>";
    }
    ?>


            <?php
    require "footer.php";
    ?>
</div>

    </div>
</div>



</body>


</html>