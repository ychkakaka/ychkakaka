<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>注册</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            /*background: url("https://gitee.com/yu-chenghang/ych/raw/master/img/20210526100411.jpeg");*/
            background-size: 100% auto;
            background-color: #ff3e31;
            background-repeat: no-repeat;
        }

        .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            padding: 40px;
            background: rgba(0, 0, 0, .8);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .5);
            border-radius: 10px;
        }

        .box h2 {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            text-align: center;
        }

        .box .inputBox {
            position: relative;
        }

        .box .inputBox input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            letter-spacing: 1px;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background: transparent;
        }

        .box .inputBox label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            letter-spacing: 1px;
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .box .inputBox input:focus ~ label,
        .box .inputBox input:valid ~ label {
            top: -18px;
            left: 0;
            color: #03a9f4;
            font-size: 12px;
        }

        .box input[type="submit"] {
            background: transparent;

            border: none;
            outline: none;
            color: #fff;
            background: #03a9f4;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        a {
            text-decoration: none;
        }

        a:link,
        a:hover,
        a:active,
        a:visited {
            color: #03a9f4;
        }
    </style>
    <script src="js/jquery3.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

        })
        function checkForm(form) {
            if(form.userid.value == "") {
                alert("账号不能为空!");
                form.userid.focus();
                return false;
            }
            if(form.username.value == "") {
                alert("用户名不能为空!");
                form.username.focus();
                return false;
            }
            if(form.telephone.value == "") {
                alert("手机号不能为空!");
                form.telephone.focus();
                return false;
            }
            var reg = /^1[34578]\d{9}$/;
            if (reg.test(form.telephone.value) == false){
                alert("手机号格式错误！");
                form.telephone.focus();
                return false;
            }
            if (form.sex.value == ""){
                alert("请选择您的性别");
                return false;
            }
            if(form.pwd.value == "") {
                alert("密码不能为空!");
                form.pwd.focus();
                return false;
            }
            if(form.pwd.value.length < 6 ||form.pwd.value.length >16) {
                alert("密码必须为6—16位！");
                form.pwd.focus();
                return false;
            }
            if(form.pwd.value != form.pwd2.value){
                alert("两次密码不一致，请重新输入");
                form.pwd2.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="box">
    <h2>欢迎新用户</h2>
    <form action="../controller/reg.php" method="post" onsubmit="return checkForm(this);">
        <div class="inputBox">
            <input type="text" name="userid" id="userid" required="">
            <label>账号</label>
        </div>
        <div class="inputBox">
            <input type="text" name="username" id="username" required="">
            <label>用户名</label>
        </div>
        <div class="inputBox">
            <input type="text" name="telephone" id="telephone" required="">
            <label>电话</label>
        </div>
        <div class="inputBox">
            <input type="text" name="sex" id="sex" required="" list="sexlist" class="layui-input">
            <datalist id="sexlist">
                <option>男</option>
                <option>女</option>
            </datalist>
            <label>性别</label>
        </div>
        <div class="inputBox">
            <input type="password" name="pwd" id="pwd" required="">
            <label>密码</label>
        </div>
        <div class="inputBox">
            <input type="password" name="pwd2" id="pwd2" required="">
            <label>确认密码</label>
        </div>
        <div class="inputBox">
            <input type="text" name="yzm" id="yzm" required="">
            <label>验证码</label>
        </div>
        <div>
            <img src="../controller/idcode.php" onClick="this.src=this.src+'?'" alt="" height="40" width="100">
        </div>
        <input type="submit" name="reg" id="reg" value="注册" formnovalidate>
        <a href="login.php"><font size="2">已有账号，点此登录</font></a>
    </form>
</div>
</body>
</html>