<?php
session_start();
if(isset($_POST['signup-submit'])){

    require '../config/dbconfig.php';


    $username=$_POST['uid'];
    $email=$_POST['mail'];
    $password=$_POST['pwd'];
    $passwordRepeat=$_POST['pwd-repeat'];
    $captcha=$_POST['captcha'];

    if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)|| empty($captcha)){
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ../signup.php?error=invalidmailuid");
        exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmail&uid=".$username);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    elseif ($password !== $passwordRepeat){
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    }
    elseif (strlen($password) <6){
        header("Location: ../signup.php?error=passwordlength&uid=".$username."&mail=".$email);
        exit();
    }
    else if ($_POST['captcha'] != $_SESSION['digit']) {
        header("Location: ../signup.php?error=captcha");


        session_destroy();
        exit();
    }
    else{
        global $connection;
        $sql="SELECT username FROM users WHERE username=?";
        $stmt=mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck>0){
                header("Location: ../signup.php?error=usertaken&mail=".$email);
                exit();
            }
            else{
                $sql="INSERT INTO users(`username`,`email`,`password`,`type`) VALUES (?,?,?,'korisnik')";
                $stmt=mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                else{
                    $hashedPwd=password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt,"sss",$username,$email,$hashedPwd);
                    mysqli_stmt_execute($stmt);
                    $mdpass=md5($_POST['pwd']);

                    $str = "03565emikmtroimfalsmhgzuxiucqnwdoweo324o0-tkerkm235_214rffhgkl";
                    $str = str_shuffle($str);
                    $str = substr($str, 0,32);
                    $current_path = 'localhost/diplomski/';

                    $sql_update = "UPDATE `users` SET registerToken ='".$str."' WHERE email = '".$email."'";
                    mysqli_query($connection, $sql_update);

                    echo " <div class=\"hashtag\" style=\"margin-top: 20%;height:50vh;\">
                <h1 >Za resetovanje lozinke, kliknite na link koji Vam je poslat na email !
                    
                </h1>
            </div>";



                  header("Location: ../signup.php?signup=success");
                    {
                        $current_path = 'localhost/diplomski/';
                        $to      = $_POST["mail"];
                        $subject = 'Registracija | Verifikacija';
                        $message = '

        Hvala na registraciji!
        Vas nalog je uspesno kreiran, mozete se prijaviti sa dole navedenim podacima nakon aktivacije naloga.

        ------------------------------------
        Korisnicko ime: '.$_POST["uid"].'
        Lozinka: '.$_POST["pwd"].'
        ------------------------------------

        Kliknite na ovaj link kako biste aktivirali svoj nalog:
       
        http://'.$current_path. 'verify.php?email='.$_POST["mail"].'&token='.$str.'';
                        $headers = 'From:izvestavajme@gmail.com' . "\r\n";
                        mail($to, $subject, $message, $headers);
                        echo "Uspesna registracija";
                    }

                    exit();
                }


            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}
else{
    header("Location: ../signup.php?");
}
?>