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

        <div class="clearfix" id="firstwrapper" style="margin-right: 0%;margin-left: 0%; position: relative; z-index: 3;min-height: 100vh;overflow: hidden;display: block; ">
  <?php
        require "header.php";
        ?>

            <div style="min-height: 60vh;overflow: hidden;display: block;">
            <div class="registrationh1" style="margin-top: 10%;">
                <h1 >Zaboravljena lozinka
                    <hr style="border-color:#808080;width: 80% "/>
                </h1>
            </div>

  <form method="post" class="form-signup" action="forgotPassword.php" id="forgotPasswordForm" style="margin-bottom: 10%;">

      <div class="input-group">
          <span class="input-group-addon" style="margin-left: 20%;"><i class="fas fa-envelope icons"></i></span>
          <input type="text" name="forgotPassword" id="forgotPassword" placeholder="E-mail" class="form-control">
      </div>



<div style="margin-top: 5%">
    <button type="submit" class="btn btn-info">Pošalji</button>
    <button type="reset" class="btn btn-danger">Otkaži</button>
</div>
  </form>
<div style="height:3vh;"></div>
            </div>
<br/>

            <?php
            require "../footer2.php";
            ?>

<script>

  function forgotPassword() {
    $.ajax({

      data:
    })
  }

</script>

        </div>
    </div>
</div>
</body>
</html>
