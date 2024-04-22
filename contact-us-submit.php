<?php 
    function throww(){
echo "<script> window.location = 'contact.php' </script>";
    }
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$subject = $_REQUEST['sub'];
$message = $_REQUEST['message'];
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_REQUEST['contact-submit'])){
    //validating name
        if(!preg_match("/^([a-zA-Z' ]+)$/",$name)){
            throww();
        }
        // validating email 
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throww();
        }
        //setting
        if(empty($subject)){
            $subject = "EMPTY...";
        }
        if(empty($message)){
            $message = "EMPTY...";
        }
    require "database-connection.php";
    $name = mysqli_real_escape_string($con, $name);
    $email = mysqli_real_escape_string($con, $email);
    $subject = mysqli_real_escape_string($con, $subject);
    $message = mysqli_real_escape_string($con, $message);
    $sql = "INSERT INTO `contact` (`name`, `email`, `sub`, `message`, `ip`, `time`) VALUES ('$name', '$email', '$subject', '$message', '$ip', CURRENT_TIMESTAMP);";
    if(mysqli_query($con, $sql)){
        echo "<script> window.location = 'index.php' </script>";
    }else{
        die(mysqli_error($con));
    }



}

?>