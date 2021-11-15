<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/cinema_details.css">
    <script type="text/javascript">
        $(document).ready(function () {

        }
    </script>
</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/CinemaService.php");
        include_once ("../service/FilmService.php");
        session_start();
        $User = new UserService();
        $result = $User->selectAUser($_SESSION["user_name"],$_SESSION["pwd"]);
        $cinema = new CinemaService();
        $cinema_id = $_GET["cinema_id"];
        $film = new FilmService();
        $film_list = $film->select_Filmname();
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
    <div class="head-menu-c">
        <div class="head-content-wrap">
            <div class="head_wrap">
                <a target="_top" href="main.php"><img src="https://gitee.com/yu-chenghang/ych/raw/master/img/20210528220759.png"></a>
            </div>
            <div class="hz">
                        <span><font size="5px"><b>杭州</b></font><span>
            </div>
            <div class="menu-c">
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
            $cinema_id_list = $cinema->select_Cinemadetailid($cinema_id);
        ?>
        <div class="detail-cont">
            <div class="center-detail-wrap">
                <h3 class="cont-title">
                    <?php echo $cinema_id_list[0]["cinema_name"]?>
                    <em class="score"><?php echo $cinema_id_list[0]["cinema_grade"] ?></em>
                </h3>
                <div class="cont-pic">
                    <img src="<?php echo $cinema_id_list[0]["image"]?>" width="100%" height="100%" alt="<?php echo $cinema_id_list[0]["cinema_name"]?>">
                </div>
                <ul class="cont-info">
                    <li>详细地址：<?php echo $cinema_id_list[0]["cinema_address"]?></li>
                    <li>联系电话：<?php echo $cinema_id_list[0]["telephone"]?></li>
                </ul>
            </div>
        </div>
    </div>



    <div class="title_wrap">
        <div class="center-wrap">
            <h3>选座购票</h3>
        </div>
    </div>
    <div class="schedule-wrap">
        <div class="filter-wrap">
            <div class="center-wrap">
                <ul class="filter-select">
                    <!--<li>
                        <label>选择区域</label>
                        <div class="select-tags">
                            <a class="current" href="#">全部区域</a>
                        </div>
                    </li>-->
                    <li>
                        <label>选择电影</label>
                        <div class="select-tags">
                            <?php
                                for ($sum = 0;$sum < count($film_list);$sum++) {
                            ?>
                            <a class="current" href="choose_times.php?film_id=<?php echo $film_list[$sum]["film_id"] ?>&cinema_id=<?php echo $cinema_id?>"><?php echo $film_list[$sum]["film_name"] ?></a>
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