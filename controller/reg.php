<?php
    include_once ("../service/UserService.php");
    session_start();
    if (isset($_POST["reg"])){
        $userid = $_POST["userid"];
        $username = $_POST["username"];
        $telephone = $_POST["telephone"];
        $sex = $_POST["sex"];
        $pwd = $_POST["pwd"];
        $yzm = $_POST["yzm"];
        if ($yzm == $_SESSION["vCode"]){
            $user = new UserService();
            $result2 = $user->checkAUser($username);
            $result3 = $user->checkPhone($telephone);
            if (count($result2) == 0){
                if (count($result3) == 0){
                    $result1 = $user->addAUser($userid,$username,$telephone,$sex,$pwd);
                    $_SESSION["username"] = ["username"=>$username];
                    echo "<script type='text/javascript'>alert('注册成功');location='javascript:history.back()';</script>";
                }
                else{
                    echo "<script type='text/javascript'>alert('电话号码已存在');location='javascript:history.back()';</script>";
                }
            }
            else {
                echo "<script type='text/javascript'>alert('用户名已存在');location='javascript:history.back()';</script>";
            }
        }
        else {
            echo "<script type='text/javascript'>alert('验证码错误');location='javascript:history.back()';</script>";
        }
    }

