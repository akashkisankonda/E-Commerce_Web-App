<?php
session_start();
$self = $_SERVER['PHP_SELF'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
            unset($_SESSION['v_email']);
        }else{
            $_SESSION['v_email'] = "set";
        }
        if(!empty($password) && strlen($password) > 5){
            unset($_SESSION['v_password']);
        }else{
            $_SESSION['v_password'] = "set";
        }
        if($password == "123456" || $password == "1234567" || $password == "12345678" || $password == "123456789" || $password == "1234567890"){
            $_SESSION['we_v_password'] = "set";
        }else{
            unset($_SESSION['we_v_password']);
        }
        if(!isset($_SESSION['v_email']) && !isset($_SESSION['v_password'])  && !isset($_SESSION['we_v_password'])){
            $server = 'localhost';
            $username = 'root';
            $dbpassword = '';
            $database = 'ecommerce';
            $con = mysqli_connect($server, $username, $dbpassword, $database);
            if(!$con){
                die('connect erro ' .mysqli_connect_error());
            }
            $sql = "UPDATE accounts SET password='$password' WHERE email='$email';";
            if(mysqli_query($con, $sql)){
                unset($_SESSION['we_v_password']);
                unset($_SESSION['v_email']);
                unset($_SESSION['v_password']);
                session_unset();
                session_destroy();
                echo "<script>window.location = 'login.php'; </script>";
            }else{
                die(mysqli_error($con));
                $_SESSION['v_email'] = "set";
                echo "<script>window.location = '$self'; </script>";
            }
        }
        echo "<script>window.location = '$self'; </script>";
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: black;
}

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
#show_error{
    color: red;
    padding: 10px;
    border:2px solid red;
    background-color: #800000;
    text-transform: capitalize;
}
</style>
</head>
<body>

<form action="" method="POST" autocomplete="off">
  <div class="container">
    <h1>Forgot Password</h1>
    <p>Please fill in this form to reset password.</p>
    <hr>
    <?php if(isset($_SESSION['v_email'])){ echo "<p id='show_error'>email invalid</p>";} ?>
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email">
    <?php if(isset($_SESSION['v_password'])){ echo "<p id='show_error'>email invalid</p>";} ?>
    <label for="psw"><b>New Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="psw" autocomplete="new-password">
    <?php if(isset($_SESSION['we_v_password'])){ echo "<p id='show_error'>weak password</p>"; }?>
    

    <button type="submit" class="registerbtn">Reset</button>
  </div>
  

</form>

</body>
</html>
