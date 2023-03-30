<?php
//header("Access-Control-Allow-Origin: *");   //提供給外部跨網使用
require_once("dbconn.php");

$conn=create_connect();     //dbtools.php
$sql="Select * from Member order by ID asc";

//$rs1=mysqli_query($conn,$sql);
$rs=execute_sql($conn,"myShop",$sql);       //dbconn.php

if (mysqli_num_rows($rs) >0){    //判斷select 是否有資料 或是 有正確讀取
    $mydata=array();
    while($row=mysqli_fetch_assoc($rs)){    
      $mydata[]=$row;           //$row本身為一維陣列 , 多筆的 $row 為2維
    }
  
    //echo json_encode($mydata);  //以json格式顯示
    //將 echo json_encode($mydata); 改成用 API 方式 輸出 DATA 給 前端 用陣列格式 json 包起來  
    echo '{"state":true,"message":"Success","data":' . (json_encode($mydata)) .'}';
    //json 格式 ==> {"ID"="1","Username":"XXXXX","Pwd":"1234qwerASDF","Sex":"男","Tel":"1234567890","Address":"XXXXXXXXXXXXXXX","Usertype":"1","Photo":"../image/xx.jpg","LineID":"@AAA","Bonuspoint":"0"} 
}else{
    //echo '{"state":false,"message":"查無資料或讀取資料失敗!!"}';
    echo '{"state" :false,"message":"讀取資料失敗或查無此資料 !! ...err Code:"' . $sql.mysqli_error($conn) . '}';      
}

mysqli_close($conn);        //結束連線
?>