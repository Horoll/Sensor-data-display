<?php

//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

/**
 * _alert_back():弹出一个对话框框并且返回该页面
 * @access public
 * @param string $_info 对话框显示出的文字
 * @return void
 */
function _alert_back($_info){
    echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
    exit;
}

/**
 * _check_username():过滤用户名
 * @access public
 * @param string $_username 输入的用户名
 * @param int $_min 最小长度，默认值2
 * @param int $_max 最大长度，默认值10
 * @return string   过滤、转义处理后的用户名
 */
function _check_username($_username,$_min=2,$_max=10){
    //去掉两边的空格
    $_username=trim($_username);

    //判断长度
    if(mb_strlen($_username,'utf-8')<$_min || mb_strlen($_username,'utf-8')>$_max){
        _alert_back('用户名长度错误');
    }

    //去掉特殊字符
    $_char_pattern='/[<>\'\"\ \ ]/';
    if(preg_match_all($_char_pattern,$_username)){
        _alert_back('用户名中不得含有特殊字符');
    }

    //将用户名转义输出，用于存到数据库
    return addslashes($_username);
}


/**
 * _check_password():过滤、检查、加密密码
 * @access public
 * @param string $_password 输入密码
 * @param int $_min_num      最短密码长度，默认只是6
 * @return string           返回加密后的密码
 */
function _check_password($_password,$_min_num=6){
    //判断密码
    if(strlen($_password)<6){
        _alert_back('密码长度不能小于'.$_min_num.'位');
    }
    //返回加密的密码
    return addslashes(md5(sha1($_password)));
}

/**
 * _comparison_password():过滤、检查、对比、加密密码
 * @access public
 * @param string $_password1 输入密码
 * @param string $_password2 重复密码
 * @param int $_min_num      最短密码长度，默认只是6
 * @return string           返回加密后的密码
 */
function _comparison_password($_password1,$_password2,$_min_num=6){
    //判断密码
    if(strlen($_password1)<6){
        _alert_back('密码长度不能小于'.$_min_num.'位');
    }
    //确认两次密码是否相同
    if($_password1!=$_password2) {
        _alert_back('两次输入密码不一致');
    }
    //返回加密的密码
    return addslashes(md5(sha1($_password1)));
}

/**
 * _check_tel():检查手机号码
 * @param int $_tel:输入的手机
 */
function _check_tel($_tel){
    $search ='/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/';
    //检验长度
    if(strlen($_tel)!=11){
        _alert_back('手机号码长度错误');
    }
    //检验手机号码格式
    elseif(!preg_match($search,$_tel)) {
        _alert_back('手机号码格式错误');
    }
    return addslashes($_tel);
}
?>
