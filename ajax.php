<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);

//调用common文件
require_once "includes/common.inc.php";

//调用数据处理函数库
require_once "includes/dealdata.func.php";

//检验用户名是否重复
if(isset($_GET['username']) && isset($_GET['action']) && $_GET['action']=='isrepeatusername'){
    $_sql="SELECT id FROM user WHERE username='{$_GET['username']}' LIMIT 1";
    $_row=mysqli_fetch_all(mysqli_query($_conn,$_sql),MYSQLI_ASSOC);
    //如果有结果，说明用用户名重复
    if($_row){
        echo 'yes';
    }
}
//检测ajax传来的tel
elseif(isset($_GET['tel']) && isset($_GET['action']) && $_GET['action']=='isrepeattel') {
    $_sql="SELECT id FROM user WHERE tel='{$_GET['tel']}' LIMIT 1";
    $_row=mysqli_fetch_all(mysqli_query($_conn,$_sql),MYSQLI_ASSOC);
    //如果有结果，说明用用电话重复
    if($_row){
        echo 'yes';
    }
}
//检测ajax传来的获取实时数据的信息
elseif(isset($_GET['action']) && $_GET['action']=='real_time_data'){
    //从文件中读取当前数据指向那条
    $fp=fopen('number.txt','r');
    $i=fread($fp,10);
    $j=$i++;
    fclose($fp);

    $_sql="SELECT * FROM data LIMIT $i,$j";
    if($_data=mysqli_fetch_array(mysqli_query($_conn,$_sql),MYSQLI_NUM)){
        echo json_encode($_data);
    }else{
        $i=1;
        $_sql="SELECT * FROM data LIMIT $i,$j";
        $_data=mysqli_fetch_array(mysqli_query($_conn,$_sql),MYSQLI_NUM);
        echo json_encode($_data);
    }

    //指向下一条，并且写入文件
    $fp=fopen('number.txt','w');
    fwrite($fp,$i,strlen($i));
    fclose($fp);
}
else{
    //_alert_back('非法访问');
}


?>
