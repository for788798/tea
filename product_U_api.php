<?php
// {    
//     "id":"XX",
//     "pname":"XX",
//     "pdimg":"XX",
//     "information":"XX",
//     "price":"XX"
// }

require_once("conn.php");
$data = file_get_contents("php://input","r");
$jsonData = array();
$jsonData = json_decode($data,true);

$id = $jsonData["id"];
$pname = $jsonData["pname"];
$pdimg = $jsonData["pdimg"];
$information = $jsonData["information"];
$price = $jsonData["price"];

$sql = "UPDATE `Product` SET `Pname` = '$pname', `Pdimg` = '$pdimg', `Information` = '$information' , `Price` = '$price' WHERE `Product`.`ID` = '$id';";

mysqli_query($conn,'SET NAMES utf8');

if(mysqli_query($conn, $sql)){
    echo('{"state":true,"message":"更新資料成功"}');
}
else{
    echo('{"state":false,"message:更新資料失敗'.$sql.mysqli_error($conn).'}');

}

mysqli_close($conn);




?>