<?php 
session_start();
$self = $_SERVER['PHP_SELF'];
if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
   $user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";
   $user_order = $_SESSION['ACCOUNT_EMAIL'] . "_order";
}
//cancel order
if(isset($_REQUEST['subbtn'])){
   require "database-connection.php";
   $product = $_REQUEST['product'];
   $color = $_REQUEST['color'];
   $quantity = $_REQUEST['quantity'];
   $sql = "DELETE FROM `$user_order` WHERE `p name`='$product' AND `p color`='$color' AND `p quantity`='$quantity';";
   if(mysqli_query($con, $sql)){
      echo "<script> window.location = '$self'; </script>";
   }else{
      die(mysqli_error($con));
   }
}
?>
<?php 
if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
    $user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";
    $user_order = $_SESSION['ACCOUNT_EMAIL'] . "_order";
    if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
        $user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";
        $orders_count = 0;
        require "database-connection.php"; 
        $sql = "SELECT * FROM `$user_order`";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $orders_count = $orders_count + 1;
            }
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
       #des{
       border:1px solid red;
       padding:10px;
       background:#82b74b;
       color:white;
       font-weight:600;
       word-spacing:4px;
       }
       .underline_order{
      border-bottom: 2px solid greenyellow;
    }
           /* *{
               border: 1px solid red;
           } */
           div{
               width: 100%;
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
   <body onload="completeload()>
   <!-- preloader ---->
  <div id="loader"></div>
  <!-- preloader ---->
  
      <?php include "header.php"; ?>
      <!-- Page Content -->
      <div class="page-heading header-text">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1>My orders</h1>
                  <span>Orders (<?php echo $orders_count ?> Items)</span>
               </div>
            </div>
         </div>
      </div>

      <?php 
if($orders_count == 0){
   echo "<h4 style='padding:50px 0 50px 0; font-weight:300; text-align:center;'> Nothing Ordered, Please <a href='products.php'> Check </a> Our Products</h4>";
}
?>









<?php 
    require "database-connection.php";
    $sql = "SELECT * FROM `$user_order`";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
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
                           <a href="<?php echo $row['redir_order']; ?>"><img class="img-fluid w-100 ml-4"
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
                                 <a style="color:black;" href="<?php echo $row['redir_order']; ?>"><h5 class="ml-2"><?php echo "{$row['p name']}"; ?></h5></a>
                                 <p class="mb-2 ml-3 text-muted text-uppercase small">Type : Smartphone</p>
                                 <p class="mb-2 ml-3 text-muted text-uppercase small">Color : <?php echo "{$row['p color']}"; ?></p>
                                 <p class="mb-2 ml-3 text-muted text-uppercase small">Quantity : <?php echo "{$row['p quantity']}"; ?></p>
                              </div>
                           </div>
                           <p class="mb-0 ml-5" ><span><strong id="summary"> Price : <?php echo number_format("{$row['p price']}"); ?></strong></span></p class="mb-0">
                           <div class="d-flex justify-content-between align-items-center">
                           
                              <div>
                                    <form action="" method="post">
                                       <input type="hidden" name="product" value="<?php echo $row['p name']; ?>">
                                       <input type="hidden" name="quantity" value="<?php echo $row['p quantity']; ?>">
                                       <input type="hidden" name="color" value="<?php echo $row['p color']; ?>">
                                       
                                       <input id="des" type="submit" name="subbtn" value="Cancel order" class="card-link-secondary small text-uppercase ml-3 redir">
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
     <?php if($orders_count > 0){?>
    <h3 style="text-align: center; font-size:2.5vw; font-weight:300; color:red; padding:40px 0 40px 0;">Our employee will call you to confirm the order within 24HOURS, Please have patience.</h3>
     <?php }?>

      <?php include "footer.php"; ?>
      <script>
          function completeload(){
              document.getElementById('loader').style.display = "none";
          }
      </script>
   </body>
</html>
<?php 
}else{?>
    <?php echo "<script> window.location = 'cart.php'; </script>"; ?>
</html>
 <?php } ?>