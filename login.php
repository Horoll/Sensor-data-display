<?php
//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);

//调用common文件
require_once "includes/common.inc.php";

//接收到表单数据
if(isset($_POST['action'])&&$_POST['action']=='login'){
    $_clean['username']=_check_username($_POST['username']);
    $_clean['password']=_check_password($_POST['password']);

    //从数据库调出数据
    $_sql="SELECT password,level FROM user WHERE username='{$_clean['username']}' LIMIT 1";
    $_row=mysqli_fetch_all(mysqli_query($_conn,$_sql),MYSQLI_ASSOC);
    if($_row){
        if($_row[0]['password']!=$_clean['password']){
            _alert_back('密码输入错误');
        }else{
            //成功登录，生成cookie
            setcookie('username',$_clean['username'],time()+60*60*24*7);
            //如果是管理员，生成管理员cookie
            if($_row[0]['level']>0){
                setcookie('admin',$_clean['username'],time()+60*60*24*7);
            }
            //关闭数据库
            mysqli_close($_conn);
            //转跳
            echo "<script type='text/javascript'>alert('登陆成功');location.href='index.php';</script>";
        }
    }else{
        _alert_back('不存在该用户');
    }

}else{
    exit('非法操作');
}

?>