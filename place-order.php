<?php
session_start();
$user_order = $_SESSION['ACCOUNT_EMAIL'] . "_order";
$user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";
function existancecheck($product, $quantity, $color){
   global $user_order;
   require "database-connection.php";
   $sql = "SELECT * FROM `$user_order` WHERE `p name`='$product' AND `p quantity`='$quantity' AND `p color`='$color';";
   $result = mysqli_query($con, $sql);
   if(mysqli_num_rows($result) > 0){
      return true;
   }else{
      return false;
   }
}
function product_val($data){
if(!preg_match("/^([a-zA-Z0-9() ]+)$/",$data)){
    die('Invalid product given.');
        }
        return $data;
}
function color_val($data){
if(!preg_match("/^([a-zA-Z ]+)$/",$data)){
    die('Invalid color given.');
        }
        return $data;
}
function quantity_val($data){
if($data < 1){
die("inval quantity"); 
}
return (int) $data;
}

if(isset($_REQUEST['order'])){
   $product = product_val($_REQUEST['product']);
   $quantity = quantity_val($_REQUEST['product_quantity']);
   $color = color_val($_REQUEST['product_color']);
   if(existancecheck($product, $quantity, $color)){
      echo "<script> window.location = 'order-page.php'; </script>";
   }else{
   require "database-connection.php";
   $product = $_REQUEST['product'];
   $sql = "SELECT * FROM `$user_cart` WHERE `p name`='$product' AND `p color`='$color' AND `p quantity`='$quantity';";
   $result = mysqli_query($con, $sql);
   if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
         $gotproduct = $row['p name'];
         $gotprice = $row['p price'];
         $gotquantity = $row['p quantity'];
         $gotimg = $row['p img'];
         $gotcolor = $row['p color'];
      }
   }
   $sql = "INSERT INTO `$user_order` (`p name`, `p price`, `p quantity`, `p img`, `p color`) VALUES ('$gotproduct', '$gotprice', '$gotquantity', '$gotimg', '$gotcolor');";
   if(mysqli_query($con, $sql)){
      echo "<script> window.location = 'order-page.php'; </script>";
    
   }else{
      die(mysqli_error($con));
   }
}
}
?>