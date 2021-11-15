<?php
include_once ("../db/DbManage.php");

class CinemaService{
    public function select_Cinemadetails(){
        $sqlTxt = "select * from cinema_info";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $cinemaList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($cinemaList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $cinemaList;
    }

    public function select_Cinemadetail($cinema_name){
        $sqlTxt = "select * from cinema_info where cinema_name like '%" . $cinema_name . "%'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $cinemaList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($cinemaList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $cinemaList;
    }

    public function select_Cinemadetailid($cinema_id){
        $sqlTxt = "select * from cinema_info where cinema_id='" . $cinema_id . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $cinemaIdList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($cinemaIdList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $cinemaIdList;
    }
}