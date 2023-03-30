<?php
// header("Access-Control-Allow-Origin: *");
// $servername = "localhost";
// $username = "owner";
// $password = "123456";
// $dbname = "testdb";


require_once("dbtools.php");
// $conn = mysqli_connect($servername, $username, $password, $dbname);
$link = create_connect();
// if(!$conn){
//     die("連線失敗".mysqli_connect_error());
// }
$sql = "SELECT ID, Username, Sex, Tel, Address, Usertype, Photo, Bonuspoint, LineID, Created_at FROM member ORDER BY ID DESC";
$result = execute_sql($link, "myShop", $sql);
if (mysqli_num_rows($result) > 0) {
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state": true, "message":"讀取資料成功!", "data":' . json_encode($mydata) . '}';
    mysqli_close($link);
} else {
    echo '{"state": false, "message":"讀取資料失敗或查無資料!"}';
}
    // require_once("dbtools.php");

    // $servername = "localhost";
    // $username = "drink";
    // $password = "123456";
    // $dbname = "drink";

    // $conn = mysqli_connect($servername, $username, $password, $dbname);

    // if(!$conn){
    //     die("連線失敗".mysqli_connect_error());
    // }

    // $sql = "SELECT ID, Username, Sex, Tel, Address, Usertype, Photo, Bonuspoint, LineID, Created_at FROM member ORDER BY ID DESC";
    // $result = mysqli_query($conn, $sql);
    // if(mysqli_num_rows($result) > 0){
    //     $mydata = array();
    //     while($row = mysqli_fetch_assoc($result)){
    //         $mydata[] = $row;
    //     }
    //     echo '{"state": true, "message":"讀取資料成功!", "data":'.json_encode($mydata).'}';
    // }else{
    //     echo '{"state": false, "message":"讀取資料失敗或查無資料!"}';
    // }
    // mysqli_close($conn);
?>

