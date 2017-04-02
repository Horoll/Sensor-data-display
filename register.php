<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);

//调用common文件
require_once "includes/common.inc.php";

//接收到表单数据
if(isset($_POST['action'])&&$_POST['action']=='register'){

    //首先检验验证码是否正确
    if($_POST['validate']!=$_SESSION['code']){
        _alert_back('验证码输入错误');
    }

    //检验表单数据是否合法
	$_clean['username']=_check_username($_POST['userid']);
	$_clean['pwd']=_comparison_password($_POST['pwd'],$_POST['repwd']);
    $_clean['tel']=_check_tel($_POST['tel']);

    //检查用户名是否存在
    $_sql="SELECT id FROM user WHERE username='{$_clean['username']}' LIMIT 1";
    $_row=mysqli_fetch_all(mysqli_query($_conn,$_sql),MYSQLI_ASSOC);
    if($_row){
            _alert_back('该用户名已被注册');
    }

    //插入数据库
    mysqli_query($_conn,"INSERT INTO
                                  user(
                                  username,
                                  password,
                                  tel,
                                  date
                                  )
                                  VALUES (
                                  '{$_clean['username']}',
                                  '{$_clean['pwd']}',
                                  '{$_POST['tel']}',
                                  NOW()
                                  )
              ") or die('SQL执行失败'.mysqli_error($_conn).mysqli_errno($_conn));

    //判断数据库里是否只改动（新增）了一条数据
    if(mysqli_affected_rows($_conn)==1){
        //关闭数据库
        mysqli_close($_conn);
        //跳转
        echo "<script type='text/javascript'>alert('注册成功');location.href='index.php';</script>";
    }else{
        //关闭数据库
        mysqli_close($_conn);
        //跳转
        _alert_back('注册失败');
    }

}else{
	exit('非法操作');
}

?>