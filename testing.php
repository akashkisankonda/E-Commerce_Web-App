<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    $dbserver = "fdb27.biz.nf";
    $dbusername = "3842403_ecommerce";
    $dbpassword = "1261110@a";
    $dbdatabase = "3842403_ecommerce";
    $con = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
    if(!$con){
      die(mysqli_connect_error());
    }
    $sql = "SELECT * FROM products;";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $table_name = $row['p name'];
            require "database-connection.php";
            $sql2 = "CREATE TABLE `$dbdatabase`.`$table_name` ( `email` VARCHAR(100) NOT NULL ,  `rating` INT(10) NOT NULL ,  `review` TEXT NOT NULL ,  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB;";
            mysqli_query($con, $sql2);
        }
    }
    
    
    
    
    
    ?>
</body>
</html>