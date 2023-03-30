<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");

//接收json 格式 ==> {"ID":"1"}
$data = file_get_contents("php://input","r");       //取得由外部傳入的參數

$Jsondata = array();    //宣告 json 陣列 => $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["ID"])){    //檢查所有欄位是否有傳遞到位
    if ($Jsondata["ID"] != ""){      //檢查所有欄位是否有空值存在
        $pID = $Jsondata["ID"];

        $conn=create_connect();     //dbtools.php
        $sql="Select * from Product where ID='$pID'";        
        $rs=execute_sql($conn,"myShop",$sql);       //dbconn.php

        if (mysqli_num_rows($rs) >0){    //判斷select 是否有資料 或是 有正確讀取    
            $mydata=array();
            while($rowdata=mysqli_fetch_assoc($rs)){
              $mydata[]=$rowdata;
            }
            echo '{"state":true,"message":"Success","data":' . (json_encode($mydata)) .'}';
            //json 格式 ==> {"ID":"1","Sort_ID":"12","Pname":"烏龍綠茶","Pdimg":"xxxx","Information":"good drink","Price":"50","DisPrice":"45","Points":"0","Created_at":"2023/01/05 12:34:56"} 
        }else{             
            echo '{"state" :false,"message":"讀取資料失敗或查無此資料 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';      
        }
        mysqli_close($conn);        //結束連線    
    }else{
        //echo "欄位傳遞空值 ... 請重新輸入 !!";    
        echo '{"state":false,"message":"欄位傳遞空值 !!"}';
    }            
}else{
    //echo "欄位傳遞資料失敗 ... 請重新輸入 !!";
    echo '{"state":false,"message":"欄位傳遞資料失敗 !!"}';
}
?>