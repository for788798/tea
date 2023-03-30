<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"Orderno":"2212250001","CountC":"12","Total":650","Memo":"17:00前送到","Chkorder":"0"}

$data = file_get_contents("php://input","r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["Orderno"]) && isset($Jsondata["CountC"]) && isset($Jsondata["Total"]) && isset($Jsondata["Memo"]) && isset($Jsondata["Chkorder"])){

    if ($Jsondata["Orderno"] != "" && $Jsondata["CountC"] != "" && $Jsondata["Total"] != "" && $Jsondata["Memo"] != "" && $Jsondata["Chkorder"] != ""){

        $pSort_ID = $Jsondata["Orderno"];
        $pPname = $Jsondata["CountC"];
        $pPdimg = $Jsondata["Total"];
        $pInformation = $Jsondata["Memo"];
        $pPrice = $Jsondata["Chkorder"];

        $conn=create_connect();     //dbtools.php

        $sql="INSERT INTO OrderPrimary (Orderno,CountC,Total,Memo,Chkorder) Values ('$pOrderno','$pCountC','$pTotal','$pMemo','$pChkorder')";

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