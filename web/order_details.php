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

        //????????????????????????
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
                <span>??????<a href="user_center.php"><?php echo $_SESSION["user_name"]?></a></span>
                <div class="head-dropdown-content">
                    <div align="right">
                        <span><a href="user_center.php"><font size="2px">????????????</font></a></span>
                        <span><font color="#ddd"> | </font></span>
                        <span><a href="../controller/logout.php?name=quit"><font size="2px">??????</font></a></span>
                    </div>
                    <div class="dropdown-user" align="left">
                        <div>
                            <font size="2px">???????????????<?php echo $result[0]["user_rank"]?></font>
                        </div>
                        <div>
                            <font size="2px">???????????????<?php echo $result[0]["user_exp"]?></font>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cus_car"><a href="cus_car.php">?????????</a></div>
        <?php } else { ?>
            <div class="head-box-child">
                <a href="login.php" target="_top" id="login"><font color="#f22e00">???????????????</font></a>
                <a href="reg.php" id="reg">????????????</a>
            </div>
            <div class="cus_car"><a href="login.php">?????????</a></div>
        <?php } ?>
    </div>
    <div class="head-menu-c">
        <div class="head-content-wrap">
            <div class="head_wrap">
                <a target="_top" href="main.php"><img src="https://gitee.com/yu-chenghang/ych/raw/master/img/20210528220759.png"></a>
            </div>
            <div class="hz">
                <span><font size="5px"><b>??????</b></font><span>
            </div>
            <div class="menu-c">
                <ul>
                    <li class="head-index"><a href="main.php">??????</a></li>
                    <li class="head-show"><a href="showList.php">??????</a></li>
                    <li class="head-cinema"><a href="cinema.php">??????</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="center-wrap seat-wrap">
        <div class="seat-tips">
            ?????????????????????10?????????????????????
        </div>
        <div class="order-table">
            <table>
                <tbody>
                <tr class="menu">
                    <td class="movie">??????</td>
                    <td class="changci">??????</td>
                    <td class="seat">??????/??????</td>
                    <td class="money">????????????</td>
                    <td class="phone_tip">?????????</td>
                </tr>
                <tr class="info">
                    <td class="movie_wrap">
                        <img src="<?php echo $film_details[0]["film_picture"] ?>" width="84" height="116" style="float: left">
                        <ul>
                            <li class="movie_name"><?php echo $film_details[0]["film_name"] ?></li>
                            <li>??????????????? 2D</li>
                            <li>?????????<?php echo $film_details[0]["film_length"] ?>??????</li>
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
                        <div class="count"><?php echo $sum ?>???</div>
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
                                echo $ling.$pai."???-".$fuhao.$zuo."???   ";
                            }?>
                            </div>
                        <?php } ?>
                    </td>
                    <td class="money_wrap">
                        <div class="money">
                            <div class="main">???<?php echo $hall_name[0]["film_price"]*$sum ?>.00</div>
                            <div class="other"></div>
                        </div>
                    </td>
                    <td class="phone_wrap">
                        <?php
                        require_once '../controller/phpqrcode.php';
                        $value = "?????????".$cinema_name[0]["cinema_name"]." ?????????".$hall_name[0]["film_date"] . " " .$hall_name[0]["start_time"] ." ????????????".$order_number;         //???????????????
                        $errorCorrectionLevel = 'L';  //????????????
                        $matrixPointSize = 5;      //??????????????????
                        //?????????????????????
                        $filename = 'image/QRcode/'.$order_number.'.png';
                        QRcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);
                        $QR = $filename;        //??????????????????????????????????????????
                        $QR = imagecreatefromstring(file_get_contents($QR));
                        //????????????
                        imagepng($QR, 'image/QRcode/qrcode.png');
                        imagedestroy($QR);
                        echo '<img src="image/QRcode/qrcode.png">';
                        //??????????????????
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
            <div class="tips">?????????????????????10?????????????????????<br><br></div>
            <div class="tab date" style="height: auto;">
                <div >
                    ?????????<?php /*echo $cinema_name[0]["cinema_name"] */?><br><br>
                    ??????: <?php /*echo $hall_name[0]["film_date"]*/?> <?php /*echo $hall_name[0]["start_time"]*/?><br><br>
                    ??????/??????:<?php
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
                            echo $ling.$pai."???-".$fuhao.$zuo."???   ";
                        }
                    }
                    //????????????
                    $order_list = $order->OrderInfo($order_number,$result[0]["user_id"],$hall_seat[0]["film_price"]*$sum,$film_times_id);*/?><br><br>
                    ????????????:<?php /*echo $hall_name[0]["film_price"]*$sum */?>???<br><br>
                    ??????????????????????????????:<?php
/*                    $user_info = $User->checkAUser($user_name);
                    echo $user_info[0]["telephone"];*/?><br><br>
                </div>
            </div>
        </div>
        <div class="seat-right">
            <div id="QR_code">
                <?php
/*                require_once '../controller/phpqrcode.php';
                $value = "?????????".$cinema_name[0]["cinema_name"]." ?????????".$hall_name[0]["film_date"] . " " .$hall_name[0]["start_time"] ." ????????????".$order_number;         //???????????????
                $errorCorrectionLevel = 'L';  //????????????
                $matrixPointSize = 5;      //??????????????????
                //?????????????????????
                $filename = 'image/QRcode/'.$order_number.'.png';
                QRcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);
                $QR = $filename;        //??????????????????????????????????????????
                $QR = imagecreatefromstring(file_get_contents($QR));
                //????????????
                imagepng($QR, 'image/QRcode/qrcode.png');
                imagedestroy($QR);
                echo '<img src="image/QRcode/qrcode.png">';
                //??????????????????
                echo scerweima('https://www.baidu.com');
                //$QR_number = "image/QRcode/".$order_number.".png";
                //$order_detail = $order->OrderDetailinfo($order_number,$seatX,$seatY,$hall_name[0]["film_price"]*$sum,$film_times_id,$QR_number);
                */?>
            </div>
        </div>
    </div>-->
</body>
</html>