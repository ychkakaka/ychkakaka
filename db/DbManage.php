<?php


class DbManage{
    private $conn;
    public function executeSqlTxts($sqlTxts){//执行多条sql语句，保证要么成功，要么不成功。
        $this->conn = mysqli_connect
        ("127.0.0.1","root","Ych200123","tpp") or
        die("失败". mysqli_error());
        //设置事务级别
        $this->conn->autocommit(false);
        for ($i = 0;$i < count($sqlTxts);$i++)
            mysqli_query($this->conn,$sqlTxts[$i]);
        $result = $this->conn->commit();//提交事务
        if ($result == false)
            $this->conn->rollback();//如果有一个出错，全部取消，要保证全部成功或者全部不成功
        return $result;
    }

    public function executeSqlTxt($sqlTxt){//执行单条sql语句，不管增删改（返回true或者false）查，返回
        $this->conn = mysqli_connect
        ("127.0.0.1", "root", "Ych200123", "tpp") or
        die("失败" . mysqli_error());//数据库连接字符串配置
        $result = mysqli_query($this->conn, $sqlTxt);//进行查询或者增删改查
        return $result;
    }

    public function closeConnection($result){//关闭连接
        mysqli_free_result($result);
        mysqli_close($this->conn);
    }
}