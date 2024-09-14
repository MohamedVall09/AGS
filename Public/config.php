<?php
$dsn = 'mysql:host=localhost;dbname=ags_db';
$user = 'root';
$pass= '';
$option =array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);

try{
    $con = new PDO($dsn, $user , $pass , $option);
    $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    // echo '<div class="green">Connected successfully</div>';
}
catch(PDOException $e){
    // echo $e;
    echo '<div class="red">The connection was not made. There was error</div>';
}