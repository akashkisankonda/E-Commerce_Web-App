<?php
session_start();
$user_cart = $_SESSION['ACCOUNT_EMAIL'] . "_cart";

class validation{
    public $result;
    function validate($sql){
        require 'database-connection.php';
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
            $this->result = $result;
            return true;
        }else{
            return false;
        }
    }
    function add_database($sql){
        require 'database-connection.php';
        if(mysqli_query($con, $sql)){
            return true;
        }else{
            return false;
        }
    }
}

function finding_price($data){
    $obj_for_getting_price = new validation();
    if($obj_for_getting_price->validate("SELECT * FROM `products` WHERE `p name`='$data';")){
        while($row = mysqli_fetch_assoc($obj_for_getting_price->result)){
            return (int) $row['p price'];
        }
    }else{
        die('price not found');
    }
}
function finding_img($data){
    $obj_for_getting_image = new validation();
    if($obj_for_getting_image->validate("SELECT * FROM `products` WHERE `p name`='$data';")){
        while($row = mysqli_fetch_assoc($obj_for_getting_image->result)){
            return $row['img 1'];
        }
    }else{
        die('img 1 not found');
    }
}
function validating_quantity($data){
    $data = (int) $data;
    if($data < 1){
        die('quantity error');
    }else{
        return $data;
    }
}
function validating_color($data){
    //allows only alphabets
    if(!preg_match("/^([a-zA-Z ]+)$/",$data)){
    die('Invalid color given.');
        }
    $obj_for_validating_color = new validation();
    if($obj_for_validating_color->validate("SELECT * FROM `products` WHERE `color 1`='$data' OR `color 2`='$data' OR `color 3`='$data';")){
        return $data;
    }else{
        die('color not found');
    }
}
function existance_check($product, $quantity, $color){
            global $user_cart;
            $obj_for_exix_check = new validation();
            if($obj_for_exix_check->validate("SELECT * FROM `$user_cart` WHERE `p name`='$product' AND `p quantity`='$quantity' AND `p color`='$color';")){
              return true;
            }else{
              return false;
            }
          }
          
if(isset($_GET['add_cart'])){
      $quantity = validating_quantity($_GET['quantity']);
      $p_color = validating_color($_GET['selected_color']);
      $p_name = $_SESSION['product_name'];
      $p_price = finding_price($p_name);
      $image = finding_img($p_name);
      
      if(existance_check($p_name, $quantity, $p_color)){
        echo "<script> window.location = 'cart.php'; </script>";
      }else{
      $p_price = $quantity * $p_price;
      
      $obj_for_data_insert = new validation();
      if($obj_for_data_insert->add_database("INSERT INTO `$user_cart` (`p name`, `p price`, `p quantity`, `p img`, `p color` , `time`) VALUES ('$p_name', '$p_price', '$quantity', '$image', '$p_color', current_timestamp());")){
        echo "<script> window.location = 'cart.php'; </script>";
      }else{
        die(mysqli_error($con));
      }
     }
    }
    ?>