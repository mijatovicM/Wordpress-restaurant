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
    <link href="https://fonts.googleapis.com/css?family=Teko|PT+Sans|Permanent+Marker|Oswald|Kalam" rel="stylesheet">
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


        <?php
        if(isset($_GET['error'])){
            if($_GET['error']=="emptyfields"){
               echo '<div class="errordiv">Popunite sva polja</div>';
            }
            elseif ($_GET['error']=="invaliduidmail"){
                echo '<div class="errordiv">Netačno korisničko ime i e-mail!</div>';

            }
            elseif ($_GET['error']=="invaliduid"){
                echo '<div class="errordiv">Netačno korisničko ime!</div>';
            }
            elseif ($_GET['error']=="invalidmail"){
                echo '<div class="errordiv">Netačan e-mail!</div>';
            }
            elseif ($_GET['error']=="passwordcheck"){
                echo '<div class="errordiv">Unete lozinke se ne podudaraju!</div>';
            }
            elseif ($_GET['error']=="usertaken"){
                echo '<div class="errordiv">Korisničko ime već postoji!</div>';
            }
            elseif ($_GET['error']=="passwordlength"){
                echo '<div class="errordiv">Lozinka mora biti duža od 6 slova!</div>';
            }
            elseif ($_GET['error']=="captcha"){
                echo '<div class="errordiv">Sigurnosni kod koji ste uneli je netačan!</div>';
            }

        }
        if(isset($_GET['signup'])){
        if ($_GET['signup']=="success") {
            echo '<div class="successdiv">Uspešno ste se registrovali, kliknite na aktivacioni link koji Vam je poslat na e-mail!</div>';
        }
        }
        ?>

        <div class="registrationh1">
        <h1 >Registracija
            <hr style="border-color:#808080;width: 80% "/>
        </h1>
        </div>
        <form class="form-signup" action="includes/signup.inc.php" onsubmit="return checkForm(this)" method="post">
            <div class="input-group">
                <span class="input-group-addon" style="margin-left: 20%;"><i class="fas fa-user icons"></i></span>
              <input type="text" class="form-control"  name="uid" placeholder="Korisničko ime"/>
            </div>

            <br/><br/>
            <div class="input-group">
                <span class="input-group-addon"  style="margin-left: 20%;"><i class="fas fa-envelope icons"></i></span>
                <input type="text" class="form-control" name="mail" placeholder="E-mail"/>
            </div>

            <br/><br/>
            <div class="input-group">
                <span class="input-group-addon"  style="margin-left: 20%;"> <i class="fas fa-lock icons"></i></span>
                <input  type="password" class="form-control" name="pwd" placeholder="Lozinka"/>
            </div>

            <br/><br/>
            <div class="input-group">
                <span class="input-group-addon"  style="margin-left: 20%;"><i class="fas fa-lock icons"></i></span>
                <input type="password" class="form-control" name="pwd-repeat" placeholder="Unesite ponovo lozinku"/>
            </div>
            <br/>
            <div>
            <p><img src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
            <p><input type="text" size="6" maxlength="5" name="captcha" value="" style="border-radius: 0%;margin-right: 0%;"/><br/><br/>
                <small style="color:#fff;font-family: 'Kalam', cursive;font-size: 15px">Unesite sigurnosni kod koji se nalazi u polju iznad</small></p>

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


            <br/>
            <button type="submit" class="btn btn-info" name="signup-submit">Registruj se</button>

        </form>
        <?php
        require "footer.php";
        ?>
    </div>
        </div>
    </div>
</body>
</html>

