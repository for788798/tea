
<?php
//{"uid01":"XXXX,"uid02":"XXXX"}
/*
{"state":true,"message":"登入狀態確認成功!","data":"該筆會員相關資料"}
{"state":false,"message":"登入狀態確認失敗!錯誤代碼或相關訊息"}
{"state":false,"message":"欄位不得為空白"}
{"state":false,"message":"缺少規定欄位"}
*/

require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode("$data ", true);


if (isset($mydata["uid01"]) && isset($mydata["uid02"]) && isset($mydata["uid03"])) {
    if ($mydata["uid01"] != "" && $mydata["uid02"] != "" && $mydata["uid03"] != "") {
        $p_uid01 = $mydata["uid01"];
        $p_uid02 = $mydata["uid02"];
        $p_uid03 = $mydata["uid03"];
        $link = create_connect();

        $sql = "SELECT ID, Username, Sex, Tel, Address, Usertype, Photo, LineID, Bonuspoint, Userstate , Created_at FROM member WHERE UID01 = '$p_uid01' AND UID02 = '$p_uid02' AND UID03 = '$p_uid03' ";
        $result = execute_sql($link, "myShop", $sql);
        if (mysqli_num_rows($result) == 1) {
            //UID合法
            $userData = array();
            $row =  mysqli_fetch_assoc($result);
            $userData[] = $row;
            echo '{"state":true,"message":"登入狀態確認成功!","data":' . json_encode($userData) . '}';
        } else {
            //UID非法
            echo '{"state":false,"message":"登入狀態確認失敗!' . mysqli_error($link) . '"}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
} else {
    echo '{"state": false, "message":"缺少規定欄位!"}';
}
