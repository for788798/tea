<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"MemberID":"231","Orderno":"2212310015","OrderSubID":"12345","Points_before":"100","Points_after":"40"}

$data = file_get_contents("php://input","r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["MemberID"]) && isset($Jsondata["Orderno"]) && isset($Jsondata["OrderSubID"]) && isset($Jsondata["Points_before"]) && isset($Jsondata["Points_after"]) && isset($Jsondata["Points"])){


    if ($Jsondata["MemberID"] != "" && $Jsondata["Orderno"] != "" && $Jsondata["OrderSubID"] != "" && $Jsondata["Points_before"] != "" && $Jsondata["Points_after"] != ""){

        $pMemberID = $Jsondata["MemberID"];
        $pOrderno = $Jsondata["Orderno"];
        $pOrderSubID = $Jsondata["OrderSubID"];
        $pPoints_before = $Jsondata["Points_before"];
        $pPoints_after = $Jsondata["Points_after"];

        $conn=create_connect();     //dbtools.php

        $sql="INSERT INTO Bonus (MemberID,Orderno,OrderSubID,Points_before,Points_after) Values ('$pMemberID','$pOrderno','$pOrderSubID','$pPoints_before','$pPoints_after')";

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