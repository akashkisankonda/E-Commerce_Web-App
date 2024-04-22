<?php 
session_start();
//unsetting previously set session variable
session_unset();

class log_in{
public $email;
public $password;
public $remember;
function __construct($data)
{
    $this->email = $data['email'];
    $this->password = $data['password'];
    $this->remember = $data['check'];
}
function checking(){
    require "database-connection.php";
    $email = mysqli_real_escape_string($con, $this->email);
    $password = mysqli_real_escape_string($con, $this->password); 
    $sql = "SELECT * FROM `accounts` WHERE `email`='$email';";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        $fetched = mysqli_fetch_row($result);
    }
    if(mysqli_num_rows($result) > 0 && password_verify($password, $fetched[4])){
        $_SESSION['ACCOUNT_EMAIL'] = $email;
        $_SESSION['ACCOUNT_PASSWORD'] = $password;
        if(isset($_POST['remember'])){
            setcookie('email', $_SESSION['ACCOUNT_EMAIL'], time() + (86400 * 30), "/");
            setcookie('password', $_SESSION['ACCOUNT_PASSWORD'], time() + (86400 * 30), "/");
        }
        echo "<script>window.location = 'index.php'; </script>";
    }else{
        $_SESSION['inval_credintials'] = 'set';
        $_SESSION['email_value'] = $email;
        echo "<script>window.location = 'login.php'; </script>";
    }
}
}
if($_POST){
$data = array('email' => addslashes(strtolower("{$_POST['email']}")), 'password' => addslashes("{$_POST['password']}"));
$process = new log_in($data);
$process->checking();
}else{
    echo "<script>window.location = 'login.php'; </script>";
}
?>
