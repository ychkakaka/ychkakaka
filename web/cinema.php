<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/cinema.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery3.js"></script>
    <?php
        include_once ("../service/CinemaService.php");
        session_start();
        $cinema = new CinemaService();
        $sum = count($result_cinema = $cinema->select_Cinemadetails($_SESSION["cinema_name"]))
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#search-btn").click(function () {
                var cinema_name = $("#search-input").val()
                $("#search-input").val(cinema_name.trim())
                $.ajax({
                    data : {"cinema_name":cinema_name},
                    type : "get",
                    dataType : "json",
                    url : "http://localhost/tpp/controller/cinema_list.php",
                    success : function (data) {
                        if (data[0] == "囧 ~当前城市没有影院信息，你可以去切换城市看看" || data[0] == "" || data[0] == null || cinema_name == null || cinema_name == ""){
                            $("#cinema-detail").empty()
                            var array = "<li>" + "囧 ~当前城市没有影院信息，你可以去切换城市看看" + "</li>"
                            $("#cinema-detail").append(array)
                            return
                        }
                        else {
                            $("#cinema-detail").empty()
                            for (var i = 0;i < <?php echo $sum ?>;i++){
                                var details = "<li><div class="+"detail-right><div class="+"right-score>"+"评分："+"<strong>" + data[i].cinema_grade + "</strong></div><div class="+"right-fav></div><div class="+"right-buy><a href="+"cinema_details.php?cinema_id=" + data[i].cinema_id + " >"+"选座"+"</a></div></div><a href="+"cinema_details.php?cinema_id=" + data[i].cinema_id + " "+" class="+"detail-left><span><img src=" + data[i].image + " alt="+"></span></a><div class="+"detail-middle><div class="+"middle-hd><h4><a href="+"cinema_details.php?cinema_id=" + data[i].cinema_id + ">" + data[i].cinema_name + "</a></h4></div><div class="+"middle-p><div class="+"middle-p-list><i>"+"地址："+"</i><span class="+"limit-address>"+ data[i].cinema_address +"</span></div><div class="+"middle-p-list><i>"+"电话："+"</i>" + data[i].telephone + "</div><div class="+"middle-p-list><i>"+"更多："+"</i><a href="+"#>"+"影院服务"+"</a><a href="+"#>"+" 交通信息"+"</a></div></div></div></li>"
                                $("#cinema-detail").append(details)
                            }
                        }

                    }
                })
            })
        })
    </script>
</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/CinemaService.php");
        session_start();
        $User = new UserService();
        $result = $User->selectAUser($_SESSION["user_name"],$_SESSION["pwd"]);
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



    <div class="movie-path">
        <div class="path">
            <a href="main.php">首页</a> >
            <a href="showList.php">影片</a> > 杭州
        </div>
        <div class="steps">
            <span>3步轻松购票：1.选座购票/买券 <b>→</b> </span>
            <span>2.收电子码 <b>→</b> </span>
            <span>3.影院取票</span>
        </div>
    </div>
    <div class="cinema-wrap">
        <div class="filter-wrap">
            <ul class="filter-select">
                <li>
                    <label>搜索</label>
                    <div class="search-wrap">
                        <input placeholder="请输入影院名称/关键词" class="search-input" id="search-input" type="text" value="">
                        <a href="#" class="search-btn" id="search-btn">
                            <i class="icon-search"></i>
                            查询
                        </a>
                    </div>
                </li>
            </ul>
            <ul class="cinema-detail" id="cinema-detail">
                <?php for ($sum = 0;$sum < count($result_cinema = $cinema->select_Cinemadetails());$sum++){
                    $film_result = $cinema->select_Cinemadetails();
                ?>
                <li>
                    <div class="detail-right">
                        <div class="right-score">
                            评分：
                            <strong><?php echo $result_cinema[$sum]["cinema_grade"] ?></strong>
                        </div>
                        <div class="right-fav"> </div>
                        <div class="right-buy">
                            <a href="cinema_details.php?cinema_id=<?php echo $result_cinema[$sum]["cinema_id"] ?>">选座</a>
                        </div>
                    </div>
                    <a href="cinema_details.php?cinema_id=<?php echo $result_cinema[$sum]["cinema_id"] ?>" class="detail-left">
                        <span>
                            <img src="<?php echo $result_cinema[$sum]["image"] ?>" alt="">
                        </span>
                    </a>
                    <div class="detail-middle">
                        <div class="middle-hd">
                            <h4>
                                <a href="cinema_details.php?cinema_id=<?php echo $result_cinema[$sum]["cinema_id"] ?>"><?php echo $result_cinema[$sum]["cinema_name"] ?></a>
                            </h4>
                        </div>
                        <div class="middle-p">
                            <div class="middle-p-list">
                                <i>地址：</i>
                                <span class="limit-address"><?php echo $result_cinema[$sum]["cinema_address"] ?></span>
                            </div>
                            <div class="middle-p-list">
                                <i>电话：</i>
                                <?php echo $result_cinema[$sum]["telephone"] ?>
                            </div>
                            <div class="middle-p-list">
                                <i>更多：</i>
                                <a href="#">影院服务</a>
                                <a href="#">交通信息</a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>