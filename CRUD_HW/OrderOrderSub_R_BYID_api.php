<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbtools.php");
$data = file_get_contents("php://input","r");       //取得由外部傳入的參數

$Jsondata = array();    //宣告 json 陣列 => $Jsondata
$Jsondata = json_decode($data,true);

if(isset($Jsondata["userID"])){
    if($Jsondata["userID"] != "" ){

        $p_userID = $Jsondata["userID"];

        $conn = create_connect();     //dbtools.php
        $sql = "SELECT * FROM ordersub WHERE ordersub.UserId = '$p_userID' ORDER BY ID DESC";

        //$rs1=mysqli_query($conn,$sql);
        $rs = execute_sql($conn, "myShop", $sql);       //dbconn.php

        if (mysqli_num_rows($rs) >0){    //判斷select 是否有資料 或是 有正確讀取    
          $mydata=array();
          while($rowdata=mysqli_fetch_assoc($rs)){
            $mydata[]=$rowdata;
          }
          echo '{"state":true,"message":"Success","data":' . (json_encode($mydata)) .'}';
          
        }else{             
          echo '{"state" :false,"message":"讀取資料失敗或查無此資料 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';      
        }
        mysqli_close($conn);        //結束連線   

  }else{
    echo '{"state": false, "message":"欄位不得為空白!"}';
}
}else{
echo '{"state": false, "message":"缺少規定欄位!"}';
}
?>