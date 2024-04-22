<?php
    session_start();
    function filtering_arrived_data($data)
    {
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        $data = trim($data);
        return $data;
    }
    $searched_product_name = filtering_arrived_data($_REQUEST['search']);

    function discount_cal($actual_price, $discount_price){
        $diff = $actual_price - $discount_price ;
        $result = ($diff / $actual_price) * 100;
        return round($result);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
                        .center {
            text-align: center;
            }

            .pagination {
            display: inline-block;
            }

            .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
            margin: 0 4px;
            }

            .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
            }

            .pagination a:hover:not(.active) {background-color: #ddd;}
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
            .underline_products{
            border-bottom: 3px solid greenyellow;
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
        <style>
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
        <div id="loader"></div>
        <!-- preloader ---->
        <?php require "header.php"; ?>
        <!-- Page Content -->
        <div class="page-heading header-text">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Products</h1>
                        <span>When the product is right, you don’t have to be a great Marketer.</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- search bar -->
        <div class="topnav">
            <div class="search-container">
                <form action="" method="">
                    <input type="text" placeholder="Search.." value="<?php if (isset($searched_product_name))
                        {
                            echo $searched_product_name;
                        } ?>" name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <!-- search end  -->
        <div class="services">
            <div class="container">
                <div class="row">
                    <?php if (!strlen($searched_product_name) > 0)
                        { ?>
                    <?php
                        require "database-connection.php";
                        $sql = "SELECT * FROM products;";
                        $result = mysqli_query($con, $sql);
                        $num_rows_avail = mysqli_num_rows($result);
                        if(isset($_GET['page'])){
                            $page = (int) $_GET['page'];
                            if($page == 0){
                                $page = 1;
                            }
                        }else{
                            $page = 1;
                        }
                        $num_of_rec_per_page = 3;
                        $number_of_pages = ceil($num_rows_avail/$num_of_rec_per_page);
                        if($page > $number_of_pages){
                            $page = $number_of_pages;
                        }
                        $offset = ($page-1)*$num_of_rec_per_page;
                        $query = "SELECT * FROM products LIMIT $offset, $num_of_rec_per_page;";
                        $res = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_assoc($res))
                            {
                        
                                $product_name = 'product-page.php?product_name=' . $row['p name'];
                        ?>
                    <div class="col-md-4">
                        <div class="service-item">
                            <a href="<?php echo $product_name; ?>"><img src="<?php echo "{$row['img 1']}"; ?>" alt=""></a>
                            <div class="down-content">
                                <a style="color:black;" href="<?php echo $product_name; ?>">
                                    <h6 style="font-size:17px;"><?php echo "{$row['p name']}"; ?></h6>
                                </a>
                                <div style="margin:10px 0px 10px 0;">
                                    <span>
                                    <sup>RS</sup><del><?PHP echo number_format("{$row['p price']}"); ?> </del> &nbsp; <sup>RS</sup><span style="color: red;"><?PHP echo number_format("{$row['d price']}"); ?></span>
                                    </span>
                                    <p style="line-height: normal;"> You Save  <span style="color:red;"> <?php echo number_format($row['p price'] - $row['d price']); ?> </span> </p>
                                      <p style="line-height: normal;"> Discount  <span style="color:red;"> <?php echo discount_cal($row['p price'], $row['d price']) . '%'; ?> </span> </p>

                                   
                                </div>
                    
                                <a href="<?php echo $product_name; ?>"><button class="sub">View More</button></a>
                            </div>
                        </div>
                        <br>
                    </div>
                    <?php 
                        }?>
        
                       <!-- pages here  -->
                       <div class="center">
                        <div class="pagination">
                        <?php 
                     if($page > 1){
                         $prev_pg = $page - 1;
                         echo "<a href='products.php?page=$prev_pg' class='active'> Prev </a>";
                     }
                        for($i=1; $i<=$number_of_pages; $i++){
                        ?>
                        <?php if($page == $i){ ?>
                            <a href='<?php echo "products.php?page=$i" ?>' class="active"><?php echo $i ?></a>
                        <?php }else{ ?>
                        <a href='<?php echo "products.php?page=$i";  ?>'><?php echo $i ?></a>
                        <?php
                        }
                    }
                    if($page < $number_of_pages){
                        $next_pg = $page + 1;
                        echo "<a href='products.php?page=$next_pg' class='active'> Next </a>";
                    }
                        ?>
                        </div>
                        </div>

                       <!-- end  -->
               
                        <?php
                        }
                        else
                        {
                        ?>
                    <?php require "database-connection.php";
                        $sql = "SELECT * FROM products WHERE `p name` LIKE '%$searched_product_name%';";
                        $result = mysqli_query($con, $sql);
                        if (mysqli_num_rows($result) > 0)
                        {
                            while ($row = mysqli_fetch_assoc($result))
                            {
                                $product_name = 'product-page.php?product_name=' . $row['p name'];
                        ?>
                    <div class="col-md-4">
                        <div class="service-item">
                            <a href="<?php echo $product_name; ?>"><img src="<?php echo "{$row['img 1']}"; ?>" alt=""></a>
                            <div class="down-content">
                                <a style="color:black;" href="<?php echo $product_name; ?>">
                                <h6 style="font-size:17px;"><?php echo "{$row['p name']}"; ?></h6>
                                </a>
                                <div style="margin:10px 0px 10px 0;">
                                    <span>
                                    <sup>RS</sup><del><?PHP echo number_format("{$row['p price']}"); ?> </del> &nbsp; <sup>RS</sup><span style="color: red;"><?PHP echo number_format("{$row['d price']}"); ?></span>
                                    </span>
                                </div>
                                <p style="line-height: normal;"> You Save  <span style="color:red;"> <?php echo number_format($row['p price'] - $row['d price']); ?> </span> </p>
                                <p style="line-height: normal;"> Discount  <span style="color:red;"> <?php echo discount_cal($row['p price'], $row['d price']) . '%'; ?> </span> </p>
                                <a href="<?php echo $product_name; ?>"><button class="sub">View More</button></a>
                            </div> 
                        </div>
                        <br>
                    </div>
                    <?php
                        }
                        }
                        else
                        {
                        echo "<h3> No Product Found </h3>";
                        }
                        }
                        ?>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
        <?php require "footer.php" ?>
        <script>
            function completeload(){
                document.getElementById('loader').style.display = "none";
            }
        </script>
    </body>
</html>