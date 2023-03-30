<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbtools.php");
$data = file_get_contents("php://input","r");       //取得由外部傳入的參數

$jsonData = array();    //宣告 json 陣列 => $Jsondata
$jsonData = json_decode($data,true);

if(isset($jsonData["ID"])){
  if($jsonData["ID"] != ""){

      $p_ID = $jsonData["ID"];


      $dbname = "myShop";

      $conn = create_connect();

      if(!$conn){
          die("連線失敗".mysqli_connect_error());
      }
      
      $sql = "DELETE FROM `ordersub` WHERE `ordersub`.`ID` = '$p_ID' " ; 

      $result = execute_sql($conn,$dbname,$sql);
      
      if($result && $result == 1){   
          echo '{"state": true, "message":"刪除資料成功!"}';
      }else{
          echo '{"state": false, "message":"刪除資料失敗!"'.$sql.mysqli_error($conn).'}';
      }
      mysqli_close($conn);
  }else{
      echo '{"state": false, "message":"欄位不得為空白!"}';
  }
}else{
  echo '{"state": false, "message":"缺少規定欄位!"}';
}

?>