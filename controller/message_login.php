<?php
include_once ("../service/UserService.php");
//开启SESSION
session_start();
header("Content-type:text/html; charset=UTF-8");



//请求数据到短信接口，检查环境是否 开启 curl init。
function Post($curlPost,$url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    $return_str = curl_exec($curl);
    curl_close($curl);
    return $return_str;
}
//将 xml数据转换为数组格式。
function xml_to_array($xml){
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches)){
        $count = count($matches[0]);
        for($i = 0; $i < $count; $i++){
            $subxml= $matches[2][$i];
            $key = $matches[1][$i];
            if(preg_match( $reg, $subxml )){
                $arr[$key] = xml_to_array( $subxml );
            }else{
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}

//random() 函数返回随机整数。
function random($length = 6 , $numeric = 0) {
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
    if($numeric) {
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
    } else {
        $hash = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
    }
    return $hash;
}
    if (isset($_POST["get_code"])){
        //短信接口地址
        $target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
        //获取手机号
        $mobile = $_POST["telephone"];
        //获取验证码
        $send_code = $_POST["yzm"];
        //生成的随机数
        $mobile_code = random(4,1);
        //防用户恶意请求
        if(empty($_SESSION['send_code']) or $send_code!=$_SESSION['send_code']){
            exit('请求超时，请刷新页面后重试');
        }
        $user = new UserService();
        $result = $user->checkPhone($mobile);
        if (count($result) == 0){
            echo "<script type='text/javascript'>alert('手机号未注册，请先进行注册！');location='javascript:history.back()';</script>";
        }
        else {
            $post_data = "account=C82794859&password=ac5ed879487a8c47093f36f9b6859867&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
            //查看用户名 登录用户中心->验证码通知短信>产品总览->API接口信息->APIID
            //查看密码 登录用户中心->验证码通知短信>产品总览->API接口信息->APIKEY
            $gets =  xml_to_array(Post($post_data, $target));
            if($gets['SubmitResult']['code']==2){
                $_SESSION['mobile'] = $mobile;
                $_SESSION['mobile_code'] = $mobile_code;
            }
            echo $gets['SubmitResult']['msg'];
        }
    }

    if (isset($_POST["subl"])){
        $send_code = $_POST["yzm"];
        $mobile = $_POST["telephone"];
        $user = new UserService();
        $result = $user->selectUsername($mobile);
        if ($send_code == $_SESSION["mobile_code"]){
            $result = json_encode($result);
            $_SESSION["user_name"] = ["user_name"=>$result];
            header("Location:../web/main.php");
        }
        else {
            echo "<script type='text/javascript'>alert('手机短信验证码错误！');location='javascript:history.back()';</script>";
        }
    }
