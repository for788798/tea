<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"ID":"2"}
$data = file_get_contents("php://input","r");       //取得由外部傳入的參數

$Jsondata = array();    //宣告 json 陣列 => $Jsondata
$Jsondata = json_decode($data,true);

if (isset($Jsondata["ID"])){    //檢查所有欄位是否有傳遞到位
    if ($Jsondata["ID"] != ""){      //檢查所有欄位是否有空值存在
        $pID = $Jsondata["ID"];

        $conn=create_connect();     //dbtools.php
        $sql="Delete from Product where ID='$pID'";                
        
        if(execute_sql($conn,"myShop",$sql)) {
            if (mysqli_affected_rows($conn)>0){    //判斷select 是否有資料 或是 有正確讀取    
                echo '{"state":true,"message":"資料刪除成功 !!"}';
            }else{      
                echo '{"state" :false,"message":"無資料可刪除 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';
            }
        }else{      
            echo '{"state" :false,"message":"資料刪除失敗 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';
        }
        mysqli_close($conn);        //結束連線 
    } else {    
        echo '{"state":false,"message":"欄位傳遞空值 !!"}';
    }            
} else {
    echo '{"state":false,"message":"欄位傳遞資料失敗 !!"}';
}
?>


