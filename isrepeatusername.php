<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);

//调用common文件
require_once "includes/common.inc.php";

//检测ajax传来的username
if(isset($_GET['username']) && isset($_GET['action']) && $_GET['action']=='isrepeatusername'){
    $_sql="SELECT id FROM user WHERE username='{$_GET['username']}' LIMIT 1";
    $_row=mysqli_fetch_all(mysqli_query($_conn,$_sql),MYSQLI_ASSOC);
    //如果有结果，说明用用户名重复
    if($_row){
        echo 'yes';
    }
}else{
    _alert_back('非法访问');
}

?>
