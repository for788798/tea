<?php

require_once("../CRUD_HW/dbtools.php");
// $conn = mysqli_connect($servername, $username, $password, $dbname);
$link = create_connect();
// if(!$conn){
//     die("連線失敗".mysqli_connect_error());
// }
$sql = "SELECT SUM(Pnum) AS Pnum, Pname FROM ordersub GROUP BY Pname";
$result = execute_sql($link, "myShop", $sql);
if (mysqli_num_rows($result) > 0) {
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state": true, "message":"販售總數統計成功!", "data":' . json_encode($mydata) . '}';
    mysqli_close($link);
} else {
    echo '{"state": false, "message":"販售總數統計失敗"}';
}
