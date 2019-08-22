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

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3;min-height: 100vh;overflow:;hidden;display: block;  ">

    <?php
    require "header.php";
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "passwordlength") {
            echo '<div class="errordiv">Lozinka mora biti duža od 6 slova!</div>';
        } elseif ($_GET['error'] == "passwordcheck") {
            echo '<div class="errordiv">Unete lozinke se ne podudaraju!</div>';
        }
    }

    ?>

  <?php
include_once("../config/dbconfig.php");
global $connection;
  if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = mysqli_real_escape_string($connection, $_GET['email']);
    $token = mysqli_real_escape_string($connection, $_GET['token']);

    $sql_select = "SELECT users_id FROM `users` WHERE email = '".$email."' AND Token = '".$token."'";
    $result = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($result) > 0) {
      ?>
        <div class="registrationh1" style="margin-top: 10%">
            <h1 >Unesite novu lozinku
                <hr style="border-color:#808080;width: 80% "/>
            </h1>
        </div>

        <form class="form-signup" action="" method="post">
                <div class="input-group">
                    <span class="input-group-addon"  style="margin-left: 20%;"> <i class="fas fa-lock icons"></i></span>
                    <input  type="password" class="form-control" name="pwd" placeholder="Lozinka"/>
                </div>

                <br/><br/>
                <div class="input-group">
                    <span class="input-group-addon"  style="margin-left: 20%;"><i class="fas fa-lock icons"></i></span>
                    <input type="password" class="form-control" name="pwd-repeat" placeholder="Unesite ponovo lozinku"/>
                </div>
            <br/><br/>
                <button type="submit" class="btn btn-info" name="newpassword-submit">Promeni lozinku</button>
            </form>
            <?php
            $current_path = 'localhost/diplomski/forgotpassword/';
            $url = "http://".$current_path."resetPassword.php?token=$token&email=$email";
        if(isset($_POST['newpassword-submit'])) {
            $password = $_POST['pwd'];
            $passwordRepeat = $_POST['pwd-repeat'];

            if ($_POST['pwd'] !== $_POST['pwd-repeat']) {

          echo '<script>location.replace("'.$url.'&error=passwordcheck");</script>';

                exit();
            } elseif (strlen($_POST['pwd']) < 6) {
                echo '<script>location.replace("'.$url.'&error=passwordlength");</script>';
                exit();
            }


            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE `users` SET password = '" . $hashedPwd . "' WHERE email = '" . $email . "'";
            $sql_update2 = "UPDATE `users` SET Token = '' WHERE email = '" . $email . "'";
            mysqli_query($connection, $sql_update);
            mysqli_query($connection, $sql_update2);
            echo '<script>location.replace("http://localhost/diplomski/index.php?signup=success_forgot_password_change");</script>';
        }
    } else {
      echo "<div class=\"commentedh1\" style=\"margin-top: 20%;font-size: 40px\"><h1> Link nije validan ili ste već izmenili lozinku!</h1></div>";
    }

  } else {
    header("Location: ../index.php");
    exit();
  }

 ?>
    <?php
    require "../footer2.php";
    ?>
</div>
    </div>
</div>

</body>
</html>
