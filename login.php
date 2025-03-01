<?php 
session_start();
if(isset($_SESSION['account_deleted'])){
unset($_SESSION['ACCOUNT_EMAIL']);
unset($_SESSION['ACCOUNT_PASSWORD']);
}
if(isset($_SESSION['password_changed'])){
unset($_SESSION['ACCOUNT_EMAIL']);
unset($_SESSION['ACCOUNT_PASSWORD']);
}
if (isset($_SESSION['ACCOUNT_EMAIL']) && isset($_SESSION['ACCOUNT_PASSWORD'])) {
    echo "<script>window.location = 'index.php'; </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.containerrr {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.containerrr input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.containerrr:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.containerrr input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.containerrr input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.containerrr .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
            body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: black;
        }

        * {
        box-sizing: border-box;
        }

        /* Add padding to containerrrs */
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
        #show_error{
            color: #eaeaea;
            padding: 10px;
            font-size: 13px;
            border:2px solid red;
            background-color: #ff3333;
            text-transform: capitalize;
        }
        .underline_login{
        border-bottom: 3px solid greenyellow;
        }
</style>
</head>
<body>
<?php require 'header.php' ?>
    <div class="page-heading header-text">
         <div style="background-color: transparent; z-index:-1000;" class="containerr">
            <div  class="row">
               <div  class="col-md-12">
                  <h1>Login</h1>
                  <span>Please Login</span>
               </div>
            </div>
         </div>
      </div>


<?php if(isset($_SESSION['password_changed'])){ echo "<div class='alert alert-success' role='alert'> Password Changed Successfully Please Log-in.</div>"; } ?>
<?php if(isset($_SESSION['account_deleted'])){ echo "<div class='alert alert-danger' role='alert'> Account Deleted Successfully.</div>"; } ?>
<?php if(isset($_SESSION['acc_created'])){ echo "<div class='alert alert-success' role='alert'>Account Created Successfully Please Log-in.</div>"; } ?>
<form action="login-process.php" method="POST">
  <div class="container">
    <h1>Login</h1>
    <p>Please fill in this form to log into your account.</p>
    <hr>
    <?php if(isset($_SESSION['inval_credintials'])){ echo "<p id='show_error'>Invalid Log-in Credentials. <br> <small>( dont have an account? click<a style='color:white;' href='register.php'> here</a> to register )</small></p>";} ?>
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" value="<?php if(isset($_SESSION['email_value'])){echo $_SESSION['email_value'];} ?>" name="email" id="email" >
    
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="psw" >

    <label class="containerrr">Keep Me Logged-In
  <input type="checkbox" name="remember" value="remember">
  <span class="checkmark"></span>
</label>

    <hr>
    <p>Forgot Password <a href="contact.html">Contact Us</a>.</p>
    <p>By logging in you agree to our <a href="about.html">Terms & Privacy</a>.</p>

    <button type="submit" class="registerbtn">Login</button>
  </div>
  
  <div class="container signin">
    <p>Don't have an account? <a href="register.php">Sign up</a>.</p>
  </div>
</form>

<?php require 'footer.php'; 
session_unset();
?>
</body>
</html>
