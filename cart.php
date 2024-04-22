<?php 
session_start();
    $user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";
    $user_order = $_SESSION['ACCOUNT_EMAIL'] . "_order";
    $self = $_SERVER['PHP_SELF'];
?>
<?php
//clear cart
if(isset($_GET['clear_cart'])){
    require "database-connection.php"; 
    $sql = "TRUNCATE TABLE `$user_cart`;";
    if(mysqli_query($con, $sql)){
        echo "<script> window.location = '$self' </script>";
    }else{
        die("smthin wrn");
    }
}
?>
<?php 
    $cart_count = 0;
    require "database-connection.php"; 
    $sql = "SELECT * FROM `$user_cart`";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $cart_count = $cart_count + 1;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
       <style>
       #loader{
          width: 100%;
          height: 100vh;
          position: fixed;
          top: 0;
          background-color: white;
          background-image: url('Shopping cart.gif');
          background-repeat: no-repeat;
          background-position: center;
          z-index: 9999999999999999999999999999999999999999999999999;
      }

       .underline_cart{
      border-bottom: 3px solid greenyellow;
      }
           #des{
       border:1px solid red;
       padding:10px;
       background:#82b74b;
       color:white;
       font-weight:600;
       word-spacing:4px;
       text-transform:uppercase;
       width:3.5cm;
       margin:10px;
       }
           div{
               width: 100%;
           }
           .redir{

               background-color: white;
               border: none;
               outline: none;
           }
       </style>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <script src="https://kit.fontawesome.com/9138881b2c.js" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
      <title>PHPJabbers.com | Free Mobile Store Website Template</title>
      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Additional CSS Files -->
      <link rel="stylesheet" href="assets/css/fontawesome.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/owl.css">
   </head>
   <body onload="completeload()">
   <!-- preloader ---->
  <div id="loader"></div>
  <!-- preloader ---->
   
      <?php require "header.php"; ?>
      <!-- Page Content -->
      <div class="page-heading header-text">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1>Checkout</h1>
                  <span>Cart (<?php echo $cart_count ?> Items)</span>
               </div>
            </div>
         </div>
      </div>
<?php 
if($cart_count == 0){
    // echoing if cart is empty
   echo "<h4 style='padding:50px 0 50px 0; font-weight:300; text-align:center;'> Cart is empty, Please <a href='products.php'> ADD </a> some products to cart </h4>";
}else{?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <button style='margin:5px; padding:5px; outline:none; float:right;' type="submit" name="clear_cart" value="clear">Clear Cart</button>
    </form>

<?php 
}
?>










<?php 
// fetching the users cart
    require "database-connection.php";
    $sql = "SELECT * FROM `$user_cart`";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $redirect_link = "http://mobile-shop.c1.biz/product-page.php?product_name=" . $row['p name'];
?>
      <!--Sstarts here-->
      <section>
         <div class="row">
         <div class="col-lg-8">
            <div class="mb-3">
               <div class="pt-4 wish-list">
                  <div class="row mb-4">
                     <div class="col-md-5 col-lg-3 col-xl-3">
                        <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                           <a href="<?php echo $redirect_link; ?>"><img class="img-fluid w-100 ml-4"
                              src="<?php echo $row['p img']; ?>" alt="Sample"></a>
                           <a href="#!">
                              <div class="mask">
                                 <div class="mask rgba-black-slight"></div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-7 col-lg-9 col-xl-9">
                        <div>
                           <div class="d-flex justify-content-between">
                              <div>
                                 
                                 <a style="color:black"; href="<?php echo $redirect_link; ?>"><h5 class="ml-2"><?php echo "{$row['p name']}"; ?></h5></a>
                                 <p class="mb-2 ml-3 text-muted text-uppercase small">Type : Smartphone</p>
                                 <p class="mb-2 ml-3 text-muted text-uppercase small">Color : <?php echo "{$row['p color']}"; ?></p>
                                 <p class="mb-2 ml-3 text-muted text-uppercase small">Quantity : <?php echo "{$row['p quantity']}"; ?></p>
                              </div>
                           </div>
                           <p class="mb-0 ml-5" ><span><strong id="summary"> Price : <?php echo number_format("{$row['p price']}"); ?></strong></span></p class="mb-0">
                           <div class="d-flex justify-content-between align-items-center">
                           
                              <div>
                                    <form action="del-from-cart.php" method="GET">
                                       <input type="hidden" name="product" value="<?php echo "{$row['p name']}"; ?>">
                                       <input type="hidden" name="quantity" value="<?php echo "{$row['p quantity']}"; ?>">
                                       <input type="hidden" name="color" value="<?php echo "{$row['p color']}"; ?>">
                                       <input id="des" type="submit" name="subbtn" value="remove item" class="card-link-secondary small ">
                                    </form>
                                    <form action="place-order.php" method="post">
                                    <input type="hidden" name="product" value="<?php echo $row['p name']; ?>">
                                    <input type="hidden" name="product_color" value="<?php echo $row['p color']; ?>">
                                    <input type="hidden" name="product_quantity" value="<?php echo $row['p quantity']; ?>">
                                   
                                    <input id="des"  name="order" class="card-link-secondary small " type="submit" value="order item">
                                    </form>
                                 </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr class="mb-4">
               </div>
            </div>
         </div>
        </div>
      </section>
      <!-- ends here -->
      
      <?php 
        }
    }
      ?>
      







      
      
      
      
      <?php require "footer.php"; ?>
      <script>
          function completeload(){
              document.getElementById('loader').style.display = "none";
          }
      </script>
   </body>
</html>

