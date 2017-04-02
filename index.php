<?php

define('IN_TG',true);

//调用common文件
require_once "includes/common.inc.php";

if(isset($_POST['date_day']) && $_POST['date_day']==''){
	_alert_back('请选择日期');
}elseif(isset($_POST['date_month']) && $_POST['date_month']==''){
	_alert_back('请选择月份');
}

//调用数据处理函数
require_once 'includes/dealdata.func.php';

//统计一天里每个小时的平均数据
if(isset($_POST['date_day'])){
	$_data=array();
	for($i=0;$i<24;$i++) {
		if ($i < 10) {
			$i='0'.$i;
		}
		$_data[$i] = _average_data("{$_POST['date_day']} $i");
	}
	//var_dump($_data);
}
//统计一个月里每天的平均数据
elseif(isset($_POST['date_month'])){
	$_data=array();
	for($i=1;$i<32;$i++) {
		if ($i < 10) {
			$i='0'.$i;
		}
		$_data[$i] = _average_data("{$_POST['date_month']}-$i");
	}
	//var_dump($_data);
}

//统计一个时间段内的平均数据
elseif(isset($_POST['somedays1']) && isset($_POST['somedays2'])){
	$_data=array();
	$_data=_somedays_data1($_POST['somedays1'],$_POST['somedays2']);
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>物联网数据采集的web呈现</title>
	<link href="css/index.css" rel="stylesheet" type="text/css" charset="utf-8" media="screen and (min-width: 600px) and (max-width: 1370px)" >
	<link href="css/index2.css" rel="stylesheet" type="text/css" charset="utf-8" media="screen and (min-width: 1370px) and (max-width: 3000px)" >
	<link href="css/lyz.calendar.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include 'includes/head.inc.php';?>
<div id="Adv">
	<!--图片列表-->
	<div class="ImgList" style="background:url('img/adv1.jpg') center"></div>
	<div class="ImgList" style="background:url('img/adv2.jpg') center"></div>
	<div class="ImgList" style="background:url('img/adv3.jpg') center"></div>
	<div class="ImgList" style="background:url('img/adv4.jpg') center"></div>
	<!--轮播的按扭-->
	<ul class="button">
		<li class="hover"></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<?php  if(isset($_COOKIE['username'])){?>
	<div id="homepage">
		<div class="leftborder">
			
			<div class="catelog">
				<ul class="sidebar">
					<li>
						<a class="first" href="cover.html">
							首页
						</a>
					</li>
					<li class="chaxun">
						<a class="search_head" herf="javascript:">
							查询
						</a>
					</li>
					<ul class="search">
						<li>
							<a class="search_day">按日期查找</a>
							<div class="search_1">
								<form action="index.php" method="post">
									<input id="datepick" type="text" class='txt' name="date_day" placeholder="选择日期" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd'})"/>
									<input type="submit" class='but' title="搜索" value="" id="but" />
								</form>
							</div>
						</li>				
						<li>
							<a class="search_month">按月份查找</a>
							<div class="search_2">
								<form action="index.php" method="post">
									<input id="monthpick" type="text" class='txt' name="date_month" placeholder="选择月份" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM',readOnly:true})" />
									<input type="submit" class='but' title="搜索" value="" id="but" />
								</form>
							</div>
						</li>		
						<li>
							<a class="search_time">按时间段查找</a>
							<div class="search_3">
								<form action="index.php" method="post">
									<p class="search_p"><input id="somedays1" type="text" class='txt' name="somedays1" placeholder="选择开始日期" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd'})"/></p>
									<p class="search_p"><input id="somedays2" type="text" class='txt' name="somedays2" placeholder="选择截止日期" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd'})"/></p>
									<p class="search_p"><input type="submit" class='but' title="搜索" value="搜索" id="but" /></p>
								</form>
							</div>
						</li>
					</ul>
					<li class="shiwai">
						<a class="second" href="javascript:">
							室外
						</a>
					</li>
					<ul class="second-1">
						<?php foreach(_month_average_data('2016-11') as $key=>$value){
							if($key=='时间'){
								continue;
							}elseif($key=='室内温度'){
								break;
							}
							include "includes/list.inc.php";
						}?>
					</ul>

					<li class="shinei">
						<a class="thrid" href="javascript:">
							室内
						</a>
					</li>
					<ul class="thrid-1">
						<?php
						$i=0;
						foreach(_month_average_data('2016-11') as $key=>$value){
							$i++;
							if($i<10) {
								continue;
							}
							include "includes/list.inc.php";
						}?>
					</ul>
				</ul>
			</div>
		</div>

		<div class="rightborder">
			<h1>
				<?php
				if(isset($_POST['date_day'])){
					echo $_POST['date_day'];
				}elseif(isset($_POST['date_month'])){
					echo $_POST['date_month'];
				}elseif(isset($_POST['somedays1']) && isset($_POST['somedays2'])){
					echo $_POST['somedays1'].'&nbsp;至&nbsp;'.$_POST['somedays2'];
				}else{
					echo '2016';
				}
				?>
			</h1>
			<div id="main">
			</div>
		</div>
	</div>
	<div id="foot">
	</div>
	<div id="preloader">
		<div id="status"></div>
	</div>
<?php }else{?>
	<div id="unlogin"></div>
<?php }?>

<script type="text/javascript" src="js/jquery.js"></script>
<script src="http://echarts.baidu.com/build/dist/echarts.js"></script>
<script type="text/javascript" src="js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script src="js/lyz.calendar.min.js" type="text/javascript"></script>
<script type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<?php include 'Echarts.php';?>

</body>
</html>