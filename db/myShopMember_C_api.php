<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"Username":"XXXXX","Pwd":"1234qwerASDF","Sex":"男","Tel":"1234567890","Address":"XXXXXXXXXXXXXXX","Usertype":"1","Photo":"../image/xx.jpg","LineID":"@AAA","Bonuspoint":"0"}

$data = file_get_contents("php://input","r");
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["Username"]) && isset($Jsondata["Pwd"]) && isset($Jsondata["Sex"]) && isset($Jsondata["Tel"]) && isset($Jsondata["Address"]) && isset($Jsondata["Usertype"]) && isset($Jsondata["Photo"]) && isset($Jsondata["LineID"]) && isset($Jsondata["BonuspointD"])){

    if ($Jsondata["Username"] != "" && $Jsondata["Pwd"] != "" && $Jsondata["Sex"] != "" && $Jsondata["Tel"] != "" && $Jsondata["Address"] != "" && $Jsondata["Usertype"] != "" && $Jsondata["Photo"] != "" && $Jsondata["LineID"] != "" && $Jsondata["BonuspointD"] != ""){

        $pUsernam = $Jsondata["Username"];
        $pPwd = $Jsondata["Pwd"];
        $pSex = $Jsondata["Sex"];
        $pTel = $Jsondata["Tel"];
        $pAddress = $Jsondata["Address"];
        $pUsertype = $Jsondata["Usertype"];
        $pPhoto = $Jsondata["Photo"];
        $pLineID = $Jsondata["LineID"];
        $pBonuspoint = $Jsondata["Bonuspoint"];

        $conn=create_connect();     //dbtools.php

        $sql="INSERT INTO Member (Username,Pwd,Sex,Tel,Address,Usertype,Photo,LineID,Bonuspoint) Values ('$pUsername', '$pPwd', '$pSex', '$pTel', '$pAddress', '$pUsertype', '$pPhoto', '$pLineID', '$pBonuspoint')";

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