<?php
require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode("$data", true);
if (isset($mydata["ID"]) &&  isset($mydata["Userstate"])) {
    if ($mydata["ID"] != "" && $mydata["Userstate"] != "") {


        $p_ID = $mydata["ID"];
        $p_Userstate = $mydata["Userstate"];

        $link = create_connect();

        $sql = "UPDATE  member SET Userstate = '$p_Userstate' WHERE ID = '$p_ID'";
        $result = (execute_sql($link, "myShop", $sql) && mysqli_affected_rows($link) == 1);
        if ($result) {
            echo '{"state": true, "message":"會員權限更改成功!"}';
        } else {
            echo '{"state": false, "message":"會員權限更改失敗!"' . mysqli_error($link) . '}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
} else {
    echo '{"state": false, "message":"缺少規定欄位!"}';
}
