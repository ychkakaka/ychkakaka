<?php

include_once ("../db/DbManage.php");
class TimesService{
    public function select_filmhall($film_id,$cinema_id,$date){
        $sqlTxt = "select t.*,i.hall_name from film_times t inner join hall_info i on t.hall_id=i.hall_id where cinema_id='" . $cinema_id . "' and film_id='" . $film_id . "' and film_date='" . $date . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $dateList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($dateList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $dateList;
    }

    public function select_hall_name($film_times_id){
        $sqlTxt = "select t.*,i.hall_name from film_times t inner join hall_info i on t.hall_id=i.hall_id where film_times_id='" . $film_times_id . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $nameList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($nameList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $nameList;
    }

    public function FilmTimesDetail($film_times_id){
        $sqlTxt = "select * from hall_info join film_times on hall_info.hall_id = film_times.hall_id where film_times_id = '" . $film_times_id . "'";
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $hallList = array();
        while($row = mysqli_fetch_array($result)){
            array_push($hallList,$row);
        }
        $dbManage->closeConnection($result);
        return $hallList;
    }

}