<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbtools.php");
//接收json 格式 ==> {"Orderno":"2212310010","Product_ID":"12","Pname":"烏龍綠","Price":"45","Pnum":"3","Points":"0","SweetID":"半糖","TempID":"去冰","CapacityID":"L","Account":"450"}

$data = file_get_contents("php://input", "r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data, true);

if (isset($Jsondata["Name"]) && isset($Jsondata["Phone"]) && isset($Jsondata["Take_mael"]) && isset($Jsondata["Adress"]) && isset($Jsondata["Pay"]) && isset($Jsondata["Money"]) && isset($Jsondata["Orderno"]) && isset($Jsondata["ID"])) {

    if ($Jsondata["Name"] != "" && $Jsondata["Phone"] != "" && $Jsondata["Take_mael"] != "" && $Jsondata["Adress"] != "" && $Jsondata["Pay"] != "" && $Jsondata["Money"] != "" && $Jsondata["Orderno"] != "" && $Jsondata["ID"] != "") {

        $pName = $Jsondata["Name"];
        $pPhone = $Jsondata["Phone"];
        $pTake_mael = $Jsondata["Take_mael"];
        $pAdress = $Jsondata["Adress"];
        $pPay = $Jsondata["Pay"];
        $pMoney = $Jsondata["Money"];
        $pOrderno = $Jsondata["Orderno"];
        $puserId = $Jsondata["ID"];
        $conn = create_connect();     //dbtools.php

        $sql = "INSERT INTO Member_buy (Name,Phone,Take_mael,Adress,Pay,Money,Orderno,userId) Values ('$pName','$pPhone','$pTake_mael','$pAdress','$pPay','$pMoney','$pOrderno','$puserId')";

        $result = execute_sql($conn, "myShop", $sql);       //dbconn.php
        if ($result) {
            //echo "新增資料成功 !!";
            echo '{"state":true,"message":"新增資料成功 !!"}';
        } else {
            //echo "新增資料失敗 ... 請重新輸入 !!";
            echo "新增資料失敗 ... 請重新輸入 !!";
            echo '{"state":false,"message":"新增資料失敗 !! ...err Code:"' . $sql . mysqli_error($conn) . '}';
        }
        // mysqli_close($link);        //結束連線

    } else {
        //echo "欄位傳遞空值 ... 請重新輸入 !!";    
        echo '{"state":false,"message":"欄位傳遞空值 !!"}';
    }
} else {
    //echo "欄位傳遞資料失敗 ... 請重新輸入 !!";
    echo '{"state":false,"message":"欄位傳遞資料失敗 !!"}';
}
