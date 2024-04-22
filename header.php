<?php
//unsetting this session because dont need it out of product-page
unset($_SESSION['product_name']);

if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
    require 'database-connection.php';
    $email = mysqli_real_escape_string($con, $_COOKIE['email']);
    $password = mysqli_real_escape_string($con, $_COOKIE['password']);
    $sql = "SELECT * FROM `accounts` WHERE `email`='$email';";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
    $password = password_verify($password, $row['password']);
    if($password){
        $_SESSION['ACCOUNT_EMAIL'] = $email;
        $_SESSION['ACCOUNT_PASSWORD'] = $password;
    }
    }
    }
}
  if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
    $user_order = $_SESSION['ACCOUNT_EMAIL'] . "_order";
    $user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";
    //cart counting
    $cart_count = 0;
    require "database-connection.php"; 
    $sql = "SELECT * FROM `$user_cart`";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $cart_count = $cart_count + 1;
        }
    }
    //orders counting
    $order_count = 0;
    require "database-connection.php"; 
    $sql = "SELECT * FROM `$user_order`";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $order_count = $order_count + 1;
        }
    }
  }
?>

<html>
<head>
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Additional CSS Files -->
        <link rel="stylesheet" href="assets/css/fontawesome.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/owl.css">
        <link rel="shortcut icon" href="web-logo.ico">

                <meta name="description" content="SOUL property of Akash Konda ( E-COM website )">
                <meta name="author" content="Akash Konda">
        </head>
        <style>
        .log-out{
        background-color: transparent;
        border: none;
        outline: none;
        color: greenyellow;
        text-align: center;
        width: 100%;
        }
        .registerbtn {
        display: block;
        text-align: center;
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
        color: white;
        }
        </style>
    <body>
<!-- ***** Preloader Start ***** -->

    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <ul class="left-info">
              <li><a href="mailto:kisankonda0@gmail.com"><i class="fa fa-envelope"></i>kisankonda0@gmail.com</a></li>
              <li><a href="tel:+917620264936"><i class="fa fa-phone"></i>+917620264936</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="right-icons">
              <li><a href="https://www.facebook.com/me/"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://twitter.com/Akash99428536"><i class="fa fa-twitter"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.php"><h2>Mobiles<em> </em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link underline_home" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link underline_products" href="products.php">Products</a>
              </li>
              <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){ ?>
              <li class="nav-item">
                <a class="nav-link  underline_account" href="account.php">My account</a>
              </li>
              <?php } ?>
              <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){ ?>
              <li class="nav-item">
                <a class="nav-link underline_cart" href="cart.php">Cart <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){echo "($cart_count)";} ?></a>
              </li>
              <?php } ?>
              <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){ ?>
              <li class="nav-item">
                <a class="nav-link underline_order" href="order-page.php">My orders <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){echo "($order_count)";} ?></a>
              </li>
              <?php } ?>
            
              <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){ ?>
              <li class="nav-item">
              <form style="margin:3px;" action="log-out.php" method="post">
                <input type="submit" class="log-out nav-link" name="log-out" value="Log out">
                </form>
              </li>
              <?php }else{ ?>
                <li class="nav-item">
                <a class="nav-link underline_login" href="login.php">Log in</a>
              </li>
              <?php } if(!isset($_SESSION['ACCOUNT_EMAIL']) && !isset($_SESSION['ACCOUNT_PASSWORD'])){ ?>
              <li class="nav-item">
                <a class="nav-link underline_rg" href="register.php">Sign Up</a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    </body>
</html>