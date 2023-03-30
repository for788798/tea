<?php
  //header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
  require_once("dbconn.php");
  //接收json 格式 ==> {"ID":"5","Sort_ID":"11","Pname":"珍珠奶茶","Pdimg":"xxxx","Information":"good drink","Price":"85","DisPrice":"80","Points":"0"}

  $data = file_get_contents("php://input","r"); 
  //echo $data;

  $Jsondata = array();    //宣告 $Jsondata
  $Jsondata = json_decode($data,true);

  //檢查所有欄位是否有傳遞到位
  if (isset($Jsondata["ID"]) && isset($Jsondata["Sort_ID"]) && isset($Jsondata["Pname"]) && isset($Jsondata["Information"]) && isset($Jsondata["Price"]) && isset($Jsondata["DisPrice"]) && isset($Jsondata["Points"])){

      //檢查所有欄位是否有空值存在
      if ($Jsondata["ID"] != "" && $Jsondata["Sort_ID"] != "" && $Jsondata["Pname"] != "" && $Jsondata["Information"] != "" && $Jsondata["Price"] != "" && $Jsondata["DisPrice"] != "" && $Jsondata["Points"] != ""){

          $conn=create_connect();     //dbconn.php
          //↑↑↑↑↑↑↑↑資料庫連線↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑=====↓↓↓↓↓↓↓資料庫連線正常後之作業↓↓↓↓↓↓↓↓↓↓↓↓
          $pID = $Jsondata["ID"];
          $pSort_ID = $Jsondata["Sort_ID"];
          $pPname = $Jsondata["Pname"];
          $pPdimg = $Jsondata["Pdimg"];
          $pInformation = $Jsondata["Information"];
          $pPrice = $Jsondata["Price"];
          $pDisPrice = $Jsondata["DisPrice"];
          $pPoints = $Jsondata["Points"];
        
          $sql="Update Product set Sort_ID='".$pSort_ID."',Pname='".$pPname."',Pdimg='".$pPdimg."',Information='".$pInformation."',Price='".$pPrice."',DisPrice='".$pDisPrice."',Points='".$pPoints."'  where ID=" . $pID ;
        
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