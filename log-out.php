<?php
session_start();
  if(isset($_REQUEST['log-out'])){
    setcookie("email", "", time() - 3600);
    setcookie("password", "", time() - 3600);
    unset($_SESSION['ACCOUNT_EMAIL']);
    unset($_SESSION['ACCOUNT_PASSWORD']);
    session_unset();
    session_destroy();
    echo "<script> window.location = 'login.php'; </script>";
  }else{
  echo "<script> window.location = 'login.php'; </script>";
  }
?>