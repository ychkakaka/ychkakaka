<?php

include_once ("../db/DbManage.php");
class OrderService{
    public function SeatChosed($hall_id,$seat_info){
        $sqlTxt = "update hall_info set seat_info = '".$seat_info."' where hall_id = '".$hall_id."'";
        $dbManage = new DbManage();
        $seat_result = $dbManage->executeSqlTxt($sqlTxt);

        /*$dbManage->closeConnection($result);*/

        return $seat_result;
    }

    public function OrderInfo($order_number,$user_id,$actual_money,$film_times_id){
        try {
            $sqlTxt = "insert into order_info(order_number,user_id,actual_money,film_times_id) values ('".$order_number."','".$user_id."','".$actual_money."','".$film_times_id."')";
            $dbManage = new DbManage();
            $result = $dbManage->executeSqlTxt($sqlTxt);
            /*$dbManage->closeConnection($result);*/
            return $result;
        }catch (PODException $e){

        }

    }

    public function OrderDetailinfo($order_number,$x,$y,$price,$film_times_id,$QRcode){
        $sqlTxt = "insert into order_item_info(order_number,barcode_info,pos_x,pos_y,price,film_times_id) values ('".$order_number."','".$QRcode."','".$x."','".$y."','".$price."','".$film_times_id."')";
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        /*$dbManage->closeConnection($result);*/
        return $result;
    }

}