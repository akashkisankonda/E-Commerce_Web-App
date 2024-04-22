<?php
session_start();
//unsetting previously set error session veriables
session_unset();
class validation{
    public $errors;
    public $data;
    function __construct($data)
    {
        $this->data = $data;   
        foreach($this->data as $key => $value){
            //if value is empty, store in errors and set session to display in register-page
            if(empty($value)){
                $_SESSION["$key".'_empty'] = 'set';
                $this->errors[] = "$key".'_empty';
            }
            //holding the values after register click
            if(!empty($value)){
                $_SESSION['value_' ."$key"] = $value;
            }
        }     
    }
    function username(){
        $this->data['username'] = str_replace(' ', '', $this->data['username']);
        if(!preg_match("/^([a-zA-Z]+)$/",$this->data['username']) || strlen($this->data['username']) < 3){
            $_SESSION['username_error'] = 'set';
            $this->errors[] = 'username_error';
        }
    }
    function email(){
        if(!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['email_error'] = 'set';
            $this->errors[] = 'email_error';
        }
    }
    function address(){
        if(str_word_count($this->data['address']) < 2){
            $_SESSION['address_error'] = 'set';
            $this->errors[] = 'address_error';
        }
    }
    function pin(){
        $pin = (int) $this->data['pin'];
        $pin = str_replace('e', '', $this->data['pin']);
        if(strlen($pin) < 6 || strlen($pin) > 6){
            $_SESSION['pin_error'] = 'set';
            $this->errors[] = 'pin_error';
    }
    }
    function phone(){
        $phone = str_replace('e', '', $this->data['phone']);
        $phone = preg_replace( '/[^0-9]/', '', $phone);
        if(strlen($phone) < 10 || strlen($phone) > 10){
            $_SESSION['phone_error'] = 'set';
            $this->errors[] = 'phone_error';
        }
    }
    function password(){
        $check = str_replace(' ', '', $this->data['password']);;
        if(strlen($check) < 6){
            $_SESSION['password_error'] = 'set';
            $this->errors[] = 'password_error';
        }
    }
    function con_password(){
        if($this->data['con_password'] !== $this->data['password']){
            $_SESSION['con_password_error'] = 'set';
            $this->errors[] = 'con password_error';
        }
    }
}
class account_check{
    public $email;
    public $error;
    function __construct($data)
    {
        $this->email = $data['email'];
    }
    function check(){
        $email = $this->email;
        require 'database-connection.php';
        $email = mysqli_real_escape_string($con, $email);
        $sql = "SELECT email FROM accounts WHERE email='$email';";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
            $_SESSION['account_available'] = $email;
            $this->error[] = 'account available'; 
        }
    }
}

class essentials_and_account{
    public $data;
    function __construct($data)
    {
        $this->data = $data;
    }
    function creating_account(){
        require "database-connection.php";
        $username = mysqli_real_escape_string($con, $this->data['username']);
        $email = mysqli_real_escape_string($con, $this->data['email']);
        $password = password_hash(mysqli_real_escape_string($con, $this->data['password']), PASSWORD_DEFAULT);
        $address = mysqli_real_escape_string($con, $this->data['address']);
        $pincode = mysqli_real_escape_string($con, $this->data['pin']);
        $phone = mysqli_real_escape_string($con, $this->data['phone']);
        $sql = "INSERT INTO `accounts` (`username`, `email`, `password`, `address`, `pin`, `phone`) VALUES ('$username', '$email', '$password', '$address', '$pincode', '$phone');";
        mysqli_query($con, $sql) or die('account creation failed');
    }
    function creating_tables(){
        require "database-connection.php";
        $table_cart_name = $this->data['email'] . "_cart";
        $table_order_name = $this->data['email'] . "_order";
        $table_recent_name = $this->data['email'] . "_recent";
        $sql1 = "CREATE TABLE `$dbdatabase`.`$table_cart_name` ( `p name` VARCHAR(100) NOT NULL ,  `p price` VARCHAR(100) NOT NULL ,  `p quantity` INT(100) NOT NULL ,  `p img` VARCHAR(100) NOT NULL ,  `p color` VARCHAR(100) NOT NULL , `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB;";
        $sql2 = "CREATE TABLE `$dbdatabase`.`$table_order_name` ( `p name` VARCHAR(100) NOT NULL ,  `p price` VARCHAR(100) NOT NULL ,  `p quantity` INT(100) NOT NULL ,  `p img` VARCHAR(100) NOT NULL ,  `p color` VARCHAR(100) NOT NULL , `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB;";
        $sql3 = "CREATE TABLE `$dbdatabase`.`$table_recent_name` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,  `img` VARCHAR(100) NOT NULL ,  `p name` VARCHAR(100) NOT NULL ,  `p price` INT(100) NOT NULL ,  `d price` INT(100) NOT NULL ,  `time` TIMESTAMP NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;";
        mysqli_query($con, $sql1) or die('sql11 query failed');
        mysqli_query($con, $sql2) or die('sql12 query failed');
        mysqli_query($con, $sql3) or die('sql13 query failed');
    }
}

if($_POST){
$data = array('username' => addslashes("{$_POST['username']}"), 'email' => strtolower(addslashes("{$_POST['email']}")), 'address' => addslashes("{$_POST['address']}"), 'pin' => addslashes("{$_POST['Pin']}"), 'phone' => addslashes("{$_POST['phone']}"), 'password' => addslashes("{$_POST['password']}"), 'con_password' => addslashes("{$_POST['con_password']}"));

$validate = new validation($data);
$validate->username();
$validate->email();
$validate->address();
$validate->pin();
$validate->phone();
$validate->password();
$validate->con_password();

//process further if no errors
if(empty($validate->errors)){
 $check = new account_check($data);
 $check->check();

if(empty($check->error)){
$creating = new essentials_and_account($data);
$creating->creating_account();
$creating->creating_tables();
}else{
echo "<script>window.location = 'register.php' </script>";
}
}else{
echo "<script>window.location = 'register.php' </script>";
}
$_SESSION['acc_created'] = 'set';
echo "<script>window.location = 'login.php' </script>";

}else{
echo "<script>window.location = 'login.php' </script>";
}
?>