<?php
require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["Username"])) {
    if ($mydata["Username"] != "" ) {
        $p_Username = $mydata["Username"];


        // $servername = "localhost";
        // $username = "owner";
        // $password = "123456";
        // $dbname = "testdb";

        // $conn = mysqli_connect($servername, $username, $password, $dbname);
        // if(!$conn){
        //     die("連線失敗".mysqli_connect_error());
        // }

        $link = create_connect();

        $sql = "SELECT Username FROM member WHERE Username = '$p_Username'";

        $result = execute_sql($link, "myShop", $sql);

        if (mysqli_num_rows($result) == 1) {
            echo '{"state": false, "message":"該帳號存在,帳號不可以使用!"}';
        } else {
            echo '{"state": true, "message":"該帳號不存在,帳號可以使用!"}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
} else {
    echo '{"state": false, "message":"缺少規定欄位!"}';
}
