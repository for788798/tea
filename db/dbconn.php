<?php
    function create_connect(){
        /* $link = mysqli_connect("localhost","id19905410_admin","EzJVG<qsA1)EP~LR")  or die("connect error(連線失敗)" . mysqli_connect_error()); */
        $link = mysqli_connect("localhost","owner","123456")  or die("connect error(連線失敗)" . mysqli_connect_error());
        mysqli_query($link,'SET NAMES utf8');
        
        return $link;
    }

    function execute_sql($link , $dbname , $sql){
        mysqli_select_db($link , $dbname) or die("connect database error(連線失敗)" . mysqli_error($link));
        
        $result = mysqli_query($link,$sql);
        return $result;
    }
?>