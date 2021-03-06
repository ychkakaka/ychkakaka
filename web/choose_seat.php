<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/cinema_details.css">
    <link href="css/seat.css" type="text/css" rel="stylesheet" />
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/csspicjs/js/layer-v3.0.3/layer/mobile/need/layer.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="bootstrap/csspicjs/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/csspicjs/js/layer-v3.0.3/layer/mobile/layer.js"></script>
    <style>
        .seats ul li.bad input{
            display:inline-block;
            width:80px;
            height:80px;
            background-image:url(image/seat_disable.png);
            background-size:100% auto;
            pointer-events: none;
        }
        .seats {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php
        include_once ("../service/UserService.php");
        include_once ("../service/CinemaService.php");
        include_once ("../service/FilmService.php");
        include_once ("../service/TimesService.php");
        session_start();
        $cinema_id = $_GET["cinema_id"];
        $film_id = $_GET["film_id"];
        $film_times_id = $_GET["film_times_id"];

        $User = new UserService();
        $result = $User->selectAUser($_SESSION["user_name"],$_SESSION["pwd"]);
        $cinema = new CinemaService();
        $cinema_name = $cinema->select_Cinemadetailid($cinema_id);
        $film = new FilmService();
        $film_list = $film->select_Filmname();
        $film_details = $film->selectFilms_id($film_id);
        $hall = new TimesService();
        $hall_name = $hall->select_hall_name($film_times_id);
        $hall_seat = $hall->FilmTimesDetail($film_times_id);
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
        <div class="seat-left">
            <div class="clearfix">
                <div class="seatContainer" style="height: 361px;">
                    <div class="seatTitle" style="margin-left: 55px;">
                        <h2> <?php echo $cinema_name[0]["cinema_name"]?>  <?php echo $hall_name[0]["hall_name"] ?>  ??????</h2>
                        <s></s>
                    </div>
                    <div class="seats" id="seats"></div>
                </div>
            </div>
            <div class="seatChooseInfo">
                <ul class="clearfix">
                    <li>
                        <span class="hasSeat"></span>
                        ????????????
                    </li>
                    <li>
                        <span class="sellSeat"></span>
                        ????????????
                    </li>
                    <li>
                        <span class="checkSeat"></span>
                        ???????????????
                    </li>
                </ul>
            </div>
        </div>
        <div class="seat-right">
            <div class="seatMovie clearfix">
                <div class="picBox">
                    <a href="film_details.php?film_id=<?php echo $film_id ?>">
                        <img src="image/001.jpg">
                    </a>
                </div>
                <ul>
                    <li>
                        <h3><?php echo $film_details[0]["film_name"]?></h3>
                    </li>
                    <li>??????????????? 2D</li>
                    <li>?????????<?php echo $film_details[0]["film_length"]?>??????</li>
                </ul>
            </div>
            <div class="seatContent">
                <ul>
                    <li>
                        <label>?????????</label>
                        <strong><?php echo $cinema_name[0]["cinema_name"] ?></strong>
                    </li>
                    <li>
                        <label>?????????</label>
                        <strong><?php echo $hall_name[0]["hall_name"] ?></strong>
                    </li>
                    <li>
                        <label>??????</label>
                        <em><?php echo $hall_name[0]["film_date"]?> <?php echo $hall_name[0]["start_time"]?></em>
                    </li>
                    <li class="line">
                        <label>?????????</label>
                        <a class="seat_num" id="has_chose" style="float: left"></a>
                    </li>
                    <li>
                        <label>?????????</label>
                        <span class="titlePrice">
                            ???<?php echo $hall_name[0]["film_price"] ?> x
                            <i id="_num" class="_num">0</i>
                        </span>
                        <span class="offer" id="offer">0.00</span>
                    </li>
                    <li class="total">
                        <label>?????????</label>
                        <div>
                            ???
                            <span class="J_price" id="J_price">0</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="seatForm">
                <ul>
                    <li>
                        <a href="#" class="sub J_btn" id="sub" style="color: white">?????????????????????</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <?php
        $hall_info = $hall_seat[0]["seat_info"];
        $seat_num = explode(",",$hall_info);//????????????0???000000,1???000001,2???110000??????
        /*echo "<script>alert('".$seat_num[3]."')</script>";*/
        $seat_num_count = count($seat_num);//?????????

        session_start();
        $int_num = 0;//??????
        $int_cross = 0;//0-7,8?????????

        $cross_num = str_split($seat_num[$int_num]);//??????i??????????????????????????????????????????????????????
        $cross_num_count = count($cross_num);//??????????????????
    ?>
    <script type="text/javascript">
        $(function(){
            var html='';
            html += '<ul class="touchs" id="touchs">';
            /*for(var i=0; i<1; i++){*/
            <?php
                for ($i = 0;$i<$seat_num_count*$cross_num_count;$i++){//i????????????
                    $cross_num = str_split($seat_num[$int_num])?>
                if ('<?php echo $cross_num[$int_cross]?>' == '0'){
                    var selected ='';
                }else if ('<?php echo $cross_num[$int_cross]?>' == '1'){
                    var selected ='selected';
                }else if ('<?php echo $cross_num[$int_cross]?>' == '2'){
                    var selected ='bad';
                }
            <?php
                if ($int_cross < 7 ) {
                    $int_cross++ ;
                }else{
                    $int_num++;
                    $int_cross = 0;
                }
            ?>
            html+='<li class="'+selected+'">';
            html+='<input type="checkbox" name="seat-<?php echo $i?>" id="seat-<?php echo $i?>" />';
            html+='<label for="seat-<?php echo $i?>"></label>';
            html+='</li>';
            <?php }?>
            /*}*/
            html+='<div class="crossnum" id="crossnum"></div></ul>';
            $('#seats').html(html);
            /*alert(html);*/

            $('.selected').children('input').attr({'disabled':'disabled','checked':'checked'});//?????????????????????

            var idList = new Array(-1,-1,-1,-1,-1);

            $('.seats li input').on('click',function(){//?????????????????????
                var checklen = $('.seats li').not('.selected').children('input:checked').length;
                var flag = true;
                console.log(checklen);
                $('#_num').empty();
                $('#_num').append(checklen);
                $('#J_price').empty();
                $('#J_price').append(checklen*<?php echo $hall_name[0]["film_price"]?>+".00");
                $('#offer').empty();
                $('#offer').append(checklen*<?php echo $hall_name[0]["film_price"]?>+".00");
                if(checklen>5){
                    alert('??????????????????????????????');
                    return false;
                }
                var id = $(this).attr("id").split("-");
                for (let i=0;i<5;i++){//?????????????????????????????????
                    if (idList[i]==id[1]){
                        flag = false;
                        idList[i] = -1;
                    }
                }
                if (flag == true){//????????????
                    for (let i=0;i<5;i++){
                        if (idList[i] == -1){
                            idList[i] = id[1];
                            break;
                        }
                    }
                    var pai = parseInt(id[1]/<?php echo $cross_num_count?>)+1;
                    var lie = (id[1]%<?php echo $cross_num_count?>)+1;
                    $('#has_chose').append(pai+"???-"+lie+"??? ");
                }else{//?????????????????????????????????
                    $('#has_chose').html("");
                    for (let i=0;i<5;i++){
                        if (idList[i] != -1){
                            var pai1 = parseInt(idList[i]/<?php echo $cross_num_count?>)+1;
                            var lie1 = (idList[i]%<?php echo $cross_num_count?>)+1;
                            $('#has_chose').append(pai1+"???-"+lie1+"??? ");
                        }
                    }
                }
                /*var seat1=idList[0],seat2=idList[1],seat3=idList[2],seat4=idList[3],seat5=idList[4];
                switch (seat1+seat2+seat3+seat4+seat5){
                    case -5:
                        $('#_num').append("0");
                        break;
                    case -3:
                        $('#_num').append("1");
                        break;
                    case -1:
                        $('#_num').append("2");
                        break;
                    case 1:
                        $('#_num').append("3");
                        break;
                    case 3:
                        $('#_num').append("4");
                        break;
                    case 5:
                        $('#_num').append("5");
                        break;
                    default
                        break;
                }*/
            });

            var crossnum='';//?????????
            crossnum+='<ul>';
            for(var j=1; j<=<?php echo $cross_num_count?>; j++){
                crossnum+='<li>'+j+'</li>';
            }
            html+='</ul>';
            $('#crossnum').html(crossnum);

            $("#sub").click(function (){
                var seat1=idList[0],seat2=idList[1],seat3=idList[2],seat4=idList[3],seat5=idList[4];
                if (seat1==-1&&seat2==-1&&seat3==-1&&seat4==-1&&seat5==-1){
                    alert("??????????????????????????????");
                    return false;
                }
                if (confirm("???????????????????????????????????????????????????!")) {
                    window.location.href="http://localhost/tpp/web/pay_order.php?cinema_id=<?php echo $cinema_id?>&film_times_id=<?php echo $film_times_id?>&film_id=<?php echo $film_id?>&user_name=<?php echo $_SESSION["user_name"]?>&seat1="+seat1+"&seat2="+seat2+"&seat3="+seat3+"&seat4="+seat4+"&seat5="+seat5;
                } else {
                    return false;
                }
            })
        })
    </script>
</body>
</html>
