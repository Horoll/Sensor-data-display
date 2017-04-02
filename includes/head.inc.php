<?php

//防止其他人调用这个模块
if(!defined('IN_TG')){
    exit('Accsee Defined!');
}
?>
<script type="text/javascript">
    var odl=document.getElementById('dl');
    var obg=document.getElementById('bg');
    <?php if(isset($_COOKIE['username'])){?>
    odl.style.display="none";
    obg.style.display="none";
    <?php }?>
</script>

<div id="head">
    <span>物联网传感器采集数据的web呈现</span>
    <?php if(isset($_COOKIE['username']) && !isset($_COOKIE['admin'])){?>
        <span class="head2"><a href="user.php"><?php echo $_COOKIE['username'];?></a><a href="logout.php">退出</a></span>
    <?php }elseif(isset($_COOKIE['admin']) && isset($_COOKIE['username'])){?>
        <span class="head2"><a href="user.php"><?php echo $_COOKIE['username'];?></a><a href="manage.php">管理</a><a href="logout.php">退出</a></span>
    <?php }else{?>
    <span class="head2"><a class="but_login" href="javascript:">登陆</a><a href="register.html">注册</a></span>
        <div id="bg"></div>
        <div id="dl">
        <div class="title">用户登录
            <a class="close" href="javascript:">
                <div class="buttom_close"></div>
            </a>
        </div>
        <p class="info">请用户开始登录哦！</p>
        <form method="post" action="login.php">
            <input type="hidden" name="action" value="login" />
            <p>账号：<input type="text" name="username" /></p>
            <p>密码：<input type="password" name="password" /></p>
            <p><input type="submit" value="登录" class="bottom" /><a class="registers" href="register.html" >没有账号？点击注册</a></p>
        </form>
    </div>
    <?php }?>
</div>