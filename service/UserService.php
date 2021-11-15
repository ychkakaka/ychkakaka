<?php
include_once ("../db/DbManage.php");

class UserService{
    public function selectAUser($user_name, $pwd){
        $sqlTxt = "select * from user_info where user_name='" . $user_name . "' and user_pwd='" . $pwd . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $userList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($userList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $userList;
    }
    /*public function verifyStudent($x_no){
        $sqlTxt = "update hziee_stu set state = 1 where x_no =" . $x_no;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        return $result;//只有true或者false
    }*/

    public function selectUsername($telephone){
        $sqlTxt = "select user_name from user_info where telephone='" . $telephone . "'";
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        return $result;//只有true或者false
    }

    /*public function editStudent($edit_student){
        //执行前，要做几件事
        //1、要把老的数据从hziee_edu_old表里面取出老数据。
        $old_student = $this->qryAStudent($edit_student["x_no"], $edit_student["id_card"]);
        $sqlTxt = "update hziee_stu set state=1 , edit_status=1";
        //2、循环对比
        $flag = "";
        $count = 0;
        foreach ($edit_student as $item=>$value){
            //echo $item . "|" . $value . "<br>";
            if ($value == $old_student[0][$item]){//相当说明没有被修改
                $flag .= "0";
            }
            else{//说明修改了，把flag置为1，并且修改update语句
                $flag .= "1";
                $sqlTxt .= "," . $item . "='" . $value . "'";
            }
            $count++;
            if ($count >= 14){
                break;
            }
        }
        //3、循环过程中，来自$edit_student的数据和老的数据不一致，改成1，否则是0
        //4、生成一个00001111...的14位表达字符串，并把它存入到数组的edit_flag里面
        $sqlTxt .= ", edit_flag='" . $flag . "' where x_no=" . $edit_student["x_no"];
        //echo $sqlTxt;
        //5、执行生成新的sql语句
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        return $result;//只有true或者false
    }*/

    public function addAUser($userid,$username,$telephone,$sex,$pwd){
        $sqlTxt = "insert into user_info(user_id,user_name,telephone,sex,user_pwd)
                   values ('" . $userid . "','" . $username . "','" . $telephone . "','" . $sex . "','" . $pwd . "')";
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        return $result;//只有true或者false
    }

    public function checkAUser($user_name){
        $sqlTxt = "select * from user_info where user_name='" . $user_name . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $userList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($userList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $userList;
    }

    public function checkPhone($telephone){
        $sqlTxt = "select * from user_info where telephone='" . $telephone . "'";
        //echo $sqlTxt;
        $dbManage = new DbManage();
        $result = $dbManage->executeSqlTxt($sqlTxt);
        $userList = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($userList, $row);
        }
        //要考虑关闭数据库链接
        $dbManage->closeConnection($result);

        return $userList;
    }
}