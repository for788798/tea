<?php
require_once("conn.php");
$sql = "SELECT * FROM Product ORDER BY ID ;";

mysqli_query($conn,'SET NAMES utf8');

if(!mysqli_query($conn,$sql)){
    echo($sql.mysqli_error($conn));
}

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){
    $mydata = array();
    while($row = mysqli_fetch_assoc($result)){
        $mydata[] = $row; 
    }

    echo('{"state":true,"message":"讀取成功","data":'.json_encode($mydata).'}');

}
else{
    echo('{"state":false,"message":"沒有資料"}');
}

mysqli_close($conn);

 
?>