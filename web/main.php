<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/main.css">
    <script language="JavaScript" type="text/javascript">
        function display1(){
            var div_n = document.getElementById("div_now");
            var div_f = document.getElementById("div_future");
            div_n.style.display = "block";
            div_f.style.display = "none";
            document.getElementById("now").className = 'current';
            document.getElementById("future").className = ''
        }
        function display2(){
            var div_n = document.getElementById("div_now");
            var div_f = document.getElementById("div_future");
            div_n.style.display = "none";
            div_f.style.display = "block";
            document.getElementById("now").className = '';
            document.getElementById("future").className = 'current';
        }
    </script>

</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/FilmService.php");
        session_start();
        $User = new UserService();
        $result = $User->selectAUser($_SESSION["user_name"],$_SESSION["pwd"]);
        $film = new FilmService();
    ?>
    <div class="head-box" align="center">
        <?php if ($_SESSION["loggedIn"]) {?>
        <div class="dropdown">
            <span>欢迎<a href="user_center.php"><?php echo $_SESSION["user_name"]?></a></span>
            <div class="head-dropdown-content">
                <div align="right">
                    <span><a href="user_center.php"><font size="2px">账号管理</font></a></span>
                    <span><font color="#ddd"> | </font></span>
                    <span><a href="../controller/logout.php?name=quit"><font size="2px">退出</font></a></span>
                </div>
                <div class="dropdown-user" align="left">
                    <div>
                        <font size="2px">用户等级：<?php echo $result[0]["user_rank"]?></font>
                    </div>
                    <div>
                        <font size="2px">用户经验：<?php echo $result[0]["user_exp"]?></font>
                    </div>
                </div>
            </div>
        </div>
        <div class="cus_car"><a href="cus_car.php">购物车</a></div>
        <?php } else { ?>
        <div class="head-box-child">
            <a href="login.php" target="_top" id="login"><font color="#f22e00">亲，请登录</font></a>
            <a href="reg.php" id="reg">免费注册</a>
        </div>
        <div class="cus_car"><a href="login.php">购物车</a></div>
        <?php } ?>
    </div>
    <div class="head-menu">
        <div class="head-content-wrap">
            <div class="head_wrap">
                <a target="_top" href="main.php"><img src="image/xiaotao.png"></a>
            </div>
            <div class="hz">
                <span><font size="5px"><b>杭州</b></font><span>
            </div>
            <div class="menu">
                <ul>
                    <li class="head-index"><a href="main.php">首页</a></li>
                    <li class="head-show"><a href="showList.php">影片</a></li>
                    <li class="head-cinema"><a href="cinema.php">影院</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <img src="image/lunbo.jpg" width="100%">
    </div>
    <div class="list">
        <div class="cinema-js">
            <a href="#" class="showing current" id="now" onclick="display1()">正在热映(<?php echo count($result_film = $film->selectFilms_status(1))?>)</a>
            <a href="#" id="future" onclick="display2()">即将上映(<?php echo count($result_film = $film->selectFilms_status(0))?>)</a>
            <a href="showList.php" style="float: right;color: #eb002a;font-size: 12px">查看全部&nbsp;></a>
        </div>
        <div class="tab-content">
            <div id="div_now" class="tab-movie-list">
                <?php for ($sum = 0;$sum < 5;$sum++){
                    $film_result = $film->selectFilms_status(1);
                ?>
                <div class="movie-wrap">
                    <a href="film_details.php?film_id=<?php echo $film_result[$sum]["film_id"] ?>" class="movie-card">
                        <div>
                            <img src="<?php echo $film_result[$sum]["film_picture"] ?>" height="224px" width="160px">
                        </div>
                    </a>
                    <a href="film_details.php?film_id=<?php echo $film_result[$sum]["film_id"] ?>" class="buy-film">选座购票</a>
                </div>
                <?php } ?>
            </div>
            <div id="div_future" class="tab-movie-list" style="display:none" >
                <?php for ($sum = 0;$sum < 5;$sum++){
                    $film_result = $film->selectFilms_status(0);
                    ?>
                    <div class="movie-wrap">
                        <a href="film_details.php?film_id=<?php echo $film_result[$sum]["film_id"] ?>" class="movie-card">
                            <div>
                                <img src="<?php echo $film_result[$sum]["film_picture"] ?>" height="224px" width="160px">
                            </div>
                        </a>
                        <a href="film_details.php?film_id=<?php echo $film_result[$sum]["film_id"] ?>" class="film-start">上映时间<?php echo $film_result[$sum]["start_time"]?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="process"></div>
</body>
</html>