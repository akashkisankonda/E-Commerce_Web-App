<?php 
session_start();
$user_cart = $_SESSION['ACCOUNT_EMAIL'] . '_cart';
$self = 'cart.php';
if(isset($_REQUEST['subbtn'])){
    $product = $_GET['product'];
    $color = $_GET['color'];
    $quantity = (int) $_GET['quantity'];
    if($quantity < 1){
        die('inval_quantity');
    }
    if(!preg_match("/^([a-zA-Z ]+)$/",$color)){
        die('Invalid color given.');
    }
    if(!preg_match("/^([a-zA-Z0-9() ]+)$/",$product)){
        die('Invalid PRODUCT given.');
    }
   require "database-connection.php";
   $sql = "DELETE FROM `$user_cart` WHERE `p name`='$product' AND `p quantity`='$quantity' AND `p color`='$color';";
   if(mysqli_query($con, $sql)){
      echo "<script> window.location = '$self'; </script>";
   }else{
      die(mysqli_error($con));
   }
}
?>