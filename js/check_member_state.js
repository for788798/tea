//UID憑證登入驗證
//登出按鈕 設定為 #logout_btn
//會員名稱 設定為 #login_member
//信任憑證 UID01、UID02
//setCookie設定cookie檔
//getCookie讀取cookie檔
var cook01 = getCookie("UID01"), cook02 = getCookie("UID02"), cook03 = getCookie("UID03");

$(function(){
    if (cook01 != "" && cook02 != "" && cook03 != "") {
        var dataJson = {};    //宣告陣列物件
        dataJson["uid01"] = cook01;
        dataJson["uid02"] = cook02;
        dataJson["uid03"] = cook03;
        $.ajax({
            type: "POST",
            url: "../CRUD_HW/Member_UID_api.php",
            data: JSON.stringify(dataJson),
            contentType: "appliction/json;chartest=usf-8",   //定義輸出語系,避免亂碼
            dataType: "json",           //定義接收格式
            success: showdata_CheckUidOK,
            error: function () {
                console.log("error..... CRUD_HW/Member_UID_api.php")
            }
        });
    }
});

function showdata_CheckUidOK(data) {
    if (data.state) {
        //顯示 會員名稱
        //隱藏按鈕 (登入,註冊)
        
        console.log(data);

        if (data.data[0].Userstate == "y") {

            $("#login_member").text(data.data[0].Username + "會員你好　　");
            $("#showd").empty();
            $("#username").val(data.data[0].Username);
            $("#password").val("********");

        } else {
            alert("帳號停權中...請連絡負責人處理");
        }
        if (data.data[0].Userstate == "y" && data.data[0].Usertype == 100) {
                    $("#Rootmember").show();
                    $("#Rootmember2").show();
                    $("#Root1").show();
                    $("#Root2").show();
                    $("#Root3").show();
                    $("#Root0").hide();

                }
    } else {
        alert(data.message);
    }
}
//from w3school
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}