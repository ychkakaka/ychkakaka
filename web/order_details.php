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


    <div class="center-wrap seat-wrap">
        <div class="seat-tips">
            请于电影开场前10分钟进行检票！
        </div>
        <div class="order-table">
            <table>
                <tbody>
                <tr class="menu">
                    <td class="movie">电影</td>
                    <td class="changci">场次</td>
                    <td class="seat">票数/座位</td>
                    <td class="money">金额小计</td>
                    <td class="phone_tip">二维码</td>
                </tr>
                <tr class="info">
                    <td class="movie_wrap">
                        <img src="<?php echo $film_details[0]["film_picture"] ?>" width="84" height="116" style="float: left">
                        <ul>
                            <li class="movie_name"><?php echo $film_details[0]["film_name"] ?></li>
                            <li>版本：原版 2D</li>
                            <li>片长：<?php echo $film_details[0]["film_length"] ?>分钟</li>
                        </ul>
                    </td>
                    <td class="cinema">
                        <div class="cinema_name"><?php echo $cinema_name[0]["cinema_name"] ?></div>
                        <div class="hall"><?php echo $hall_name[0]["hall_name"] ?></div>
                        <div class="time"><?php echo $hall_name[0]["film_date"]?> <?php echo $hall_name[0]["start_time"]?></div>
                    </td>
                    <td class="seat_detail">
                        <?php
                        $sum =0;
                        for($i=0;$i<5;$i++) {
                            if ($seatIdList[$i] != -1) {
                                $sum++;
                            }
                        }
                        ?>
                        <div class="count"><?php echo $sum ?>张</div>
                        <?php
                        for($i=0;$i<5;$i++){
                            if ($seatIdList[$i] != -1){
                                ?>
                                <div class="sit">
                                <?php
                                $fuhao = "";
                                $pai = intval($seatIdList[$i]/8)+1;
                                $zuo = ($seatIdList[$i]%8)+1;
                                if ($pai<10)
                                    $ling = "0";
                                if ($zuo<10)
                                    $fuhao = "0";
                                echo $ling.$pai."排-".$fuhao.$zuo."座   ";
                            }?>
                            </div>
                        <?php } ?>
                    </td>
                    <td class="money_wrap">
                        <div class="money">
                            <div class="main">￥<?php echo $hall_name[0]["film_price"]*$sum ?>.00</div>
                            <div class="other"></div>
                        </div>
                    </td>
                    <td class="phone_wrap">
                        <?php
                        require_once '../controller/phpqrcode.php';
                        $value = "电影：".$cinema_name[0]["cinema_name"]." 场次：".$hall_name[0]["film_date"] . " " .$hall_name[0]["start_time"] ." 订单号：".$order_number;         //二维码内容
                        $errorCorrectionLevel = 'L';  //容错级别
                        $matrixPointSize = 5;      //生成图片大小
                        //生成二维码图片
                        $filename = 'image/QRcode/'.$order_number.'.png';
                        QRcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);
                        $QR = $filename;        //已经生成的原始二维码图片文件
                        $QR = imagecreatefromstring(file_get_contents($QR));
                        //输出图片
                        imagepng($QR, 'image/QRcode/qrcode.png');
                        imagedestroy($QR);
                        echo '<img src="image/QRcode/qrcode.png">';
                        //调用查看结果
                        /*echo scerweima('https://www.baidu.com');*/
                        $QR_number = "image/QRcode/".$order_number.".png";
                        $order_list = $order->OrderInfo($order_number,$result[0]["user_id"],$hall_seat[0]["film_price"]*$sum,$film_times_id);
                        $order_detail = $order->OrderDetailinfo($order_number,$seatX,$seatY,$hall_name[0]["film_price"]*$sum,$film_times_id,$QR_number);
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!--<div class="center-wrap seat-wrap">
        <div class="seat-left">
            <div class="tips">请于电影开场前10分钟进行检票！<br><br></div>
            <div class="tab date" style="height: auto;">
                <div >
                    电影：<?php /*echo $cinema_name[0]["cinema_name"] */?><br><br>
                    场次: <?php /*echo $hall_name[0]["film_date"]*/?> <?php /*echo $hall_name[0]["start_time"]*/?><br><br>
                    票数/座位:<?php
/*                    $sum =0;
                    for($i=0;$i<5;$i++){
                        if ($seatIdList[$i] != -1){
                            $sum++;
                            $fuhao = "";
                            $pai = intval($seatIdList[$i]/8)+1;
                            $zuo = ($seatIdList[$i]%8)+1;
                            $seatX .= $pai.",";
                            $seatY .= $zuo.",";
                            if ($pai<10)
                                $ling = "0";
                            if ($zuo<10)
                                $fuhao = "0";
                            echo $ling.$pai."排-".$fuhao.$zuo."座   ";
                        }
                    }
                    //订单生成
                    $order_list = $order->OrderInfo($order_number,$result[0]["user_id"],$hall_seat[0]["film_price"]*$sum,$film_times_id);*/?><br><br>
                    金额小计:<?php /*echo $hall_name[0]["film_price"]*$sum */?>元<br><br>
                    接受电子码的电话号码:<?php
/*                    $user_info = $User->checkAUser($user_name);
                    echo $user_info[0]["telephone"];*/?><br><br>
                </div>
            </div>
        </div>
        <div class="seat-right">
            <div id="QR_code">
                <?php
/*                require_once '../controller/phpqrcode.php';
                $value = "电影：".$cinema_name[0]["cinema_name"]." 场次：".$hall_name[0]["film_date"] . " " .$hall_name[0]["start_time"] ." 订单号：".$order_number;         //二维码内容
                $errorCorrectionLevel = 'L';  //容错级别
                $matrixPointSize = 5;      //生成图片大小
                //生成二维码图片
                $filename = 'image/QRcode/'.$order_number.'.png';
                QRcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);
                $QR = $filename;        //已经生成的原始二维码图片文件
                $QR = imagecreatefromstring(file_get_contents($QR));
                //输出图片
                imagepng($QR, 'image/QRcode/qrcode.png');
                imagedestroy($QR);
                echo '<img src="image/QRcode/qrcode.png">';
                //调用查看结果
                echo scerweima('https://www.baidu.com');
                //$QR_number = "image/QRcode/".$order_number.".png";
                //$order_detail = $order->OrderDetailinfo($order_number,$seatX,$seatY,$hall_name[0]["film_price"]*$sum,$film_times_id,$QR_number);
                */?>
            </div>
        </div>
    </div>-->
</body>
</html>