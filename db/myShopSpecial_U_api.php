<?php
  //header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
  require_once("dbconn.php");
  //接收json 格式 ==> {"Typename":"Hot","Product_ID":"7",''Picon'':"../image/Hot.png"}

  $data = file_get_contents("php://input","r"); 
  //echo $data;

  $Jsondata = array();    //宣告 $Jsondata
  $Jsondata = json_decode($data,true);

  //檢查所有欄位是否有傳遞到位
  if (isset($Jsondata["ID"]) && isset($Jsondata["Typename"]) && isset($Jsondata["Product_ID"]) && isset($Jsondata["Picon"])){

    if ($Jsondata["ID"] != "" && $Jsondata["Typename"] != "" && $Jsondata["Product_ID"] != "" && $Jsondata["Picon"] != ""){

      $pID = $Jsondata["ID"];        
      $pTypename = $Jsondata["Typename"];        
      $pProduct_ID = $Jsondata["Product_ID"];
      $pPicon = $Jsondata["Picon"];

      $conn=create_connect();     //dbconn.php
       
      $sql="Update Special set Typename='".$pTypename."',Product_ID='".$pProduct_ID."',Picon='".$pPicon."' where ID=" . $pID ;
      
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
