<?php

require_once("../CRUD_HW/dbtools.php");
// $conn = mysqli_connect($servername, $username, $password, $dbname);
$link = create_connect();
// if(!$conn){
//     die("連線失敗".mysqli_connect_error());
// }
$sql = "SELECT SUM(Money) AS Money FROM member_buy";
$result = execute_sql($link, "myshop", $sql);
if (mysqli_num_rows($result) > 0) {
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state": true, "message":"銷售金額統計成功!", "data":' . json_encode($mydata) . '}';
    mysqli_close($link);
} else {
    echo '{"state": false, "message":"銷售金額為0"}';
}
