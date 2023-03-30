<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"Username":"AAA" , "Password":"123456" , "Email":"AAA@gmail.com"}
$data = file_get_contents("php://input","r"); 

//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

 // isset() 判斷是否有傳遞此欄位 ,判斷是否有把所有指定之欄位都有傳遞進來
if (isset($Jsondata["Username"]) && isset($Jsondata["Password"])){
    if ($Jsondata["Username"] != "" && $Jsondata["Password"] != ""){
        // 由POST 傳入 改 json 格式 
        $pUsername=$Jsondata["Username"];
        $pPassword=$Jsondata["Password"];
        

        $conn=create_connect();     //dbtools.php

        //$sql="Select * from member where Username='$pUsername' and Password='$pPassword'";
        $sql="SELECT Username,Password FROM member where Username='$pUsername'";
        $rs=execute_sql($conn,"myShop",$sql);       //dbtools.php
        
        if (mysqli_num_rows($rs) == 1){    //判斷select 是否有資料符合 
            //撈出密碼, 比對輸入的密碼是否正確
            $rowdata=mysqli_fetch_assoc($rs); 
            $hash=$rowdata["Password"];
            if (password_verify($pPassword,$hash)){   //密碼驗證成功
                //產生UID 10碼 -> 做為 COOKIE 使用
                $uid01=substr(hash("sha256",md5(rand())),40,10);
                $uid02=substr(md5(hash("sha256",rand())),1,10);
                $uid03=substr(md5(hash("sha256",uniqid())),10,10);
                $sql="UPDATE member Set UID01='$uid01',UID02='$uid02',UID03='$uid03' where Username='$pUsername'";
                execute_sql($conn,"myShop",$sql);
                
                //撈取除了密碼以外的資料
                $sql="SELECT Username,UserState,UID01,UID02,UID03 from member where Username='$pUsername'";
                $rs=execute_sql($conn,"myShop",$sql);
                $row=mysqli_fetch_assoc($rs);
                $userData=array();
                $userData[]=$row;
                echo '{"state":true,"message":"帳號符合  ... 登入成功 !!","data":' .json_encode($userData). '}';
            }else{      
                echo '{"state" :false,"message":"帳密碼不符 ... 請重新輸入!!"'.mysqli_error($conn).'}';
            }
        }else{
            echo '{"state":true,"message":"查無此帳號  ... 登入失敗  !!"}';            
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