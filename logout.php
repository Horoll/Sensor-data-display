<?php

//删除登录生成的cookie
if(isset($_COOKIE['username'])){
    setcookie('username','',time()-1);
    if(isset($_COOKIE['admin'])){
        setcookie('admin','',time()-1);
    }
}
//转跳
echo "<script type='text/javascript'>alert('成功退出');location.href='cover.html';</script>";

?>
