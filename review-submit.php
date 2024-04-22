<?php
session_start();
function filtering_arrived_data($data){
$data = htmlspecialchars($data, ENT_QUOTES);
$data = trim($data);
$data = stripslashes($data);
return $data;
}
$product_review_insertion = $_SESSION['product_name'];
function filtering_rating($data){
    if($data < 1 || $data > 5){
        die('inval stars');
    }else{
        return (int) $data;
    }
}


function checking_arrived_data_availablity($data){
  require "database-connection.php";
  $data = mysqli_real_escape_string($con, $data);
  $sql = "SELECT * FROM `products` WHERE `p name`='$data';";
  $res = mysqli_query($con,$sql);
  if(mysqli_num_rows($res) > 0){
    return true;
  }else{
    return false;
  }
}



if(checking_arrived_data_availablity($product_review_insertion)){
$product_id;
function finding_id($product){
  global $product_id;
  require "database-connection.php";
  $product = mysqli_real_escape_string($con, $product);
  $sql = "SELECT * FROM `products` WHERE `p name`='$product';";
  $result = mysqli_query($con, $sql);
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $product_id = $row['id'];
    }
  }
}
finding_id($product_review_insertion);



$user_email = $_SESSION['ACCOUNT_EMAIL'];
function getting_user_id($email){
    require 'database-connection.php';
    $sql = "SELECT * FROM accounts WHERE email='$email';";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            return $row['id'];
        }
    }else{
        die('no user id found');
    }
}
$redir_link = "product-page.php?product_name=".$product_review_insertion;
$user_acc_id = getting_user_id($user_email);
function securing($data){
$data = str_replace("'","",$data);
$data = str_replace("''","",$data);
$data = str_replace("--","",$data);
return $data;
}

//image code here
function image_verification(){
    if(isset($_FILES['image'])){
    $target_destination = "assets/images/review_images/";
    $file_name_with_extinsion = $_FILES['image']['name'];
    $file_extinsion = strtolower(pathinfo($file_name_with_extinsion, PATHINFO_EXTENSION));
    if($file_extinsion == 'jpg' || $file_extinsion == 'jpeg' || $file_extinsion == 'png' || $file_extinsion == 'gif' || $file_extinsion == 'tif' || $file_extinsion == 'tiff'){
    $exploded = explode(".",$file_name_with_extinsion);
    $exploded[0] = rand();
    $transformation = $exploded[0] . ".$file_extinsion";
    $_FILES['image']['name'] = $transformation;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], "$target_destination{$_FILES['image']['name']}");
    if($res){
        return $target_destination.$_FILES['image']['name'];
    }else{
        return '';
    }
    }
    }
    }

if(isset($_POST['rate'])){
  $rating = filtering_rating($_POST['rate']);
  if(strlen($_POST['review']) > 0){
  //for now only allowing chars as reviews because i lack sql injection knowledge
    $review = securing($_POST['review']);
  }else{
    $review = '';
  }
  require "database-connection.php";
  $review = mysqli_real_escape_string($con, $review);
  $image = image_verification();
  $sql = "INSERT INTO `reviews` (`product_id`, `user_acc_id`,`product_name`,`email`, `rating`, `review`, `image`, `time`) VALUES ('$product_id', '$user_acc_id','$product_review_insertion','$user_email', '$rating', '$review', '$image', current_timestamp());";
  if(mysqli_query($con, $sql)){
    echo "<script> window.location = '$redir_link'; </script>";
  }else{
    die(mysqli_error($con));
  }
}else{
    echo "<script> window.location = '$redir_link'; </script>";
}

}else{
die("unavailable product name");
}