<?php
    error_reporting(0);
    session_start();
    if ("$_GET[name]" == "quit"){
        unset($_SESSION["user_name"]);//销毁用户名
        unset($_SESSION["loggedIn"]);//销毁昵称
        header("location:../web/main.php");
    }
