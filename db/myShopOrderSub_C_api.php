<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"Orderno":"2212310010","Product_ID":"12","Pname":"烏龍綠","Price":"45","Pnum":"3","Points":"0","SweetID":"半糖","TempID":"去冰","CapacityID":"L","Account":"450"}

$data = file_get_contents("php://input","r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["Orderno"]) && isset($Jsondata["Product_ID"]) && isset($Jsondata["Pnam"]) && isset($Jsondata["Price"]) && isset($Jsondata["Pnum"]) && isset($Jsondata["Points"]) && isset($Jsondata["SweetID"]) && isset($Jsondata["TempID"]) && isset($Jsondata["CapacityID"]) && isset($Jsondata["Account"])){

    if ($Jsondata["Orderno"] != "" && $Jsondata["Product_ID"] != "" && $Jsondata["Pnam"] != "" && $Jsondata["Price"] != "" && $Jsondata["Pnum"] != "" && $Jsondata["Points"] != "" && $Jsondata["SweetID"] != "" && $Jsondata["TempID"] != "" && $Jsondata["CapacityID"] != "" && $Jsondata["Account"] != ""){

        $pOrderno = $Jsondata["Orderno"];
        $pProduct_ID = $Jsondata["Product_ID"];
        $pPnam = $Jsondata["Pnam"];
        $pPrice = $Jsondata["Price"];
        $pPnum = $Jsondata["Pnum"];
        $pPoints = $Jsondata["Points"];
        $pSweetID = $Jsondata["SweetID"];        
        $pTempID = $Jsondata["TempID"];
        $pCapacityID = $Jsondata["CapacityID"];
        $pPoints = $Jsondata["Account"];

        $conn=create_connect();     //dbtools.php

        $sql="INSERT INTO OrderSub (Orderno,Product_ID,Pname,Price,Pnum,Points,SweetID,TempID,CapacityID,Account) Values ('$pOrderno','$pProduct_ID','$pPname','$pPrice','$pPnum','$pPoints','$pSweetID','$pTempID','$pCapacityID','$pAccount')";

        $result=execute_sql($conn,"myShop",$sql);       //dbconn.php
        if ($result){
            //echo "新增資料成功 !!";
            echo '{"state":true,"message":"新增資料成功 !!"}';
        }else{
            //echo "新增資料失敗 ... 請重新輸入 !!";
            echo "新增資料失敗 ... 請重新輸入 !!";
            echo '{"state":false,"message":"新增資料失敗 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';
        }
    } else {
        //echo "欄位傳遞空值 ... 請重新輸入 !!";    
        echo '{"state":false,"message":"欄位傳遞空值 !!"}';
    }            
} else {
    //echo "欄位傳遞資料失敗 ... 請重新輸入 !!";
    echo '{"state":false,"message":"欄位傳遞資料失敗 !!"}';
}
mysqli_close($conn);        //結束連線
?>