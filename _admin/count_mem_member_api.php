<?php

require_once("../CRUD_HW/dbtools.php");
// $conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = create_connect();
// if(!$conn){
//     die("連線失敗".mysqli_connect_error());
// }
$sql = "SELECT COUNT(*) as Username FROM member";
$result = execute_sql($conn, "myshop", $sql);
if (mysqli_num_rows($result) > 0) {
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state": true, "message":"會員總數統計成功!", "data":' . json_encode($mydata) . '}';
    mysqli_close($conn);
} else {
    echo '{"state": false, "message":"會員人數為0"}';
}
