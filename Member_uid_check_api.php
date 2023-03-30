<?php
// {    
//     "uid01":"XX",
//     "uid02":"XX"
// }
require_once("conn.php");
$data = file_get_contents("php://input","r");
$jsonData = array();
$jsonData = json_decode($data,true);

if(isset($jsonData["uid01"]) && isset($jsonData["uid02"])){
    if($jsonData["uid01"]!="" && $jsonData["uid02"]!=""){
        $uid01 = $jsonData["uid01"];
        $uid02 = $jsonData["uid02"];
        $sql = "SELECT ID,Username,UserState,Usertype FROM `Member` WHERE UID01 = '$uid01' AND UID02= '$uid02'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            echo('{"state":true,"message":"登入狀態確認成功","data":'.json_encode($row).'}');
        }
        else{
            echo('{"state":false,"message":"登入失敗"'.$sql.mysqli_error($conn).'}');
        }
        mysqli_close($conn);

    }
    else{
        echo('{"state":false,"message":"欄位不得空白"}');
    }
}
else{
    echo('{"state":false,"message":"缺少欄位"}');
}

?>


