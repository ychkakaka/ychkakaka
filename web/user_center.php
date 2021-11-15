<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/cinema_details.css">
    <link href="css/seat.css" type="text/css" rel="stylesheet" />
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="bootstrap/csspicjs/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/csspicjs/js/menu_x.js"></script>
    <script type="text/javascript" src="bootstrap/jquery3.js"></script>
    <style>
        .footer{
            position:fixed;
            width:100%;
            height:110px;
            bottom:0;
            left:0;
            background-color: #ffbf00;
            color:#0071fe;
            text-align:center;
            font-size:32px;
            line-height:110px;
            letter-spacing:2px;
            z-index:88;
        }
    </style>
</head>
<body>
<?php
include_once ("../service/UserService.php");
include_once ("../service/CinemaService.php");
include_once ("../service/FilmService.php");
include_once ("../service/TimesService.php");
include_once ("../service/OrderService.php");
session_start();
$user_name = $_SESSION["user_name"];
$cinema_id = $_GET["cinema_id"];
$film_id = $_GET["film_id"];
$film_times_id = $_GET["film_times_id"];
$seatIdList = array($_GET["seat1"],$_GET["seat2"],$_GET["seat3"],$_GET["seat4"],$_GET["seat5"]);
$seatX = "";
$seatY = "";

$User = new UserService();
$result = $User->selectAUser($user_name,$_SESSION["pwd"]);
$cinema = new CinemaService();
$cinema_name = $cinema->select_Cinemadetailid($cinema_id);
$film = new FilmService();
$film_list = $film->select_Filmname();
$film_details = $film->selectFilms_id($film_id);
$hall = new TimesService();
$hall_name = $hall->select_hall_name($film_times_id);
$hall_seat = $hall->FilmTimesDetail($film_times_id);
$order = new OrderService();

$flag = true;
/*echo "<script>alert('".$new_seat_info."')</script>";*/

//随机生成的订单号
$chars='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZqwertyuiopasdfghjklzxcvbnm';
$order_number='';
for($i=0;$i<20;$i++) {
    $position=rand()%strlen($chars);
    $order_number.=substr($chars,$position,1);
}
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


</body>
</html>
