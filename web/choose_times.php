<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/film_details.css">
    <script language="JavaScript" type="text/javascript">
        function display1(){
            var div_n = document.getElementById("t_1");
            var div_f = document.getElementById("t_2");
            div_n.style.display = "block";
            div_f.style.display = "none";
            document.getElementById("1").className = 'current';
            document.getElementById("2").className = ''
        }
        function display2(){
            var div_n = document.getElementById("t_1");
            var div_f = document.getElementById("t_2");
            div_n.style.display = "none";
            div_f.style.display = "block";
            document.getElementById("1").className = '';
            document.getElementById("2").className = 'current';
        }
    </script>
</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/FilmService.php");
        include_once ("../service/CinemaService.php");
        include_once ("../service/TimesService.php");
        session_start();
        $User = new UserService();
        $result = $User->selectAUser($_SESSION["user_name"],$_SESSION["pwd"]);
        $film = new FilmService();
        $film2 = new FilmService();
        $film_id = $_GET["film_id"];
        $cinema = new CinemaService();
        $cinema_id = $_GET["cinema_id"];
        $film_times = new TimesService();
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
    <div class="head-menus">
        <div class="head-content-wrap">
            <div class="head_wrap">
                <a target="_top" href="main.php"><img src="https://gitee.com/yu-chenghang/ych/raw/master/img/20210528220759.png"></a>
            </div>
            <div class="hz">
                        <span><font size="5px"><b>杭州</b></font><span>
            </div>
            <div class="menus">
                <ul>
                    <li class="head-index"><a href="main.php">首页</a></li>
                    <li class="head-show"><a href="showList.php">影片</a></li>
                    <li class="head-cinema"><a href="cinema.php">影院</a></li>
                </ul>
            </div>
        </div>
    </div>



    <div class="detail-wrap">
        <div class="detail-bg" style="opacity: 0.4;">
            <img src="image/background.jpg">
        </div>
        <?php
        $film_id_list = $film->selectFilms_id($film_id);
        ?>
        <div class="detail-cont">
            <div class="center-detail-wrap">
                <h3 class="cont-title">
                    <?php echo $film_id_list[0]["film_name"]?>
                    <i><?php echo $film_id_list[0]["film_foreign_name"]?></i>
                    <em class="score"><?php echo $film_id_list[0]["film_score"] ?></em>
                </h3>
                <div class="cont-pic">
                    <img src="<?php echo $film_id_list[0]["film_picture"]?>" width="230" height="300" alt="<?php echo $film_id_list[0]["film_name"]?>">
                </div>
                <ul class="cont-info">
                    <li>导演：<?php echo $film_id_list[0]["director"]?></li>
                    <li>主演：<?php echo $film_id_list[0]["actor"]?></li>
                    <li>类型：<?php echo $film_id_list[0]["film_type"]?></li>
                    <li>制片国家/地区：<?php echo $film_id_list[0]["make_film_area"]?></li>
                    <li>片长：<?php echo $film_id_list[0]["film_length"]?>分钟</li>
                    <li class="shrink">
                        剧情介绍：<?php echo $film_id_list[0]["film_introduce"]?>
                    </li>
                </ul>
                <div class="cont-time">上映时间：<?php echo $film_id_list[0]["start_time"]?></div>
                <?php if ($film_id != 7 and $film_id != 10 ) { ?>
                    <div class="cont-view">
                        <?php $film_url_list = $film2->selectFilms_broadcast($film_id,0) ?>
                        <a href="#" class="float-layer-hook">
                            <img src="<?php echo $film_url_list[0]["url"]?>">
                        </a>
                        <?php $film_url_list = $film2->selectFilms_broadcast($film_id,1) ?>
                        <a href="#" class="float-layer-hook">
                            <img src="<?php echo $film_url_list[0]["url"]?>" width="160" height="110">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>



    <?php
    $cinema_list = $cinema->select_Cinemadetails();
    $cinema_details = $cinema->select_Cinemadetailid($cinema_id);
    ?>
    <div class="title_wrap">
        <div class="center-wrap">
            <h3>选择场次</h3>
        </div>
    </div>
    <div class="schedule-wrap">
        <div class="filter-wrap">
            <div class="center-wrap">
                <ul class="filter-select">
                    <li>
                        <label>选择时间</label>
                        <div class="select-tags">
                            <a class="current" href="#" id="1" onclick="display1()">6月9日（今天）</a>
                            <a class="" href="#" id="2" onclick="display2()">6月10日（周三）</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cinema-wrap">
            <h4><?php echo $cinema_details[0]["cinema_name"]?></h4>
            地址：<?php echo $cinema_details[0]["cinema_address"]?>
        </div>

        <div class="center-wrap" id="t_1">
            <table class="hall-table">
                <?php
                    $hall = $film_times->select_filmhall($film_id,$cinema_id,"06-09");
                    if (count($hall) == 0){
                ?>
                    <div class="error_wrap">
                        囧 ~没有找到你需要的排期，你可以查看<a href="cinema.php">其他影院</a>或者<a href="showList.php">其他影片</a>
                    </div>
                    <?php } else { ?>
                    <thead>
                        <tr>
                            <th class="hall-time">放映时间</th>
                            <th class="hall-type">语言版本</th>
                            <th class="hall-name">放映厅</th>
                            <th class="hall-flow">座位情况</th>
                            <th class="hall-price">现价/影院价（元）</th>
                            <th class="hall-buy">选座购票</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php for ($i = 0;$i < count($hall);$i++){ ?>
                            <tr>
                                <td class="hall-time">
                                    <em class="bold"><?php echo $hall[$i]["start_time"]?></em>
                                    预计<?php echo $hall[$i]["end_time"]?>散场
                                </td>
                                <td class="hall-type">原版 2D</td>
                                <td class="hall-name"><?php echo $hall[$i]["hall_name"]?></td>
                                <td class="hall-flow">
                                    <div class="flowing-wrap">
                                        <label> 宽松 </label>
                                        <span class="flowing-vol">
                                            <i style="width: 0.0%"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="hall-price">
                                    <em class="now"><?php echo $hall[$i]["film_price"]?></em>
                                    <del class="old"><?php echo $hall[$i]["film_price"]?></del>
                                </td>
                                <td class="hall-seat">
                                    <?php if ($_SESSION["loggedIn"]) {?>
                                    <a class="seat-btn" id="seat-btn" href="choose_seat.php?film_id=<?php echo $film_id?>&cinema_id=<?php echo $cinema_id?>&film_times_id=<?php echo $hall[$i]["film_times_id"] ?>">
                                        选座购票
                                    </a>
                                    <?php } else {?>
                                        <a class="seat-btn" id="seat-btn" href="login.php">
                                            选座购票
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    <?php } ?>
            </table>
        </div>

        <div class="center-wrap" id="t_2" style="display: none">
            <table class="hall-table">
                <?php
                    $hall2 = $film_times->select_filmhall($film_id,$cinema_id,"06-10");
                    if (count($hall2) == 0){
                ?>
                    <div class="error_wrap">
                        囧 ~没有找到你需要的排期，你可以查看<a href="cinema.php">其他影院</a>或者<a href="showList.php">其他影片</a>
                    </div>
                <?php } else { ?>
                    <thead>
                    <tr>
                        <th class="hall-time">放映时间</th>
                        <th class="hall-type">语言版本</th>
                        <th class="hall-name">放映厅</th>
                        <th class="hall-flow">座位情况</th>
                        <th class="hall-price">现价/影院价（元）</th>
                        <th class="hall-buy">选座购票</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($j = 0;$j < count($hall2);$j++){ ?>
                        <tr>
                            <td class="hall-time">
                                <em class="bold"><?php echo $hall2[$j]["start_time"]?></em>
                                预计<?php echo $hall2[$j]["end_time"]?>散场
                            </td>
                            <td class="hall-type">原版 2D</td>
                            <td class="hall-name"><?php echo $hall2[$j]["hall_name"]?></td>
                            <td class="hall-flow">
                                <div class="flowing-wrap">
                                    <label> 宽松 </label>
                                    <span class="flowing-vol">
                                            <i style="width: 0.0%"></i>
                                        </span>
                                </div>
                            </td>
                            <td class="hall-price">
                                <em class="now"><?php echo $hall2[$j]["film_price"]?></em>
                                <del class="old"><?php echo $hall2[$j]["film_price"]?></del>
                            </td>
                            <td class="hall-seat">
                                <?php if ($_SESSION["loggedIn"]) {?>
                                    <a class="seat-btn" id="seat-btn" href="choose_seat.php?film_id=<?php echo $film_id?>&cinema_id=<?php echo $cinema_id?>&film_times_id=<?php echo $hall2[$j]["film_times_id"] ?>">
                                        选座购票
                                    </a>
                                <?php } else {?>
                                    <a class="seat-btn" id="seat-btn" href="login.php">
                                        选座购票
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>