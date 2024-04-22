<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/9138881b2c.js" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<style>
.underline_rg{
border-bottom:2px solid yellow;
}
            body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: black;
        }

        * {
        box-sizing: border-box;
        }

        /* Add padding to containers */
        .containerr {
        padding: 16px;
        background-color: white;
        }

        /* Full-width input fields */
        input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
        }
        #address{
            width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
        resize: vertical;
        }
        #phone{
            color: black;
            width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
        resize: vertical;
        }
        #address:focus, #phone:focus{
            background-color: #ddd;
            outline: none;
        }
        input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
        }

        /* Set a style for the submit button */
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

        .registerbtn:hover {
        opacity: 1;
        }

        /* Add a blue text color to links */
        a {
        color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
        background-color: #f1f1f1;
        text-align: center;
        }
</style>
</head>
<body>
<?php require 'header.php'; ?>
    <div class="page-heading header-text">
         <div style="background-color: transparent; z-index:-1000;" class="containerr">
            <div  class="row">
               <div  class="col-md-12">
                  <h1>Register</h1>
                  <span>Please Register</span>
               </div>
            </div>
         </div>
      </div>


<form action="register-process.php" method="POST" autocomplete="off">
  <div class="containerr">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <?php if(isset($_SESSION['account_available'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> account already exists for {$_SESSION['account_available']} Click <a href='login.php'>Here</a> to Login</div>"; }?>


    <?php if(isset($_SESSION['username_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Username Field </div>"; }?>
    <?php if(!isset($_SESSION['username_empty'])){  if(isset($_SESSION['username_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Invalid Username </div>"; } }?>
    <label for="username"><b>Username</b></label><span><small></small></span>
    <input type="text" placeholder="Enter Username" value="<?php if(isset($_SESSION['value_username'])){echo "{$_SESSION['value_username']}";} ?>" name="username" id="email" >
    
    <?php if(isset($_SESSION['email_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Email Field </div>"; }?>
    <?php if(!isset($_SESSION['email_empty'])){  if(isset($_SESSION['email_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Invalid Email </div>"; }}?>
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" value="<?php if(isset($_SESSION['value_email'])){echo "{$_SESSION['value_email']}";} ?>" name="email" id="email" >
    
    <?php if(isset($_SESSION['address_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Address Field </div>"; }?>
    <?php if(!isset($_SESSION['address_empty'])){  if(isset($_SESSION['address_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Address Error </div>"; }}?>
    <label for="Address"><b>Address  </b></label><span><small></small></span>
    <textarea placeholder="Enter address" name="address" id="address" cols="30" rows="5"><?php if(isset($_SESSION['value_address'])){echo "{$_SESSION['value_address']}";} ?></textarea>

    
    <?php if(isset($_SESSION['pin_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Pin-Code Field </div>"; }?>
    <?php if(!isset($_SESSION['pin_empty'])){  if(isset($_SESSION['pin_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Invalid Pin-Code </div>"; }}?>
    <label for="pin"><b>Pin Code</b></label>
    <input type="text" placeholder="Enter Pin Code" value="<?php if(isset($_SESSION['value_pin'])){echo "{$_SESSION['value_pin']}";} ?>" name="Pin" id="phone" >

    
    <?php if(isset($_SESSION['phone_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Phone Field </div>"; }?>
    <?php if(!isset($_SESSION['phone_empty'])){  if(isset($_SESSION['phone_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Enter Phone Number Without Country Code</div>"; }}?>
    <label for="phone"><b>Phone  </b></label><span><small> </small></span>
    <input type="text" placeholder="Enter Phone" value="<?php if(isset($_SESSION['value_phone'])){echo "{$_SESSION['value_phone']}";} ?>" name="phone" id="phone" >

    
    <?php if(isset($_SESSION['password_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Password Field </div>"; }?>
    <?php if(!isset($_SESSION['password_empty'])){  if(isset($_SESSION['password_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Length Of Password Must Be Greater Than 5 </div>"; }}?>
    <label for="psw"><b>Password  </b></label><span><small></small></span>
    <input type="password" autocomplete="new-password" placeholder="Enter Password" value="<?php if(isset($_SESSION['value_password'])){echo "{$_SESSION['value_password']}";} ?>" name="password" id="psw" >
    
    
    <?php if(isset($_SESSION['con_password_empty'])){ echo "<div class='alert alert-warning' role='alert'><i class='fas fa-exclamation'></i> Empty Repeat Password Field </div>"; }?>
    <?php if(!isset($_SESSION['con_password_empty'])){  if(isset($_SESSION['con_password_error'])){ echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation'></i> Repeat Password Didn't Match </div>"; }}?>
    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="con_password" id="psw-repeat" autocomplete="new-password">
    <?php if(isset($_SESSION['Weak_password'])){ echo "<div class='alert alert-danger' role='alert'>error password too weak </div>"; } ?>
    <hr>
    

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="containerr signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>
</form>
<script>
document.getElementById('address').placeholder = "Enter address";
</script>
<?php require 'footer.php'; ?>
</body>
</html>
<?php
// session_unset();
?>