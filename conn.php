<?php
$servename = "localhost";
$username = "owner";
$password = "123456";
$dbname = "myshop" ;

$conn = mysqli_connect($servename,$username,$password,$dbname);
if(!$conn){
    die("false:".mysqli_connect_error());
}

?>