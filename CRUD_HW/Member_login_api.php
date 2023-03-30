
<?php
require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode("$data ", true);


if (isset($mydata["Username"]) && isset($mydata["Pwd"])) {
    if ($mydata["Username"] != "" && $mydata["Pwd"] != "") {
        $p_username = $mydata["Username"];
        $p_Pwd = $mydata["Pwd"];


        $link = create_connect();
        //找出相同帳號的資料
        $sql = "SELECT Username,Pwd FROM member WHERE Username = '$p_username' ";
        $result = execute_sql($link, "myShop", $sql);
        if (mysqli_num_rows($result) == 1) {
            //該筆帳號存在,使用password_verify()確認密碼是否正確
            //password_verify(原密碼, 加密密碼)
            $row = mysqli_fetch_assoc($result);
            $Pwd_hash = $row["Pwd"];
            if (password_verify($p_Pwd, $Pwd_hash)) {
                //密碼驗證成功
                //產生UID並更新資料庫
                $uid01 = substr(md5(hash('sha256', rand())), 1, 64);
                $uid02 = substr(md5(hash('sha256', date("YmdHis"))), 1, 64);
                $uid03 = substr(md5(hash('sha256', uniqid())), 1, 64);
                $sql = "UPDATE member SET  UID01 = '$uid01', UID02 = '$uid02', UID03 = '$uid03' WHERE Username = '$p_username'";
                execute_sql($link, "myShop", $sql);
                //撈取密碼以外的資訊
                $sql = "SELECT ID, Username , Userstate, UID01, UID02, UID03 FROM member WHERE Username = '$p_username' ";
                $result = execute_sql($link, "myShop", $sql);
                $row = mysqli_fetch_assoc($result);
                $userData = array();
                $userData[] = $row;
                echo '{"state":true,"message":"會員登入成功!","data":' . json_encode($userData) . '}';
            } else {
                echo '{"state":false,"message":"密碼錯誤!' . mysqli_error($link) . '"}';
            }
        } else {
            //該筆帳號不存在
            echo '{"state":false,"message":"帳號錯誤!' . mysqli_error($link) . '"}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
} else {
    echo '{"state": false, "message":"缺少規定欄位!"}';
}
