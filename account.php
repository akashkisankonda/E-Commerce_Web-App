<?php 
session_start();
$self = $_SERVER['PHP_SELF'];
$useremail = $_SESSION['ACCOUNT_EMAIL'];

    //checking if account id arrived is valid or not
    if(isset($_GET['acc_id'])){
        $account_id = (int) $_GET['acc_id'];
        require 'database-connection.php';
        $sql = "SELECT * FROM accounts WHERE id='$account_id';";;
        $res = mysqli_query($con, $sql);
        if(!mysqli_num_rows($res) > 0){
            die("account id not valid");
        }else{
            while($row = mysqli_fetch_assoc($res)){
                $arrived_id_username = $row['username'];
            }
        }
        }
    //end

    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //password change
        if(isset($_REQUEST['submit-password'])){
            $new_password = $_REQUEST['passwordd'];
            if(strlen($new_password) > 5 && strlen(str_replace(' ', '', $new_password)) > 5){
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            require "database-connection.php";
            $sql = "UPDATE accounts SET `password`='$new_password' WHERE `email`='$useremail';";
            if(!mysqli_query($con, $sql)){
                die('new password not set');
        }else{
            session_unset();
            $_SESSION['password_changed'] = 'set';
            setcookie("email", "", time()-3600);
            setcookie("password", "", time()-3600);
            echo "<script> window.location = 'login.php'; </script>";
        }
    }
    echo "<script> window.location = '$self'; </script>";
    }

        //input verify
    if(isset($_REQUEST['submit-username'])){
        $name = $_REQUEST['uname'];
        $name = str_replace(' ', '', $name);
        if(!empty($name) && strlen($name) > 2){
            if(preg_match("/^([a-zA-Z]+)$/",$name)){
                $u_val = true;
            }else{
                // redirect same
                echo "<script> window.location = '$self'; </script>";
            }
        }else{
            echo "<script> window.location = '$self'; </script>";
        }
        if($u_val == true){
        require "database-connection.php";
        $sql = "UPDATE accounts SET username='$name' WHERE email='$useremail';";
        if(mysqli_query($con, $sql)){
            echo "<script> window.location = '$self'; </script>";
        }else{
            die(mysqli_error($con));
        }
    }
    }
    //address verify
    if(isset($_REQUEST['submit-address'])){
        $address = $_REQUEST['address'];
        if(!empty($address)){
            if(str_word_count($address) < 2){
            echo "<script> window.location = '$self'; </script>";
            }else{
                require "database-connection.php";
                $sql = "UPDATE accounts SET address='$address' WHERE email='$useremail';";
                if(mysqli_query($con, $sql)){
                echo "<script> window.location = '$self'; </script>";   
                }else{
                    die(mysqli_error($con));
                }
            }
        }else{
            echo "<script> window.location = '$self'; </script>";
        }
    }
    if(isset($_REQUEST['submit-phone'])){
        $phone_number = str_replace('e', '', $_REQUEST['phone']);
        $phone_number = preg_replace( '/[^0-9]/', '', $phone_number );
        //die('number is ' . $phone_number);
        if(!empty($phone_number)){
                if(strlen($phone_number) > 9 && strlen($phone_number) < 11){
                        $val_phone = true;
                    }else{
                        $val_phone = false;
                    }
                }else{
                    echo "<script> window.location = '$self'; </script>";
                }
            
      
        if($val_phone == true){
        
            require "database-connection.php";
            $sql = "UPDATE accounts SET phone='$phone_number' WHERE email='$useremail';";
            if(mysqli_query($con, $sql)){
                echo "<script> window.location = '$self'; </script>";
            }else{
                die(mysqli_error($con));
            }
        }else{
            echo "<script> window.location = '$self'; </script>";
        }
    }
    if(isset($_FILES['image'])){
        if(isset($_FILES['image'])){
            $target_destination = "assets/images/profile pic/";
            $file_name_with_extinsion = $_FILES['image']['name'];
            $file_extinsion = strtolower(pathinfo($file_name_with_extinsion, PATHINFO_EXTENSION));
            if($file_extinsion == 'jpg' || $file_extinsion == 'jpeg' || $file_extinsion == 'png' || $file_extinsion == 'gif' || $file_extinsion == 'tif' || $file_extinsion == 'tiff'){
            $exploded = explode(".",$file_name_with_extinsion);
            $exploded[0] = rand();
            $transformation = $exploded[0] . ".$file_extinsion";
            $_FILES['image']['name'] = $transformation;
            $res = move_uploaded_file($_FILES['image']['tmp_name'], "$target_destination{$_FILES['image']['name']}");
            if($res){
                $complete_destination = $target_destination.$_FILES['image']['name'];
                require 'database-connection.php';
                $sql = "UPDATE accounts SET `profile pic`='$complete_destination' WHERE email='$useremail';";
                mysqli_query($con, $sql);
                echo "<script> window.location = '$self'; </script>";
            }else{
                echo "<script> window.location = '$self'; </script>";
            }
            }
            }
    }
    //email private code
    if(isset($_REQUEST['email-private'])){
        require 'database-connection.php';
        $sql = "UPDATE accounts SET `email status`='private' WHERE email='$useremail';";
        if(!mysqli_query($con, $sql)){
            die('error');
        }
        echo "<script> window.location = '$self'; </script>";
    }
    //email public code
    if(isset($_REQUEST['email-public'])){
        require 'database-connection.php';
        $sql = "UPDATE accounts SET `email status`='public' WHERE email='$useremail';";
        if(!mysqli_query($con, $sql)){
            die('error');
        }
        echo "<script> window.location = '$self'; </script>";
    }
    //address private code
    if(isset($_REQUEST['address-private'])){
        require 'database-connection.php';
        $sql = "UPDATE accounts SET `address status`='private' WHERE email='$useremail';";
        if(!mysqli_query($con, $sql)){
            die('error');
        }
        echo "<script> window.location = '$self'; </script>";
    }
        //address public code
        if(isset($_REQUEST['address-public'])){
            require 'database-connection.php';
            $sql = "UPDATE accounts SET `address status`='public' WHERE email='$useremail';";
            if(!mysqli_query($con, $sql)){
                die('error');
            }
            echo "<script> window.location = '$self'; </script>";
        }
                //phone public code
                if(isset($_REQUEST['phone-public'])){
                    require 'database-connection.php';
                    $sql = "UPDATE accounts SET `phone status`='public' WHERE email='$useremail';";
                    if(!mysqli_query($con, $sql)){
                        die('error');
                    }
                    echo "<script> window.location = '$self'; </script>";
                }
                        //phone private code
        if(isset($_REQUEST['phone-private'])){
            require 'database-connection.php';
            $sql = "UPDATE accounts SET `phone status`='private' WHERE email='$useremail';";
            if(!mysqli_query($con, $sql)){
                die('error');
            }
            echo "<script> window.location = '$self'; </script>";
        }
    if(isset($_REQUEST['delete-account']) && isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){
        $email = $_SESSION['ACCOUNT_EMAIL'];
        $cart = $email . '_cart';
        $order = $email . '_order';
        $recent = $email . '_recent';
        require 'database-connection.php';
        $sql = "DROP TABLE `$cart`;";
        $sql .= "DROP TABLE `$order`;";
        $sql .= "DROP TABLE `$recent`;";
        $sql .= "DELETE FROM `review ld` WHERE email='$email';";
        $sql .= "DELETE FROM reviews WHERE email='$email';";
        $sql .= "DELETE FROM accounts WHERE email='$email';";
        mysqli_multi_query($con, $sql) or die(mysqli_error($con));
        setcookie("email", "", time()-3600);
        setcookie("password", "", time()-3600);
        session_unset();
        $_SESSION['account_deleted'] = 'set';
        echo "<script> window.location = 'login.php'; </script>";
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9138881b2c.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9138881b2c.js" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Additional CSS Files -->
      <link rel="stylesheet" href="assets/css/fontawesome.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        #profile{
            display: block;
            margin: auto;
            height: 50vh;
            width: auto;
        }
            .underline_account{
        border-bottom: 2px solid greenyellow;
        }
        body{
            background-color: #DCDCDC;
            font-family: Helvetica;
        }
        .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        }
        textarea{
            text-align: center;
            resize: vertical;
            width: 100%;
            padding: 15px 0 15px 0;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }
        textarea:focus{
            background-color: #ddd;
            outline: none;
        }
        input[type=text] {
        width: 100%;
        padding: 15px 0 15px 0;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }
    input[type=text]:focus {
    background-color: #ddd;
    outline: none;
    }
    #container_db{
        background-color: white;
        /* border: 5px solid red; */
        padding: 20px 10px 20px 10px;
        margin: 0 0 20px 0;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
    }
    .registerbtn:hover {
    opacity: 1;
    }
    #edit_container_1{
        display: none;
    }
    #edit_container_2{
        display: none;
    }
    #edit_container_3{
        display: none;
    }
    #edit_container_4{
        display: none;
        text-align: center;
    }
    #edit_container_5{
        display: none;
    }
    #alert{
        color: red;
    }
    #profile_pic{
        display: block;
        margin: auto;
    }
    #upload{
        display: block;
        background-color: blue;
        color: white;
        padding: 16px 20px;
        margin: 8px auto;
        border: none;
        cursor: pointer;
        width: 4cm;
        opacity: 0.9;
    }
    #upload:hover {
    opacity: 1;
    }
  </style>
    <title>Account</title>
</head>
<body>
<?php require "header.php"; ?>

<div class="page-heading header-text">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
               <?php if(!isset($account_id)){ ?>
                  <h1>My Account</h1>
                  <span>Check Your Account Details</span>
                  <?php }else{ ?>
                    <h1><?php echo $arrived_id_username . "'s"; ?> Account</h1>
                    <?php } ?>
               </div>
            </div>
         </div>
      </div>

<?php if(!isset($_GET['acc_id'])){ ?>
<?php if(isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])){ ?>

    
    <?php
        require "database-connection.php";
        $email = $_SESSION['ACCOUNT_EMAIL'];
        $sql = "SELECT * FROM accounts WHERE email='$email';";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>
    <?php
    //showing profile pic
    if(!empty($row['profile pic'])){
        echo "<img src='{$row['profile pic']}' id='profile'>";
    }else{
        echo "<img src='assets/images/profile pic/deff.png' id='profile'>";
    }
    //end
    ?>
    <!-- profile pic upload code here  -->
    <input class="registerbtn" type="button" value="Edit Profile Picture" onclick="show_4()">
    <div id="edit_container_4">
                <p id="alert"> Select a Picture To Set Profile Picture </p>
                <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" id="profile_pic">
                <input type="submit" id="upload" class="btn btn-primary" value="Upload" name="set">
                </form>
    </div>
    <!-- end  -->

    <div id="container_db">
        <h2>Username : </h2>
        <p><?php echo "$row[username]"; ?></p>
        <input class="registerbtn" type="button" value="Edit Username" onclick="show_1()">
        <div id="edit_container_1">
            <form action="" method="post">
            <span><small style="color:red;">( Only characters allowed )</small><span>
                <input type="text" name="uname" id="" placeholder="Username Here" style="text-align: center;">
                <button type="submit" name="submit-username" class="btn btn-primary bg-primary w-100 round-0">Submit</button>
            </form>
        </div>
    </div>

    <div id="container_db">
        <h2>Email :</h2>
        <p><?php echo "$row[email]"; ?></p>
        <p id="alert"> <?php if($row['email status'] == 'public'){ echo 'Your email is Public. <i style="color:blue" class="fas fa-globe-asia"></i>'; }else{ echo 'Your email is Private.  <i style="color:black" class="fas fa-lock"></i>'; } ?> </p>
        <!-- public, private here  -->
        <form action="" method="post">
        <input type="submit" name="email-public" value="Public">
        <input type="submit" name="email-private" value="Private">
        </form>
        <!-- end  -->
    </div>

    <div id="container_db">
        <h2>Address :</h2>
        <p><?php echo "$row[address]"; ?></p>
        <input class="registerbtn" type="button" value="Edit address" onclick="show_2()">
        <div id="edit_container_2">
            <form action="" method="post">
                <span><small style="color:red;">( Address must be greater than 4 words )</small><span>
                <textarea placeholder="Address Here" name="address" id="" cols="30" rows="5"></textarea>
                <button type="submit" name="submit-address" class="btn btn-primary bg-primary w-100 round-0">Submit</button>
            </form>
        </div>
        <p id="alert"> <?php if($row['address status'] == 'public'){ echo 'Your Address is Public.  <i style="color:blue" class="fas fa-globe-asia"></i>'; }else{ echo 'Your Address is Private.  <i style="color:black" class="fas fa-lock"></i>'; } ?> </p>
        <!-- public, private here  -->
        <form action="" method="post">
        <input type="submit" name="address-public" value="Public">
        <input type="submit" name="address-private" value="Private">
        </form>
        <!-- end  -->
    </div>
   
        

    <div id="container_db">
            <h2>Phone :</h2>
            <p><?php echo "+91"."$row[phone]"; ?></p>
            <input class="registerbtn" type="button" value="Edit phone" onclick="show_3()">
            <div id="edit_container_3">
            <form action="" method="post">
                <p id="alert">Phone number without country code (eg 7620264932)</p>
                <input type="text" name="phone" id="" placeholder="Phone Here" style="text-align: center;">
                <button type="submit" name="submit-phone" value='set' class="btn btn-primary bg-primary w-100 round-0">Submit</button>
            </form>
        </div>
        <p id="alert"> <?php if($row['phone status'] == 'public'){ echo 'Your Phone is Public.  <i style="color:blue" class="fas fa-globe-asia"></i>'; }else{ echo 'Your Phone is Private.  <i style="color:black" class="fas fa-lock"></i>'; } ?> </p>
        <!-- public, private here  -->
        <form action="" method="post">
        <input type="submit" name="phone-public" value="Public">
        <input type="submit" name="phone-private" value="Private">
        </form>
        <!-- end  -->
        </div>
        
        <div id="container_db">
        <input class="registerbtn" type="button" value="Change Password" onclick="show_5()">
        <div id="edit_container_5">
            <form action="" method="POST">
            <p id="alert">You will be Logged-out after Password-Change</p>
                <input type="text" name="passwordd" id="" placeholder="New Password Here" style="text-align: center;">
                <button type="submit" name="submit-password" value='del' class="btn btn-primary bg-primary w-100 round-0">Submit</button>
            </form>
        </div>
    </div>

        <form action="" method="POST">
       <button type="submit" name="delete-account" value="delete" class="btn btn-secondary w-100 p-3 mb-2 rounded-0">Delete Account</button>
        </form>


        <?php }} 
    }else{
    echo "<script>window.location = 'index.php'; </script>";
}
}else{
 //user account fetching here
 require 'database-connection.php';
 $sql = "SELECT * FROM accounts WHERE id='$account_id';";;
 $res = mysqli_query($con, $sql);
 if(mysqli_num_rows($res) > 0){
     while($row = mysqli_fetch_assoc($res)){?>
<?php
    //showing profile pic
    if(!empty($row['profile pic'])){
        echo "<img src='{$row['profile pic']}' id='profile'>";
    }else{
        echo "<img src='assets/images/profile pic/deff.png' id='profile'>";
    }
    //end
    ?>
    <div id="container_db">
        <h2>Username : </h2>
        <p><?php echo "$row[username]"; ?></p>
    </div>

<?php if($row['email status'] == 'public'){ ?>
    <div id="container_db">
        <h2>Email :</h2>
        <p><?php echo "$row[email]"; ?></p>
    </div>
<?php } ?>
   
<?php if($row['address status'] == 'public'){ ?>
    <div id="container_db">
        <h2>Address :</h2>
        <p><?php echo "$row[address]"; ?></p>
    </div>
<?php } ?>
        
<?php if($row['phone status'] == 'public'){ ?>
    <div id="container_db">
            <h2>Phone :</h2>
            <p><?php echo "+91"."$row[phone]"; ?></p>
        </div>
<?php } ?>



<?php
     }
 }
}
    ?>
    <script>
        function show_1(){
            let x = document.getElementById('edit_container_1');
            if(x.style.display == 'block'){
                x.style.display = 'none';
            }else{
                x.style.display = 'block';
            }
        }
        function show_2(){
            let x = document.getElementById('edit_container_2');
            if(x.style.display == 'block'){
                x.style.display = 'none';
            }else{
                x.style.display = 'block';
            }
        }
        function show_3(){
            let x = document.getElementById('edit_container_3');
            if(x.style.display == 'block'){
                x.style.display = 'none';
            }else{
                x.style.display = 'block';
            }
        }
        function show_4(){
            let x = document.getElementById('edit_container_4');
            if(x.style.display == 'block'){
                x.style.display = 'none';
            }else{
                x.style.display = 'block';
            }
        }
        function show_5(){
            let x = document.getElementById('edit_container_5');
            if(x.style.display == 'block'){
                x.style.display = 'none';
            }else{
                x.style.display = 'block';
            }
        }
    </script>
    <?php require "footer.php"; ?>
</body>
</html>


