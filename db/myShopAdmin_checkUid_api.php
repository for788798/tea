<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"UID01":"AAA" , "UID02":"123456" , "UID03":"SDFGH"}
$data = file_get_contents("php://input","r"); 

//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

 // isset() 判斷是否有傳遞此欄位 ,判斷是否有把所有指定之欄位都有傳遞進來
if (isset($Jsondata["UID01"]) && isset($Jsondata["UID02"]) && isset($Jsondata["UID03"])){
    if ($Jsondata["UID01"] != "" && $Jsondata["UID02"] != "" && $Jsondata["UID03"] != ""){
        // 由POST 傳入 改 json 格式 
        $puid01=$Jsondata["UID01"];
        $puid02=$Jsondata["UID02"];
        $puid03=$Jsondata["UID03"];
        $conn=create_connect();     //dbtools.php

        $sql="SELECT ID,Username,Email,UserState,Create_at from member where UID01='$puid01' and UID02='$puid02' and UID03='$puid03'";
        $rs=execute_sql($conn,"myShop",$sql);       //dbtools.php
        
        if (mysqli_num_rows($rs) > 0) {    //判斷select 是否有資料 或是 有正確讀取
            //UID合法
            $mydata = array();
            $rowdata = mysqli_fetch_assoc($rs);
            echo '{"state": true, "message":"會員登入狀態成功 !","data":' . (json_encode($rowdata)) . '}';
        } else {
            //UID非法
            echo '{"state": false,"message":"登入失敗或查無此資料 !"}';
        }

    } else {
        //echo "欄位傳遞空值 ... 請重新輸入 !!";    
        echo '{"state":false,"message":"欄位傳遞空值 !!"}';
    }            
} else {
    //echo "欄位傳遞資料失敗 ... 請重新輸入 !!";
    echo '{"state":false,"message":"欄位傳遞資料失敗 !!"}';
}

?>