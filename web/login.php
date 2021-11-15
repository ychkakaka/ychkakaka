<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>登录</title>
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
        function checkForm(form) {
            if (form.username.value == "") {
                alert("用户名不能为空!");
                form.username.focus();
                return false;
            }
            if (form.pwd.value == "") {
                alert("密码不能为空!");
                form.pwd.focus();
                return false;
            }
            return true
        }
    </script>
</head>
<body>
    <div class="box">
        <h2>登录</h2>
        <form action="../controller/login.php" method="post" onsubmit="return checkForm(this)">
            <div class="inputBox">
                <input type="text" name="username" id="username" required="">
                <label>用户名</label>
            </div>
            <div class="inputBox">
                <input type="password" name="pwd" id="pwd" required="">
                <label>密码</label>
            </div>
            <div class="inputBox">
                <input type="text" name="yzm" id="yzm" required="">
                <label>验证码</label>
            </div>
            <div>
                <img src="../controller/idcode.php" onClick="this.src=this.src+'?'" alt="" height="40" width="100">
            </div>
            <input type="submit" name="subl" id="subl" value="登录" formnovalidate>
            <a href="reg.php"><font size="2">没有账号，点此免费注册</font></a>
            <div class="inputBox" align="right">
                <br><a href="message_login.php" style="color: white"><font size="3">手机短信登录</font></a>
            </div>
        </form>
</div>
</body>
</html>