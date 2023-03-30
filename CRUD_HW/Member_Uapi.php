<?php
require_once("dbtools.php");
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode("$data ", true);
if (isset($mydata["ID"])  && isset($mydata["Username"])  && isset($mydata["Sex"]) && isset($mydata["Tel"]) && isset($mydata["Address"]) &&  isset($mydata["Usertype"]) &&  isset($mydata["Photo"]) &&  isset($mydata["LineID"]) &&  isset($mydata["Bonuspoint"])) {
    if ($mydata["ID"] != ""  && $mydata["Username"] != ""  && $mydata["Sex"] != "" && $mydata["Tel"] != "" && $mydata["Address"] != "" && $mydata["Usertype"] != "" && $mydata["Photo"] != "" && $mydata["LineID"] != "" && $mydata["Bonuspoint"] != "") {
        $p_ID = $mydata["ID"];
        $p_Username = $mydata["Username"];
        $p_Sex = $mydata["Sex"];
        $p_Tel = $mydata["Tel"];
        $p_Address = $mydata["Address"];
        $p_Usertype = $mydata["Usertype"];
        $p_Photo = $mydata["Photo"];
        $p_LineID = $mydata["LineID"];
        $p_Bonuspoint = $mydata["Bonuspoint"];
        $link = create_connect();

        $sql = "UPDATE  member SET Username ='$p_Username',Sex ='$p_Sex',Tel ='$p_Tel',Address ='$p_Address',Usertype ='$p_Usertype',Photo ='$p_Photo',LineID ='$p_LineID',Bonuspoint ='$p_Bonuspoint' WHERE ID = '$p_ID'";
        $result = execute_sql($link, "myShop", $sql);
        if ($result) {
            echo '{"state": true, "message":"更新會員成功!"}';
        } else {
            echo '{"state": false, "message":"更新會員失敗!"' . mysqli_error($link) . '}';
        }
        mysqli_close($link);
    } else {
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
} else {
    echo '{"state": false, "message":"缺少規定欄位!"}';
}
