<?php
    include_once ("../service/CinemaService.php");
    $cinema_name = $_GET["cinema_name"];
    $cinema = new CinemaService();
    $result = $cinema->select_Cinemadetail($cinema_name);
    if (count($result)>0){
        $result = json_encode($result);
        //如果搜索成功，则保存搜索数据并核对
        session_start();
        $_SESSION["cinema_name"] = $cinema_name;
    }
    else{
        //$result = ["state" =>"输入信息错误或已经核对成功"];
        //$result = json_encode($result);
        $result = ["0"=>"囧 ~当前城市没有影院信息，你可以去切换城市看看"];
        $result = "[" .json_encode($result) . "]";
    }
    echo $result;
    //return $result;