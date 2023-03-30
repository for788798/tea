<?php
  //接收json 格式 ==> {"ID":"2"}
  $data = file_get_contents("php://input","r");       //取得由外部傳入的參數

  $Jsondata = array();    //宣告 json 陣列 => $Jsondata
  $Jsondata = json_decode($data,true);


  if (isset($Jsondata["ID"])){    //檢查所有欄位是否有傳遞到位

    if ($Jsondata["ID"] != ""){      //檢查所有欄位是否有空值存在

      $servername="localhost";
      $username="owner";
      $password="123456";
      $dbname="testdb";
      
      $conn=mysqli_connect($servername,$username,$password,$dbname);
      
      if (!$conn) die("連線失敗 ==>" . mysqli_connect_error());
      
      //↑↑↑↑↑↑↑↑資料庫連線↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑=====↓↓↓↓↓↓↓資料庫連線正常後之作業↓↓↓↓↓↓↓↓↓↓↓↓

      $pID=$Jsondata["ID"];
      
      $sql="Delete from food01 where ID=" . $pID ;
      
      if (mysqli_query($conn,$sql)){  
        if (mysqli_affected_rows($conn)>0 ){
          //echo "資料刪除成功 ... 請重新輸入 !!";
          echo '{"state":true,"message":"資料刪除成功 !!"}';
        }else{
          echo '{"state":true,"message":"無資料可刪除 !!"}';
        }  
      }else{  
        //echo "資料刪除失敗 ... 請重新輸入 !!";
        echo '{"state" :false,"message":"資料刪除失敗 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';
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


