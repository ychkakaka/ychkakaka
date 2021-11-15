<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/film_details.css">
    <script language="JavaScript" type="text/javascript">

    </script>
</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/FilmService.php");
        include_once ("../service/CinemaService.php");
        session_start();
        $User = new UserService();
        $result = $User->selectAUser($_SESSION["user_name"],$_SESSION["pwd"]);
        $film = new FilmService();
        $film2 = new FilmService();
        $film_id = $_GET["film_id"];
        $cinema = new CinemaService();
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
    ?>
    <div class="title_wrap">
        <div class="center-wrap">
            <h3>选座购票</h3>
        </div>
    </div>
    <div class="schedule-wrap">
        <div class="filter-wrap">
            <div class="center-wrap">
                <ul class="filter-select">
                    <li>
                        <label>选择区域</label>
                        <div class="select-tags">
                            <a class="current" href="#">全部区域</a>
                        </div>
                    </li>
                    <li>
                        <label>选择影城</label>
                        <div class="select-tags">
                            <?php
                                for ($sum = 0;$sum < count($cinema_list);$sum++) {
                            ?>
                                <a class="current" href="choose_times.php?film_id=<?php echo $film_id ?>&cinema_id=<?php echo $cinema_list[$sum]["cinema_id"]?>"><?php echo $cinema_list[$sum]["cinema_name"]?></a>
                            <?php } ?>
                        </div>
                    </li>
                    <!--<li>
                        <label>选择时间</label>
                        <div class="select-tags">
                            <a class="current" href="#">6月5日（今天）</a>
                        </div>
                    </li>-->
                </ul>
            </div>
        </div>
        <!--<div class="cinema-wrap">
            <h4>杭州中影国际影城（星光大道二期店）</h4>
            地址：滨江区闻涛路与星飞路交叉口，星光大道二期四楼北面靠江边（影城22:00后出入口:闻涛路蓝山咖啡旁天桥下星光大道8、9号电梯上四楼；进入地下停车场后请根据影城标志至商业电梯厅乘坐电梯至四楼
        </div>

        <div class="center-wrap">
            <table class="hall-table">
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
                    <tr>
                        <td class="hall-time">
                            <em class="bold">10:25</em>
                            预计12:02散场
                        </td>
                        <td class="hall-type">原版 2D</td>
                        <td class="hall-name">【二期】全景声15厅</td>
                        <td class="hall-flow">
                            <div class="flowing-wrap">
                                <label> 宽松 </label>
                                <span class="flowing-vol">
                                    <i style="width: 0.0%"></i>
                                </span>
                            </div>
                        </td>
                        <td class="hall-price">
                            <em class="now">38.00</em>
                            <del class="old">38.00</del>
                        </td>
                        <td class="hall-seat">
                            <a class="seat-btn" href="#">
                                选座购票
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>-->
    </div>
</body>
</html>