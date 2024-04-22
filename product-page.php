<?php
   session_start();
   function filtering_arrived_data($data){
   
   if(!preg_match("/^([a-zA-Z0-9() ]+)$/",$data)){
           die("invalid product name");
   }
       return $data;
   }
   $product_name = filtering_arrived_data($_REQUEST['product_name']);
   function discount_cal($actual_price, $discount_price){
    $diff = $actual_price - $discount_price ;
    $result = ($diff / $actual_price) * 100;
    return round($result);
}

   //i should consider oops because lot of thing using data availability code
   class searching_if_data_available{
      public $result;
      function searching($sql){
        require "database-connection.php";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0){
            $this->result = $result;
            return true;
        }else{
            return false;
        }
      }
   }

   if (isset($_SESSION['ACCOUNT_EMAIL']))
   {
       $user_email = $_SESSION['ACCOUNT_EMAIL'];
   }
   
   //checking if product is available in database
   if (strlen($product_name) > 0)
   {
      $boj_to_check_product_availability = new searching_if_data_available();
            if ($boj_to_check_product_availability->searching("SELECT * FROM `products` WHERE `p name`='$product_name'"))
           {
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <script src="https://kit.fontawesome.com/9138881b2c.js" crossorigin="anonymous"></script>
      <style>
         *{
         margin: 0;
         padding: 0;
         }
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
         .rate {
         border: 1px solid transparent;
         display: block;
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         #review_container{
         border: 1px solid #a4c639;
         padding: 20px;
         }
         .rate:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rate:not(:checked) > label:before {
         content: '★ ';
         }
         .rate > input:checked ~ label {
         color: #ffc700;    
         }
         .rate:not(:checked) > label:hover,
         .rate:not(:checked) > label:hover ~ label {
         color: #deb217;  
         }
         .rate > input:checked + label:hover,
         .rate > input:checked + label:hover ~ label,
         .rate > input:checked ~ label:hover,
         .rate > input:checked ~ label:hover ~ label,
         .rate > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
         #rev{
         padding: 10px;
         display: block;
         }
         #star{
         color:#ffc700;  
         font-size: 25px;
         padding: 5px;
         }
         #non_given_star{
         font-size: 25px;
         padding: 5px;
         color: gray; 
         }
         #rev_image{
             height: 4cm;
             width: auto;
             display: block;
         }
      </style>
      <style>
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
         #more 
         {display: none;}
         #moree
         {display: none;}
         #myBtn{
         padding: 10px;
         background-color: #a4c639;
         color: white;
         border-radius: 10px;
         outline: transparent;
         border: none;
         }
         #del{
         padding: 10px;
         background-color: #a4c639;
         color: white;
         border-radius: 10px;
         outline: transparent;
         border: none;
         }
         #myyBtn{
         padding: 10px;
         background-color: #a4c639;
         color: white;
         border-radius: 10px;
         outline: transparent;
         border: none;
         }
         #rev{
         padding: 10px;
         background-color: #a4c639;
         color: white;
         border-radius: 10px;
         outline: transparent;
         border: none;
         text-transform: capitalize;
         }
         #review{
         width: 100%;
         padding: 15px;
         margin: 5px 0 5px 0;
         display: inline-block;
         border: none;
         background: #f1f1f1;
         resize: vertical;
         }
      </style>
      <style>
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
         .underline_products{
         border-bottom: 3px solid greenyellow;
         }
         #about{
         height: 1.8cm;
         overflow: hidden;
         }
         #des{
         height: 1.8cm;
         overflow: hidden;
         }
         #circ_p_img{
             height: 40px;
             width: 40px;
             border-radius: 50%;
         }
      </style>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
      <title>Products</title>
      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Additional CSS Files -->
      <link rel="stylesheet" href="assets/css/fontawesome.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/owl.css">
   </head>
   <body onload="completeload()">
      <!-- preloader ---->
      <div id="loader">
      </div>
      <!-- preloader ---->
      <?php     require "header.php"; ?>
      <!-- Page Content -->
      <div class="page-heading header-text">
         <div  class="container">
            <div  class="row">
               <div class="col-md-12">
                  <h4 style="font-weight:300;">
                  <small><del><sup></sup></del></small> &nbsp; <sup></sup>Your <?php echo $product_name; ?> is below. </h1>
                  <span>
                  </span>
               </div>
            </div>
         </div>
      </div>
      <!-- //php from here -->
      <?php
      $fetching_product_details = new searching_if_data_available();
          if ($fetching_product_details->searching("SELECT * FROM products WHERE `p name`= '$product_name'"))
          {
             while ($row = mysqli_fetch_assoc($fetching_product_details->result))
             {
         ?>
      <div class="services">
         <div class="container">
            <div class="row">
               <div class="col-md-7">
                  <div>
                     <img src="<?php echo "{$row['img 1']}"; ?>" alt="" class="img-fluid wc-image" id="main-img">
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-4 col-6">
                        <div>
                           <img src="<?php echo "{$row['img 1']}"; ?>" alt="" class="img-fluid" id="child-1" onclick="document.getElementById('main-img').src='<?php echo "{$row['img 1']}"; ?>'">
                        </div>
                        <br>
                     </div>
                     <div class="col-sm-4 col-6">
                        <div>
                           <img src="<?php echo "{$row['img 2']}"; ?>" alt="" class="img-fluid" id="child-2" onclick="document.getElementById('main-img').src='<?php echo "{$row['img 2']}"; ?>'">
                        </div>
                        <br>
                     </div>
                     <div class="col-sm-4 col-6">
                        <div>
                           <img src="<?php echo "{$row['img 3']}"; ?>" alt="" class="img-fluid" id="child-3"  onclick="document.getElementById('main-img').src='<?php echo "{$row['img 3']}"; ?>'">
                        </div>
                        <br>
                     </div>
                  </div>
                  <br>
               </div>
               <div class="col-md-5">
                  <div class="sidebar-item recent-posts">
                     <div style="margin-bottom: 25px;" class="sidebar-heading">
                        <a style="color:black;" href="<?php echo $row['redir'] ?>">
                           <h4><?php echo "{$row['p name']}"; ?></h4>
                        </a>
                     </div>
                     <div class="content">
                        <p>M.R.P :    	<BIG style="color: RED; font-family:Arial; font-size:25px;"><?php echo number_format($row['p price']); ?> </BIG> RS   <BR> Inclusive of all taxes</p>
                     </div>
                  </div>
                  <br>
                  <br>
                  <h4>Add to Cart</h4>
                  <br>
                  <form action="cart-adding.php" method="get">
                     <div class="row">
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group">
                              <label for="">Color </label>
                              <select class="form-control" name="selected_color">
                                 <?php if (!empty($row['color 1']))
                                    { ?>
                                 <option selected name="color" value="<?php echo "{$row['color 1']}"; ?>"><?php echo "{$row['color 1']}"; ?></option>
                                 <?php
                                    } ?>
                                 <?php if (!empty($row['color 2']))
                                    { ?>
                                 <option name="color" value="<?php echo "{$row['color 2']}"; ?>"><?php echo "{$row['color 2']}"; ?></option>
                                 <?php
                                    } ?>
                                 <?php if (!empty($row['color 3']))
                                    { ?>
                                 <option name="color" value="<?php echo "{$row['color 3']}"; ?>"><?php echo "{$row['color 3']}"; ?></option>
                                 <?php
                                    } ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group">
                              <label for="">Quantity</label>
                              <input type="number" name="quantity" min="1"  value="1" required="" class="form-control">
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="form-group">
                           <!-- using session veriable to store product name to access it in cart-adding.php  -->
                               <?php $_SESSION['product_name'] = $row['p name']; ?>
                              <?php if (isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD']))
                                 { ?>
                              <input type="submit" name="add_cart" class="sub" value="Add to Cart">
                              <?php
                                 }
                                 else
                                 { ?>
                              <h4 style="font-weight: 300;"> Please <a href="login.php"> Login </a> to Add to Cart </h4>
                              <?php
                                 } ?>
                           </div>
                        </div>
                     </div>
                  </form>
                  <br>
               </div>
            </div>
            <br>
            <h2 style="font-weight:300;">Description</h2>
            <p id="des"><?php echo "{$row['p big']}"; ?></p>
            <button style="margin-bottom: 20px;" onclick="more()" id="myBtn">Read more</button>
            <h2 style="padding-top: 40px; font-weight:300;">About this item</h2>
            <p id="about"><?php echo "{$row['p about']}"; ?></p>
            <button style="margin-bottom: 20px;" onclick="moree()" id="myyBtn">Read more</button>
            <!-- review system here -->
            <?php if (!isset($_SESSION['ACCOUNT_EMAIL']) && !isset($_SESSION['ACCOUNT_PASSWORD']))
               {
                   $user_email = "to prevent the error";
               }
               ?>
            <?php
             
               $obj_to_check_if_reviewed = new searching_if_data_available();
               if ($obj_to_check_if_reviewed->searching("SELECT * FROM reviews WHERE `email`='$user_email' AND `product_name`='$product_name';"))
               {
                   echo "<h4 style='color:green;'> You already reviewed this product, Please delete your review to rewrite the review.</h4>";
               }
               else
               {
               ?>
            <?php if (isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD']))
               { ?>
            <form action="review-submit.php" style="margin-top: 40px;" method="POST" enctype="multipart/form-data">
               <h2 style="font-weight:300;">Please write a review on this product.</h2>
               <div class="rate">
                  <input style="display: none;" type="radio" id="star5" name="rate" value="5" />
                  <label for="star5" title="text">5 stars</label>
                  <input style="display: none;" type="radio" id="star4" name="rate" value="4" />
                  <label for="star4" title="text">4 stars</label>
                  <input style="display: none;" type="radio" id="star3" name="rate" value="3" />
                  <label for="star3" title="text">3 stars</label>
                  <input style="display: none;" type="radio" id="star2" name="rate" value="2" />
                  <label for="star2" title="text">2 stars</label>
                  <input style="display: none;" type="radio" id="star1" name="rate" value="1" />
                  <label for="star1" title="text">1 star</label>
               </div>
               <br><br>
                
               <?php echo "<p style='color:red; font-size:10px;'>Please select star rating in order to submit the review.</p>"; ?>

                <label for="img">Select an image</label><br>
                <input type="file" name="image" id="image">

               <textarea placeholder="review here" name="review" id="review" cols="30" rows="5"></textarea>
               <input type="submit" name="submit_review" id="rev" value="submit">
            </form>
            <?php
               }
               else
               { ?>
            <h4 style="font-weight:300;"> Please<a href="login.php"> Login </a> to write a review </h4>
            <?php
               }
               } ?>
            <!-- end -->
            
            
            
            
            
            
            
            
            <!-- showing reviews  -->
            <?php
               $obj_for_fetching_reviews = new searching_if_data_available();
               if ($obj_for_fetching_reviews->searching("SELECT * FROM reviews WHERE `product_name`= '$product_name'"))
               {
                   echo "<h2 style='margin-top: 40px; margin-bottom:40px; font-weight:300;'>Reviews " . "( " . mysqli_num_rows($obj_for_fetching_reviews->result) . " )" . "</h2>";
                   while ($rev = mysqli_fetch_assoc($obj_for_fetching_reviews->result))
                   {
                       echo "<div id='review_container'>";
               ?>
            <?php
               $getting_u = $rev['email'];
               $obj_for_fetching_review_details = new searching_if_data_available();
               if ($obj_for_fetching_review_details->searching("SELECT * FROM accounts WHERE `email`= '$getting_u'"))
               {
                   while ($u = mysqli_fetch_assoc($obj_for_fetching_review_details->result))
                   {
                       $username = $u['username'];
                       $profile_image = $u['profile pic'];
                   }
               }
               
                   $displaying_rating = $rev['rating'];

               //showing circular profile pic
               if(!empty($profile_image)){
                   echo "<a href='account.php?acc_id=$rev[user_acc_id]'><img src='$profile_image' id='circ_p_img'></a>";
               }else{
                   echo "<a href='account.php?acc_id=$rev[user_acc_id]'><img src='assets/images/profile pic/deff.png' id='circ_p_img'></a>";
               }
               //end

               echo "<a href='account.php?acc_id=$rev[user_acc_id]'><h4 style='color:black; display:inline-block;'> $username </h4></a>";
               echo '<br>';
               for ($i = 1;$i <= $displaying_rating;$i++)
               {
                   echo "<i id='star' class='fas fa-star'></i>";
               }
               $rem = $i - 1;
               $jugad = 5 - $rem;
               for ($j = 1;$j <= $jugad;$j++)
               {
                   echo "<i id='non_given_star' class='fas fa-star'></i>";
               }
               echo "<br><small> Reviewed on {$rev['time']} </small>";
               if(!empty($rev['image'])){
               echo "<img id='rev_image' src='$rev[image]'>";
               }
               echo "<p id='customer_review'>{$rev['review']} </p>";
               //showing total likes on this review
               $object_to_show_likes = new searching_if_data_available();
               if($object_to_show_likes->searching("SELECT * FROM `review ld` WHERE `review id`='$rev[id]';")){
                   echo "<p> Total Likes " ."<span style='color:red; font-weight:600;'>". mysqli_num_rows($object_to_show_likes->result). "</span>" . "</p>";
               }
               ?>
               <!-- //like/dislik button -->
               <?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){ 
                $obj_to_check_if_already_liked = new searching_if_data_available(); 
                if($obj_to_check_if_already_liked->searching("SELECT * FROM `review ld` WHERE `email`='$user_email' AND `status`='Like' AND `review id`='$rev[id]';")){ 
                     echo "<a href='unlike.php?review_id=$rev[id]'><p style='color:blue; font-weight:600; width:3cm; border:1px solid blue; text-align:center; margin:3px 0 3px 0;'><i class='fas fa-thumbs-up'></i> Liked </p></a>";
               }else{
                echo "<a href='like.php?review_id=$rev[id]'> <p style='color:gray; font-weight:600; width:3cm; border:1px solid gray; text-align:center; margin:3px 0 3px 0;'><i class='fas fa-thumbs-up'></i> Like </p> </a>";
               }
                       
               }
               ?>
               
               <?php
               if (isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD']))
               {
                   if ($rev['email'] == $_SESSION['ACCOUNT_EMAIL'])
                   { ?>
            <form action="review-delete.php" method="POST">
               <input type="submit" id="del" name="del" value="Delete Review">
            </form>
            <?php
               }
               } ?>
            <?php
               echo "</div>";
               ?>
            <?php
               }
               }
               ?>
            <!-- end  -->
            
            
            
            
            
            
            
            
            
            
            <?php
               $obj_for_suggestion_products = new searching_if_data_available();
               if ($obj_for_suggestion_products->searching("SELECT * FROM products WHERE `p price` < {$row['p price']} LIMIT 3"))
               {    
               ?>
            <h3 style="margin-top: 40px; font-weight:300; margin-bottom:-35px;">
            Suggested Products</h2>
            <div class="services">
               <div class="container">
                  <div class="row">
                     <?php while ($srow = mysqli_fetch_assoc($obj_for_suggestion_products->result))
                        { $product_link = "http://mobile-shop.c1.biz/product-page.php?product_name=" . $srow['p name']  ?>
                     <div class="col-md-4">
                        <div class="service-item">
                           <a href="<?php echo $product_link; ?>"><img src="<?php echo "{$srow['img 1']}"; ?>" alt=""></a>
                           <div class="down-content">
                              <a style="color:black;" href="<?php echo $product_link; ?>">
                              <h6 style="font-size:17px;"><?php echo "{$srow['p name']}"; ?></h6>
                              </a>
                              <div style="margin:10px 0px 10px 0;">
                                 <span>
                                 <sup>RS</sup><del><?PHP echo number_format("{$srow['p price']}"); ?> </del> &nbsp; <sup>RS</sup><span style="color: red;"><?PHP echo number_format("{$srow['d price']}"); ?></span>
                                 </span>
                              </div>
                              <p style="line-height: normal;"> You Save  <span style="color:red;"> <?php echo number_format($srow['p price'] - $srow['d price']); ?> </span> </p>
                              <p style="line-height: normal;"> Discount  <span style="color:red;"> <?php echo discount_cal($srow['p price'], $srow['d price']) . '%'; ?> </span> </p>
                                <a href="<?php echo $product_link; ?>"><button class="sub">View More</button></a>
                           </div>
                        </div>
                        <br>
                     </div>
                     <?php
                        }
                        } ?>
                  </div>
               </div>
            </div>
            <br>
            <br>
            <br>
         </div>
      </div>
      <?php

      
      //recent add here
      if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
        $table_name = $user_email . '_recent';
        $product_f_recent = $row['p name'];
        $img_f_recent = $row['img 1'];
        $price_f_recent = $row['p price'];
        $d_price_f_recent = $row['d price'];
        $sql_f_recent = "INSERT INTO `$table_name` (`img`, `p name`, `p price`, `d price`) VALUES ('$img_f_recent', '$product_f_recent', '$price_f_recent', '$d_price_f_recent');";
        mysqli_query($con, $sql_f_recent) or print_r(mysqli_error($con));
      }
//end


      
         }
         } ?>
      <?php     require "footer.php" ?>
      <script>
         function more(){
           let x = document.getElementById("des");
           let y =  document.getElementById("myBtn");
           if(x.style.height == 'auto'){
             x.style.height = '1.8cm';
             y.innerHTML = "Read More";
             x.scrollIntoView();
           }else{
            x.style.height = 'auto';
            y.innerHTML = "Read Less";
           }
         }
         function moree(){
           let x = document.getElementById("about");
           let y =  document.getElementById("myyBtn");
           if(x.style.height == 'auto'){
             x.style.height = '1.8cm';
             y.innerHTML = "Read More";
             x.scrollIntoView();
           }else{
            x.style.height = 'auto';
            y.innerHTML = "Read Less";
           }
         }
      </script>
      <script>
         function completeload(){
             document.getElementById('loader').style.display = "none";
         }
      </script>
   </body>
</html>
<?php
   }
   else
   {
       die("Product not available");
   }
   }
   else
   {
   die("product name not set");
   }
   ?>