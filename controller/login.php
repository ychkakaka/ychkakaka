<?php
    include_once ("../service/UserService.php");
    session_start();
    $user_name = $_POST["username"];//获取登录表单提交过来的数据
    $pwd = $_POST["pwd"];
    $yzm = $_POST['yzm'];
    $_SESSION["loggedIn"] = false;
    $user = new UserService();
    $result = $user->selectAUser($user_name,$pwd);
    if ($yzm == $_SESSION["vCode"]){
        if (isset($_POST["subl"])){
            if (count($result) > 0){
                $result = json_encode($result);
                //如果搜索成功，则保存搜索数据并核对
                session_start();
                $_SESSION["user_name"] = $user_name;
                $_SESSION["pwd"] = $pwd;
                $_SESSION["loggedIn"] = true;
                header("Location:../web/main.php");
            }
            else {
                echo "<script type='text/javascript'>alert('用户名或密码错误');location='javascript:history.back()';</script>";
            }
        }
    }
    else {
        echo "<script type='text/javascript'>alert('验证码错误');location='javascript:history.back()';</script>";
    }


