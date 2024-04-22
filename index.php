<?php
   session_start();
   //$result is to hold the mysqli result while communicating to database
   $result;
   function searching_specific_data($table_name, $to_find){
        global $result;
        require "database-connection.php";            
        $sql = "SELECT * FROM $table_name WHERE status='$to_find';";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
   }
   function discount_cal($actual_price, $discount_price){
    $diff = $actual_price - $discount_price ;
    $result = ($diff / $actual_price) * 100;
    return round($result);
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
       <script src="https://kit.fontawesome.com/9138881b2c.js" crossorigin="anonymous"></script>
      <style>
      .re_card{
      width: 15rem; 
      display:inline-block; 
      position:relative;
      }
         * {
         box-sizing: border-box;}
         body {
         margin: 0;
         font-family: Arial, Helvetica, sans-serif;
         }

         .topnav {
         overflow: hidden;
         background-color: #e9e9e9;
         }
         .topnav a {
         float: left;
         display: block;
         color: black;
         text-align: center;
         padding: 14px 16px;
         text-decoration: none;
         font-size: 17px;
         }
         .topnav a:hover {
         background-color: #ddd;
         color: black;
         }
         .topnav a.active {
         background-color: #2196F3;
         color: white;
         }
         .topnav .search-container {
         float: right;
         }
         .topnav input[type=text] {
         padding: 6px;
         margin-top: 8px;
         font-size: 17px;
         border: none;
         }
         .topnav .search-container button {
         float: right;
         padding: 6px 10px;
         margin-top: 8px;
         margin-right: 16px;
         background: #ddd;
         font-size: 17px;
         border: none;
         cursor: pointer;
         }
         .topnav .search-container button:hover {
         background: #ccc;
         }
         @media screen and (max-width: 600px) {
         .topnav .search-container {
         float: none;
         }
         .topnav a, .topnav input[type=text], .topnav .search-container button {
         float: none;
         display: block;
         text-align: left;
         width: 100%;
         margin: 0;
         padding: 14px;
         }
         .topnav input[type=text] {
         border: 1px solid #ccc;  
         }
         }
      </style>
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
         .underline_home{
         border-bottom: 2px solid greenyellow;
         }
         .sub{
         background-color: #a4c639;
         color: #fff;
         font-size: 13px;
         text-transform: uppercase;
         font-weight: 700;
         padding: 12px 30px;
         border-radius: 30px;
         display: inline-block;
         transition: all 0.3s;
         outline: none;
         border: none;
         }
         .sub:hover{
         background-color: white;
         color: #a4c639;
         }
      </style>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
      <title>Ecommerce</title>
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
      <!-- Banner Starts Here -->
      <div class="main-banner header-text" id="top">
         <div class="Modern-Slider">
            <!-- Item -->
            <div class="item item-1">
               <div class="img-fill">
                  <div class="text-content">
                     <h6>iPhone 11</h6>
                     <h4>Just the right amount of everything.</h4>
                     <p>New duel camera system. All day battery. The toughest glass in smartphone.</p>
                     <a href="products.php" class="filled-button">Products</a>
                  </div>
               </div>
            </div>
            <!-- // Item -->
            <!-- Item -->
            <div class="item item-2">
               <div class="img-fill">
                  <div class="text-content">
                     <h6>ONEPLUS</h6>
                     <h4>Never Settle</h4>
                     <p>Prettymuch everything you could ask for</p>
                     <a href="about.html" class="filled-button">About Us</a>
                  </div>
               </div>
            </div>
            <!-- // Item -->
            <!-- Item -->
            <div class="item item-3">
               <div class="img-fill">
                  <div class="text-content">
                     <h6>Google Pixel 4a 5G</h6>
                     <h4>Meet Pixel 4a</h4>
                     <p>This phone uses technology that intelligently switches you between Fi's three cellular network partners, as well as secure Wi-Fi hotspots, to give you the best coverage and save on data.</p>
                     <a href="contact.html" class="filled-button">Contact Us</a>
                  </div>
               </div>
            </div>
            <!-- // Item -->
         </div>
      </div>
      <!-- Banner Ends Here -->
      <div class="request-form">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <h4>Request a call back right now ?</h4>
                  <span>Customer service is about empathy.</span>
               </div>
               <div class="col-md-4">
                  <a href="contact.html" class="border-button">Contact Us</a>
               </div>
            </div>
         </div>
      </div>


      <!-- search bar -->
      <div class="topnav">
         <div class="search-container">
            <form action="products.php" method="">
               <input type="text" placeholder="Search.." name="search">
               <button type="submit"><i class="fa fa-search"></i></button>
            </form>
         </div>
      </div>
      <!-- search end  -->



      <div class="services" >
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="section-heading">
                     <h2>Featured <em>Products</em></h2>
                     <span>When the product is right, you don’t have to be a great Marketer.</span>
                  </div>
               </div>
               <?php
                 if(searching_specific_data('products', 'featured')){
                      while ($row = mysqli_fetch_assoc($result))
                      {
                      $product_link = 'product-page.php?product_name='.$row['p name'];
                  ?>
               <div class="col-md-4">
                  <div class="service-item">
                     <a href="<?php echo $product_link ?>"><img src="<?php echo $row['img 1']; ?>" alt=""></a>
                     <div class="down-content">
                        <a style="color:black;" href="<?php echo $product_link ?>">
                        <h6 style="font-size:17px;"><?php echo "{$row['p name']}"; ?></h6>
                        </a>
                        <div style="margin:10px 0px 10px 0;">
                           <span> <sup>RS</sup><del><?PHP echo number_format("{$row['p price']}"); ?></del> &nbsp; <sup>RS</sup><span style="color: red;"><?PHP echo number_format("{$row['d price']}"); ?></span></span>
                        </div>
                        <p style="line-height: normal;"> You Save  <span style="color:red;"> <?php echo number_format($row['p price'] - $row['d price']); ?> </span> </p>
                        <p style="line-height: normal;"> Discount  <span style="color:red;"> <?php echo discount_cal($row['p price'], $row['d price']) . '%'; ?> </span> </p>

                           <a href="<?php echo $product_link ?>"><button class="sub">View More</button></a>
                     </div>
                  </div>
                  <br>
               </div>
               <?php
                  }
                  }
                  else
                  {
                  die('no featured products');
                  }

                  //showing recently viewed products
                  if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
                    $table_name_for_recent = $_SESSION['ACCOUNT_EMAIL'] . '_recent';
                    require 'database-connection.php';
                    $sql = "SELECT DISTINCT `p name`, `p price`, `img`, `d price` FROM `$table_name_for_recent`;";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 3){
                    $sql = "SELECT DISTINCT `p name`, `p price`, `img`, `d price` FROM `$table_name_for_recent` ORDER BY `id` DESC LIMIT 4;";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 0){
                      echo "<div id='cont' style='margin:0 auto 0 auto; text-align:center;'>";
                      echo "<h3 style='display:block; width:100%; padding-top:70px; padding-bottom:30px;'><i style='color:blue;' class='fas fa-undo-alt'></i> Recently Viewed. </h3>";
                      while($row = mysqli_fetch_assoc($result)){ ?>
<?php $link = "product-page.php?product_name=" . $row['p name']; ?>
<div class="card re_card" style='display:inline-block;'>
  <a href="<?php echo $link; ?>"><img class="card-img-top" src="<?php echo $row['img']; ?>" alt="Card image cap"></a>
  <div class="card-body">
    <a href="<?php echo $link; ?>"><h5 class="card-title" style="font-size:small; text-align:left;  font-weight:300; color:black;"><?php echo $row['p name']; ?></h5></a>
    <p class="card-text" style='text-align:left;'><sup>RS </sup> <span style="color:red;"> <?php echo number_format($row['d price']); ?></span></p>
    <a href="<?php echo $link; ?>" class="btn btn-primary">View</a>
  </div>
  <p style="color: white; background:red; position:absolute; top:6px; left:4px; padding:8px; font-weight:600; line-height:15px;" class="rounded-circle"><?php echo discount_cal($row['p price'], $row['d price']) . '%<br> Off'; ?></p>
</div>

                      <?php
                      }
                      echo '</div>';
                    }
                  }
                  }
                  //end
                  ?>
            </div>
         </div>
      </div>
      <div class="fun-facts">
         <div class="container">
            <div class="more-info-content">
               <div class="row">
                  <div class="col-md-6">
                     <div class="left-image">
                        <img src="assets/images/about-1-570x350.jpg" class="img-fluid" alt="">
                     </div>
                  </div>
                  <div class="col-md-6 align-self-center">
                     <div class="right-content">
                        <span>Who we are</span>
                        <h2>Get to know about <em>our company</em></h2>
                        <p>Every problem is a gift—without problems we would not grow.</p>
                        <a href="about.html" class="filled-button">Read More</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="callback-form">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="section-heading">
                     <h2>Request a <em>call back</em></h2>
                     <span>Customer service is about empathy.</span>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="contact-form">
                     <form id="contact" action="contact-us-submit.php" method="post">
                        <div class="row">
                           <div class="col-lg-4 col-md-12 col-sm-12">
                              <fieldset>
                                 <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                              </fieldset>
                           </div>
                           <div class="col-lg-4 col-md-12 col-sm-12">
                              <fieldset>
                                 <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*" placeholder="E-Mail Address" required="">
                              </fieldset>
                           </div>
                           <div class="col-lg-4 col-md-12 col-sm-12">
                              <fieldset>
                                 <input name="sub" type="text" class="form-control" id="subject" placeholder="Subject" required="">
                              </fieldset>
                           </div>
                           <div class="col-lg-12">
                              <fieldset> 
                                 <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                              </fieldset>
                           </div>
                           <div class="col-lg-12">
                              <fieldset>
                                 <button type="submit" name="contact-submit" value="Send Message" id="form-submit" class="border-button">Send Message</button>
                              </fieldset>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <br>
            <br>
            <br>
            <br>
         </div>
      </div>
      <?php require 'footer.php' ?>
      <style>
      @media only screen and (max-width: 488px) {
  .re_card{
  width: 10rem;
  }
}
@media only screen and (max-width: 324px) {
  .re_card{
  width: 8rem;
  }
}
      </style>
      <script>
            function completeload(){
                document.getElementById('loader').style.display = "none";
            }
      </script>
   </body>
</html> 