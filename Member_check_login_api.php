<?php
// {    
//     "username":"XX",
//     "pwd":"XX"
// }
require_once("conn.php");
$data = file_get_contents("php://input","r");
$jsonData = array();
$jsonData = json_decode($data,true);

if(isset($jsonData["username"]) && isset($jsonData["pwd"])){
    if($jsonData["username"]!="" && $jsonData["pwd"]!=""){
        $username = $jsonData["username"];
        $password = $jsonData["pwd"];
        $sql = "SELECT Username,Pwd ,UserState,Usertype FROM `Member` WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            $password_hash =  $row["Pwd"];
            if(password_verify($password,$password_hash)){
                $uid = substr(substr(md5(uniqid()),3,10),2,6);
                $uid_2 = substr(substr(md5(uniqid()),1,10),2,7);
                $sql = "UPDATE `Member` SET `UID01` = '$uid',`UID02` = '$uid_2' WHERE Username = '$username';"; 
                mysqli_query($conn, $sql);
               
                $sql_2 = "SELECT ID,Username,UserState,Usertype,UID01,UID02 FROM `Member` WHERE Username = '$username'";
                $result_2 = mysqli_query($conn, $sql_2);
                $row_2 = mysqli_fetch_assoc($result_2);

                echo('{"state":true,"message":"登入成功","data":'.json_encode($row_2).'}');
            } 
            else{
                echo('{"state":false,"message":"登入失敗"}');
            }
        }
        else{
            echo('{"state":false,"message":"登入失敗"}');
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


