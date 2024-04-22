<?php 
session_start();
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
function checking_if_already_liked($email, $review_id){
    require 'database-connection.php';
    $sql = "SELECT * FROM `review ld` where `email`='$email' AND `review id`='$review_id'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) > 0){
        die("already liked");
    }
}
$review_id = checking_if_review_available($_GET['review_id']);
$useremail = $_SESSION['ACCOUNT_EMAIL'];
$status = 'Like';
$redir_link = "product-page.php?product_name=" . $_SESSION['product_name'];
checking_if_already_liked($useremail, $review_id);
require 'database-connection.php';
$sql = "INSERT INTO `review ld` (`review id`, `email`, `status`) VALUES ('$review_id', '$useremail', '$status');";
if(mysqli_query($con, $sql)){
    echo "<script> window.location = '$redir_link' </script>";
}else{
 
    die(" nt insert");
}

?>