<?php
require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

// && isset($mydata["Address"]) &&  isset($mydata["Usertype"]) &&  isset($mydata["Photo"]) &&  isset($mydata["LineID"]) &&  isset($mydata["Bonuspoint"])
// && $mydata["Address"] != "" && $mydata["Usertype"] != "" && $mydata["Photo"] != "" && $mydata["LineID"] != "" && $mydata["Bonuspoint"] != ""
if (isset($mydata["Username"]) &&  isset($mydata["Pwd"]) && isset($mydata["Sex"]) && isset($mydata["Tel"]) ) {
    if ($mydata["Username"] != "" && $mydata["Pwd"] != "" && $mydata["Sex"] != "" && $mydata["Tel"] != "" ) {
        $p_Username = $mydata["Username"];
        $p_Pwd = $mydata["Pwd"];
        $p_Sex = $mydata["Sex"];
        $p_Tel = $mydata["Tel"];
        // $p_Address = $mydata["Address"];
        // $p_Usertype = $mydata["Usertype"];
        // $p_Photo = $mydata["Photo"];
        // $p_LineID = $mydata["LineID"];
        // $p_Bonuspoint = $mydata["Bonuspoint"];
        $p_Pwd = password_hash( $p_Pwd, PASSWORD_DEFAULT);
        // $servername = "localhost";
        // $username = "owner";
        // $password = "123456";
        // $dbname = "testdb";

        // $conn = mysqli_connect($servername, $username, $password, $dbname);
        // if(!$conn){
        //     die("連線失敗".mysqli_connect_error());
        // }

        $link = create_connect();

        $sql = "INSERT INTO member(Username, Pwd, Sex, Tel) VALUES('$p_Username', '$p_Pwd', '$p_Sex','$p_Tel')";
        // , Address, Usertype, Photo, LineID, Bonuspoint
        // ,'$p_Address','$p_Usertype','$p_Photo','$p_LineID','$p_Bonuspoint'
        $result = execute_sql($link, "myShop", $sql);

        if ($result) {
            echo '{"state": true, "message":"註冊會員成功!"}';
        } else {
            echo '{"state": false, "message":"註冊會員失敗!"'.mysqli_error($link).'}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
} else {
    echo '{"state": false, "message":"缺少規定欄位!"}';
}
