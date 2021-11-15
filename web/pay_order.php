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
    <script type="text/javascript">
        var maxtime = 10 * 60;
        function CountDown() {
            if (maxtime >= 0) {
                minutes = Math.floor(maxtime / 60);
                seconds = Math.floor(maxtime % 60);
                msg = minutes + "：" + seconds;
                /*$("#shijian").val(msg);*/
                document.all["shijian"].innerHTML = msg;
                if (maxtime == 5 * 60)alert("距离结束仅剩5分钟");
                --maxtime;
            } else{
                clearInterval(timer);
                alert("由于支付时间已过您未支付，本次订单将作废!");//后面把数据恢复到未修改之前
                window.location.href="showList.php";
            }
        }
        timer = setInterval("CountDown()", 1000);

        function success(){
            alert("支付成功！");
        }
    </script>
</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/CinemaService.php");
        include_once ("../service/FilmService.php");
        include_once ("../service/TimesService.php");
        include_once ("../service/OrderService.php");
        session_start();
        $user_name = $_GET["user_name"];
        $cinema_id = $_GET["cinema_id"];
        $film_id = $_GET["film_id"];
        $film_times_id = $_GET["film_times_id"];
        $seatIdList = array($_GET["seat1"],$_GET["seat2"],$_GET["seat3"],$_GET["seat4"],$_GET["seat5"]);

        $User = new UserService();
        $user_result = $User->selectAUser($user_name,$_SESSION["pwd"]);
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
        for ($i=0;$i<5;$i++){
            $film_times_detail = $hall->FilmTimesDetail($film_times_id);
            $hall_seat = $film_times_detail[0]["seat_info"];//现在未改变座位前的位置信息
            $hang_array = explode(",",$hall_seat);//00000000000,00000000000,00000000000
            /*echo "<script>alert('".$seatIdList[$i]."')</script>";*/
            if ($seatIdList[$i] != -1){
                $hang = intval($seatIdList[$i]/8);//第几个组
                $lie = $seatIdList[$i]%8;//第几个数
                $lie_array = str_split($hang_array[$hang]);//把需要用到的数据分割
                /*echo "<script>alert('".$lie_array[$lie]."')</script>";*/
                $lie_array[$lie] = "1";//座位设置为1

                $new_seat_info = "";
                for ($j=0;$j<count($hang_array);$j++){
                    /*$lie_array = str_split($hang_array[$j]);*/
                    if ($hang == $j){
                        $replace = substr_replace($hang_array[$j],1,$lie,1);//替换字符串
                        $new_seat_info = $new_seat_info.$replace;
                        /*for ($k=0;$k<count($lie_array);$k++){
                            if ($lie != $k){
                                if ($lie_array[$k] == 0){
                                    $new_seat_info = $new_seat_info."0";
                                }else if ($lie_array[$k] == 1){
                                    $new_seat_info = $new_seat_info."1";
                                }else{
                                    $new_seat_info = $new_seat_info."2";
                                }
                            }else{
                                $new_seat_info = $new_seat_info."1";
                            }
                        }*/
                    }else{
                        $new_seat_info = $new_seat_info.$hang_array[$j];
                        /*for ($k=0;$k<count($lie_array);$k++){
                            if ($lie_array[$k] == 0){
                                $new_seat_info = $new_seat_info."0";
                            }else if ($lie_array[$k] == 1){
                                $new_seat_info = $new_seat_info."1";
                            }else{
                                $new_seat_info = $new_seat_info."2";
                            }
                        }*/
                    }
                    if ($j+1 != count($hang_array)){
                        $new_seat_info = $new_seat_info.",";
                    }
                }
                /*echo "<script>alert('".$new_seat_info."')</script>";*/
                $result = $order->SeatChosed($film_times_detail[0]["hall_id"],$new_seat_info);
            }
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
                            <font size="2px">用户等级：<?php echo $user_result[0]["user_rank"]?></font>
                        </div>
                        <div>
                            <font size="2px">用户经验：<?php echo $user_result[0]["user_exp"]?></font>
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
            <div class="time_info">
                剩余支付时间
                <span class="J_time">
                    <s class="tips" id="shijian"></s>
                </span>
            </div>
            请您确认您的订单信息，并请在10分钟内完成付款，如超时系统将自动释放已选座位。
        </div>
        <div class="order-table">
            <table>
                <tbody>
                <tr class="menu">
                    <td class="movie">电影</td>
                    <td class="changci">场次</td>
                    <td class="seat">票数/座位</td>
                    <td class="money">金额小计</td>
                    <td class="phone_tip">接收电子码的电话号码</td>
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
                        <div class="phone"><?php echo $user_result[0]["telephone"] ?></div>
                        <div>1.短信可能会被手机软件拦截，请到该软件中查找短信</div>
                        <div>2.若要修改手机号，需要您重新下单</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="price_info">
                <span class="curr_money">
                    实付款：
                    <span class="M-price">￥<?php echo $hall_name[0]["film_price"]*$sum ?>.00</span>
                </span>
            </div>
            <a style="color: white" class="submit-button" href="order_details.php?cinema_id=<?php echo $cinema_id?>&film_times_id=<?php echo $film_times_id?>&film_id=<?php echo $film_id?>&user_name=<?php echo $user_name?>&seat1=<?php echo $seatIdList[0]?>&seat2=<?php echo $seatIdList[1]?>&seat3=<?php echo $seatIdList[2]?>&seat4=<?php echo $seatIdList[3]?>&seat5=<?php echo $seatIdList[4]?>" onclick="success();">确认订单，立即支付</a>
        </div>
    </div>


   </body>
</html>

