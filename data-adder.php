<?php
    if($_POST){
        $product_title = $_REQUEST['product_title'] ; 
        $product_price = $_REQUEST['product_price'] ;
        $product_short = $_REQUEST['product_short'] ; 
        $product_big = $_REQUEST['product_big'] ;
        $product_about = $_REQUEST['product_about'] ; 
        $product_img1 = $_REQUEST['product_img1'] ; 
        $product_img2 = $_REQUEST['product_img2'] ; 
        $product_img3 = $_REQUEST['product_img3'] ;
        $product_col1 = $_REQUEST['product_col1'] ;
        $product_col2 = $_REQUEST['product_col2'] ; 
        $product_col3 = $_REQUEST['product_col3'] ;
    $dbserver = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbdatabase = "ecommerce";
    $con = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
    if(!$con){
        die(mysqli_connect_error());
    }
    $sql = "INSERT INTO products (`p name`, `p price`, `p short`, `p big`, `p about`, `img 1`, `img 2`, `img 3`, `color 1`, `color 2`, `color 3`) VALUES ('$product_title','$product_price','$product_short','$product_big','$product_about','$product_img1','$product_img2','$product_img3','$product_col1','$product_col2','$product_col3')";
    if(mysqli_query($con, $sql)){
    //     echo "<script> alert('success'); </script>";
    die("success");
     }else{
        // echo "<script> alert('smthing wrng'); </script>";
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
input{
    width: 90%
    ;
}
</style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="product_title" placeholder="product_title"><br><br>
        <input type="text" name="product_price" placeholder="product_price"><br><br>
        <input type="text" name="product_short" placeholder="product_short"><br><br>
        <input type="text" name="product_big" placeholder="product_big"><br><br>
        <input type="text" name="product_about" placeholder="product_about"><br><br>
        <input type="text" name="product_img1" placeholder="product_img1"><br><br>
        <input type="text" name="product_img2" placeholder="product_img2"><br><br>
        <input type="text" name="product_img3" placeholder="product_img3"><br><br>
        <input type="text" name="product_col1" placeholder="product_col1"><br><br>
        <input type="text" name="product_col2" placeholder="product_col2"><br><br>
        <input type="text" name="product_col3" placeholder="product_col3"><br><br><br><br>
        <input type="submit" value="Submit">




    </form>
</body>
</html>