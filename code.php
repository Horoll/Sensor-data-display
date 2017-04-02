<?php

//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','code');

/**
 * _code():生成验证码图片
 * @access pulic
 * @param int $_width 验证码宽度
 * @param int $_height 验证码高度
 * @param int $_rnd_code 验证码位数
 * @return void
 */
function _code($_width=100,$_height=50,$_rnd_code=4){
    $_nmsg=NULL;
//随机0-15的随机数，并且转换为十六进制，循环4位
    for($i=0;$i<$_rnd_code;$i++){
        $_nmsg.=dechex(mt_rand(0,15));
    }

    /**
     * 将生成的验证码保存在session里
     * session是一个数组，每个元素保存验证码的一个字符
     */
    $_SESSION['code']=$_nmsg;

//创建验证码图片
    $_img=imagecreatetruecolor($_width,$_height);

//选择验证码图片背景色
    $_backgroundcolor=imagecolorallocate($_img,255,255,255);

//将背景颜色填充到验证码图片上
    imagefill($_img,0,0,$_backgroundcolor);

//在图片上随机画出4条线
    for($i=0;$i<4;$i++){
        //设置线条颜色
        $_rnd_color=imagecolorallocate($_img,mt_rand(80,100),mt_rand(130,150),mt_rand(200,220));

        //设置线条粗细
        imagesetthickness($_img,2);

        //随机出线条的位置，长度
        imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
    }

////随机雪花
//    for($i=0;$i<5;$i++){
//        //随机颜色
//        $_rnd_color=imagecolorallocate($_img,mt_rand(150,200),mt_rand(150,200),mt_rand(150,200));
//
//        //随机出雪花位置
//        imagestring($_img,mt_rand(1,5),mt_rand(0,$_width),mt_rand(0,$_height),'*',$_rnd_color);
//    }

//将验证码转换成图片显示在背景图上
    for($i=0;$i<strlen($_SESSION['code']);$i++){
        //随机颜色
        $_rnd_color=imagecolorallocate($_img,90,142,200);

        $font="./ttf/ttf.ttf";

        //随机验证码大小、位置
        //imagestring($_img,5,$i*$_width/strlen($_SESSION['code'])+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
        imagettftext($_img,40,0,$i*$_width/strlen($_SESSION['code']),($_height),$_rnd_color,$font,$_SESSION['code'][$i]); //写 TTF 文字到图中
    }

//输出图像
    header('Content-Type:image/png');
    imagepng($_img);

//销毁图像
    imagedestroy($_img);
}

//调用_code函数
//默认验证码大小：100*50，长度为4
//可以通过数据库的方法来设置验证码的各种属性
_code(80,35);

?>
