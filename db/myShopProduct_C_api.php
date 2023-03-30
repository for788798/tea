<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"Sort_ID":"12","Pname":"烏龍綠茶","Pdimg":"xxxx","Information":"good drink","Price":"50","DisPrice":"45","Points":"0"}

$data = file_get_contents("php://input","r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["Sort_ID"]) && isset($Jsondata["Pname"]) && isset($Jsondata["Information"]) && isset($Jsondata["Price"]) && isset($Jsondata["DisPrice"]) && isset($Jsondata["Points"])){


    if ($Jsondata["Sort_ID"] != "" && $Jsondata["Pname"] != "" && $Jsondata["Information"] != "" && $Jsondata["Price"] != "" && $Jsondata["DisPrice"] != "" && $Jsondata["Points"] != ""){

        $pSort_ID = $Jsondata["Sort_ID"];
        $pPname = $Jsondata["Pname"];
        $pPdimg = $Jsondata["Pdimg"];
        $pInformation = $Jsondata["Information"];
        $pPrice = $Jsondata["Price"];
        $pDisPrice = $Jsondata["DisPrice"];
        $pPoints = $Jsondata["Points"];

        $conn=create_connect();     //dbtools.php

        $sql="INSERT INTO Product (Sort_ID,Pname,Pdimg,Information,Price,DisPrice,Points) Values ('$pSort_ID','$pPname','$pPdimg','$pInformation','$pPrice','$pDisPrice','$pPoints')";

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