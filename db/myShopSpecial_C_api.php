<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"Typename":"Hot","Product_ID":"7","Picon":"../image/Hot.png"}

$data = file_get_contents("php://input","r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["Typename"]) && isset($Jsondata["Product_ID"]) && isset($Jsondata["Picon"])){

    if ($Jsondata["Typename"] != "" && $Jsondata["Product_ID"] != "" && $Jsondata["Picon"] != ""){

        $pTypename = $Jsondata["Typename"];        
        $pProduct_ID = $Jsondata["Product_ID"];
        $pPicon = $Jsondata["Picon"];
 
        $conn=create_connect();     //dbtools.php

        $sql="INSERT INTO Special (Typename,Product_ID,Picon) Values ('$pTypename','$pProduct_ID','$pPicon')";

        $result=execute_sql($conn,"myShop",$sql);       //dbconn.php
        if ($result){
            //echo "新增資料成功 !!";
            echo '{"state":true,"message":"新增資料成功 !!"}';
        }else{
            //echo "新增資料失敗 ... 請重新輸入 !!";
            echo "新增資料失敗 ... 請重新輸入 !!";
            echo '{"state":false,"message":"新增資料失敗 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';
        }
        mysqli_close($conn);        //結束連線
    } else {
        //echo "欄位傳遞空值 ... 請重新輸入 !!";    
        echo '{"state":false,"message":"欄位傳遞空值 !!"}';
    }            
} else {
    //echo "欄位傳遞資料失敗 ... 請重新輸入 !!";
    echo '{"state":false,"message":"欄位傳遞資料失敗 !!"}';
}

?>