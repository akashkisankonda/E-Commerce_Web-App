<?php
session_start();
//i am an ideot how can i access global variable in function 'nonsense'
$user_email = $_SESSION['ACCOUNT_EMAIL'];
$redirect_link = 'product-page.php?product_name=' . $_SESSION['product_name'];
function checking_if_review_available($data){
    require 'database-connection.php';
    $sql = "SELECT * FROM `reviews` WHERE `id`='$data';";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) > 0){
    return $data;
    }else{
    die("id nt found");
    }
}
function checking_if_liked($data){
    global $user_email;
    require 'database-connection.php';
    $sql = "SELECT * FROM `review ld` WHERE `email`='$user_email' AND `review id`='$data';";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        return $data;
    }else{
        die("not liked");
    }
}

$review_id = checking_if_liked(checking_if_review_available($_GET['review_id']));
require 'database-connection.php';
$sql = "DELETE FROM `review ld` WHERE `email`='$user_email' AND `review id`='$review_id';";
$result = mysqli_query($con,$sql);
if($result){
    echo "<script> window.location = '$redirect_link' </script>";
}else{
    die("smtn wrng");
}


?>