<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");
//接收json 格式 ==> {"ID":"1" , "Username":"AAAAAA" , "Pwd":"1qaz@WSX" , "Sex":"男", "Tel":"0912345678", "Address":"xxxxxxxxxxxxxxxxxxxxx", "Usertype":"1", "Photo":"", "LineID":"@123", "Bonuspoint":"12"}

$data = file_get_contents("php://input","r"); 
//echo $data;

$Jsondata = array();    //宣告 $Jsondata
$Jsondata = json_decode($data,true);

//檢查所有欄位是否有傳遞到位
if (isset($Jsondata["ID"]) && isset($Jsondata["Username"]) && isset($Jsondata["Pwd"]) && isset($Jsondata["Sex"]) && isset($Jsondata["Tel"]) && isset($Jsondata["Address"]) && isset($Jsondata["Usertype"]) && isset($Jsondata["Photo"]) && isset($Jsondata["LineID"]) && isset($Jsondata["BonuspointD"])){

  if ($Jsondata["ID"] != "" && $Jsondata["Username"] != "" && $Jsondata["Pwd"] != "" && $Jsondata["Sex"] != "" && $Jsondata["Tel"] != "" && $Jsondata["Address"] != "" && $Jsondata["Usertype"] != "" && $Jsondata["Photo"] != "" && $Jsondata["LineID"] != "" && $Jsondata["BonuspointD"] != ""){

        $conn=create_connect();     //dbconn.php
        //↑↑↑↑↑↑↑↑資料庫連線↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑=====↓↓↓↓↓↓↓資料庫連線正常後之作業↓↓↓↓↓↓↓↓↓↓↓↓
        $pID = $Jsondata["ID"];
        $pUsernam = $Jsondata["Username"];
        $pPwd = $Jsondata["Pwd"];
        $pSex = $Jsondata["Sex"];
        $pTel = $Jsondata["Tel"];
        $pAddress = $Jsondata["Address"];
        $pUsertype = $Jsondata["Usertype"];
        $pPhoto = $Jsondata["Photo"];
        $pLineID = $Jsondata["LineID"];
        $pBonuspoint = $Jsondata["Bonuspoint"];
      
        $sql="Update Member set Username='".$pUsername."',Pwd='".$Pwd."',Sex='".$pSex."',Tel='".$pTel."',Address='".$pAddress."',Usertype='".$pUsertype."',Photo='".$pPhoto."',LineID='".$pLineID."',Bonuspoint='".$pBonuspoint."' where ID=" . $pID ;
      
        if (execute_sql($conn,"myShop",$sql)){    //dbconn.php
            if (mysqli_affected_rows($conn)>0 ){
              //echo "資料更新成功 ... 請重新輸入 !!";
              echo '{"state":true,"message":"資料更新成功 !!"}';
            }else{
              echo '{"state":true,"message":"無任何資料更新 !!"}';
            }  
        }else{  
            //echo "資料更新失敗 ... 請重新輸入 !!";
            echo '{"state" :false,"message":"資料更新失敗 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';
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