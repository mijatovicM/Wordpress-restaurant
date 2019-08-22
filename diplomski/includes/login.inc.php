<?php
if(isset($_POST['login-submit'])){
    require '../config/dbconfig.php';

    $mailuid=$_POST['mailuid'];
    $password=$_POST['pwd'];

    if (empty($mailuid) || empty($password)){
        header("Location: ../index.php?error=emptyfields");
        exit();
    }
    else{
        global $connection;
        $sql="SELECT * FROM users WHERE username=?;";
        $stmt=mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$mailuid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                $pwdCheck=password_verify($password, $row['password']);
                if($pwdCheck==false){
                    header("Location: ../index.php?error=wrongpassword");
                    exit();
                }
                if($row['Status']=='inactive'){
                    header("Location: ../index.php?error=inactive");
                    exit();
                }
                elseif ($pwdCheck==true){
                    session_start();
                    $_SESSION['userId']= $row['users_id'];
                    $_SESSION['userUid']= $row['username'];
                    $_SESSION['userType']=$row['type'];


                    if($_SESSION['userType']=='redakcija'){
                        header("Location: ../admin/index.php?login=success");
                        exit();
                    }
                    else {
                        header("Location: ../index.php?login=success");
                        exit();
                    }

                }
                else{
                    header("Location: ../index.php?error=wrongpassword");
                    exit();
                }
            }
            else{
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }
}
else{
    header("Location: ../index.php?");
exit();
}
?>