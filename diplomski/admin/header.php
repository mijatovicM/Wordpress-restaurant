
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="izvestavaj.me je novinarski portal koji Vas izveštava o najnovijim dešavanjima u svetu i regionu.">
    <meta name="keywords" content="novine, novinarski portal, dešsavanja u svetu,vesti iz sveta, vesti iz regiona, vesti iz politike, zabavne vesti, vesti o poznatima, sportske vesti,vesti,izvestavanja, dnevne vesti, najnovije vesti ">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content=izvestavaj.me>
</head>
<body>

<!--NAVBAR-->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php"><img src="../src/images/iLogo.jpg" height="50px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav nav-fill w-100">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">VESTI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../srbija.php">SRBIJA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../poznati.php">POZNATI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../zabava.php">ZABAVA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../svet.php">SVET</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="../sport.php">SPORT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../politika.php">POLITIKA</a>
            </li>
            <li class="nav-item">


                <div class="dropdown">
                    <?php
                    if(isset($_SESSION['userId']) && $_SESSION['userType'] == 'redakcija'){
                    echo '<i onclick="myFunction()"  class="fas fa-user-circle dropbtn nav-link glow" style="color: #fff; border-radius: 30px 30px;
        box-shadow: 0px 0px 15px #4aaf93; " ></i>';
                    echo'<div id="myDropdown" class="dropdown-content dropdown-menu-right">';
                    }
                    else{
                        echo'<i onclick="myFunction()"  class="fas fa-user-circle dropbtn nav-link" style="color: white" "></i>';
                        echo'<div id="myDropdown" class="dropdown-content dropdown-menu-right">';
                    }
                    ?>


                        <?php
                        if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija'){


                            echo '<div class="loggedInMessageDiv" style="width:250px;text-align: center;"><p class="loggedInMessage">Redakcija: '.$_SESSION['userUid']. '</p></div><hr style="border-color:#808080 "/>';

                            echo '<div style="font-family: Teko;color: #ffcb00;font-size: 25px"><a  href="index.php">Redakcija</a></div>
                    <hr style="border-color:#808080 "/>';

                            echo '<div style="font-family: Teko;color: #ffcb00;font-size: 25px"><a href="../commented.php">Komentarisane vesti</a></div>
                    <hr style="border-color:#808080 "/>';
                            echo '<div style="font-family: Teko;color: #ffcb00;font-size: 25px"><a href="../changeinfo.php">Izmenite informacije o sebi</a></div>
                    <hr style="border-color:#808080 "/>';
                            echo '<div style="font-family: Teko;color: #ffcb00;font-size: 25px"><a href="../saved.php">Sačuvane vesti</a></div>
                    <hr style="border-color:#808080 "/>';
                            echo '<div style="font-family: Teko;color: #ffcb00;font-size: 25px"><a href="../liked.php">Lajkovane vesti</a></div>
                    <hr style="border-color:#808080 "/>';



                        }


                        ?>




                    <?php
                    if(isset($_SESSION['userId']) && $_SESSION['userType'] == 'redakcija'){
                        echo ' <form action="../includes/logout.inc.php" method="post">
 <div class="logoutdiv">
            <button type="submit" name="logout-submit" class="btn btn-danger" style="margin-bottom:10% ">Odjavi se</button></div></form>';
                    }

                    ?>
                    </div>
                </div>

                <script>
                    /* When the user clicks on the button,
                    toggle between hiding and showing the dropdown content */
                    function myFunction() {
                        document.getElementById("myDropdown").classList.toggle("show");
                    }

                    // Close the dropdown if the user clicks outside of it
                    window.onclick = function(event) {
                        if (!event.target.matches('.dropbtn')) {

                            var dropdowns = document.getElementsByClassName("dropdown-content");
                            var i;
                            for (i = 0; i < dropdowns.length; i++) {
                                var openDropdown = dropdowns[i];
                                if (openDropdown.classList.contains('show')) {
                                    openDropdown.classList.remove('show');
                                }
                            }
                        }
                    }
                </script>
            </li>
        </ul>
    </div>
</nav>
<!--END OF NAVBAR-->

</body>
</html>