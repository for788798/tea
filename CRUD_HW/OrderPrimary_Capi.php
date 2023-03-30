<?php
require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["Orderno"]) &&  isset($mydata["CountC"]) && isset($mydata["Total"]) && isset($mydata["Memo"]) && isset($mydata["Chkorder"]) && isset($mydata["userID"])) {
    if ($mydata["Orderno"] != "" && $mydata["CountC"] != "" && $mydata["Total"] != "" && $mydata["Memo"] != "" && $mydata["Chkorder"] != "" && $mydata["userID"] != "") {
        $p_Orderno = $mydata["Orderno"];
        $p_CountC = $mydata["CountC"];
        $p_Total = $mydata["Total"];
        $p_Memo = $mydata["Memo"];
        $p_Chkorder = $mydata["Chkorder"];
        $P_userID = $mydata["userID"];

        // $servername = "localhost";
        // $username = "owner";
        // $password = "123456";
        // $dbname = "testdb";

        // $conn = mysqli_connect($servername, $username, $password, $dbname);
        // if(!$conn){
        //     die("連線失敗".mysqli_connect_error());
        // }

        $link = create_connect();

        $sql = "INSERT INTO orderprimary(Orderno, CountC, Total, Memo, Chkorder) VALUES('$p_Orderno', '$p_CountC', '$p_Total','$p_Memo','$p_Chkorder')";

        $result = execute_sql($link, "myShop", $sql);

        if ($result) {
            echo '{"state":true,"message":"新增訂單成功 !!"}';
        } else {
            echo '{"state": false, "message":"新增訂單失敗 !!"' . mysqli_error($link) . '}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位傳遞空值!"}';
    }
} else {
    echo '{"state": false, "message":"欄位傳遞資料失敗!"}';
}
?>