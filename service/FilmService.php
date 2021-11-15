<?php
include_once ("../db/DbManage.php");

class FilmService{
    public function select_Filmname(){
        $sqlTxt = "select * from film_info where film_play_status='1'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $filmList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($filmList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $filmList;
    }

    public function selectFilms_status($status){
        $sqlTxt = "select * from film_info where film_play_status='" . $status . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $filmList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($filmList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $filmList;
    }

    public function selectFilms_id($film_id){
        $sqlTxt = "select * from film_info where film_id='" . $film_id . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $film_id_List = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($film_id_List, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $film_id_List;
    }

    public function selectFilms_broadcast($film_id, $film_type){
        $sqlTxt = "select * from film_broadcast_info where film_id ='" . $film_id . "' and type ='" . $film_type . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $film_url_List = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($film_url_List, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $film_url_List;
    }
}