<?php
session_start();

$product_name = $_SESSION['product_name'];


function checking_arrived_data_availablity($data){
  require "database-connection.php";
  $sql = "SELECT * FROM `reviews` WHERE `product_name`='$data';";
  $res = mysqli_query($con,$sql);
  if(mysqli_num_rows($res) > 0){
    return true;
  }else{
    return false;
  }
}

if(checking_arrived_data_availablity($product_name)){

$redirlink = 'http://mobile-shop.c1.biz/product-page.php?product_name='.$product_name;
$user_email = $_SESSION['ACCOUNT_EMAIL'];
if(isset($_REQUEST['del'])){
  require "database-connection.php";
  $sql = "DELETE FROM `reviews` WHERE email='$user_email' AND `product_name`='$product_name';";
  if(mysqli_query($con, $sql)){
    echo "<script> window.location = '$redirlink'; </script>";
  }else{
    die("mysqli_error($con)");
  }

}else{
        echo "<script> window.location = '$redirlink'; </script>";
}

}else{
die("invalid review delete");
}
?>