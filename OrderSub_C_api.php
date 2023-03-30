<?php
// {    
//     "p_name":"XX",
//     "p_totalPrice":"",
//     "p_price":"",
//     "p_num":"XX",
//     "p_sugar":"XX",
//     "p_ice":"XX",
//     "p_size":"XX",
//     "userId":""
// }

require_once("conn.php");
$data = file_get_contents("php://input","r");
$jsonData = array();
$jsonData = json_decode($data,true);

$p_name = $jsonData["Pname"];
$p_price = $jsonData["Price"];
$p_totalPrice = $jsonData["Account"];
$p_num = $jsonData["Pnum"];
$p_sugar = $jsonData["Sweet"];
$p_ice = $jsonData["Temp"];
$p_size = $jsonData["Capacity"];
$userId = $jsonData["UserId"];
$Orderno = $jsonData["Orderno"];

$sql = "INSERT INTO `OrderSub` (`Orderno`,`UserId`,`Pname`,`Price`, `Pnum`,`Sweet`, `Temp`, `Capacity`,`Account`) VALUES ('$Orderno','$userId','$p_name', '$p_price', '$p_num', '$p_sugar', '$p_ice', '$p_size','$p_totalPrice')";
mysqli_query($conn,'SET NAMES utf8');
if(mysqli_query($conn, $sql)){
    echo('{"state":true,"message":"新增資料成功"}');
}
else{
    echo('{"state":false,"message:新增資料失敗'.$sql.mysqli_error($conn).'}');

}

mysqli_close($conn);




?>