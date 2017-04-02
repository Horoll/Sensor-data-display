<?php

//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

//调用主函数库
require 'includes/main.func.php';

//设置字符编码为utf-8
header('Content-Type:text/html;charset=utf-8');

//拒绝PHP低版本
if(PHP_VERSION<'5.6.0'){
    exit('PHP版本太低！');
}

//连接数据库
$_conn=new mysqli('localhost','root','960921') or die('数据库连接失败：'.mysqli_error($_conn).mysqli_errno($_conn));
mysqli_select_db($_conn,'sensordata')  or die('找不到数据库：'.mysqli_error($_conn).mysqli_errno($_conn));
mysqli_query($_conn,"SET NAMES UTF8");

?>
