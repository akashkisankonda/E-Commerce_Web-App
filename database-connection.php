<?php 
$dbserver = "fdb27.biz.nf";
$dbusername = "3842403_ecommerce";
$dbpassword = "1261110@a";
$dbdatabase = "3842403_ecommerce";
$con = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
if(!$con){
  die(mysqli_connect_error());
}
?>