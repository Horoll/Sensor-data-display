//加载
(function($){
	$(window).load(function(){
		$('#status').fadeOut();
		$('#preloader').delay(300).fadeOut('slow');
	});

	$(document).ready(function(){
		//code
	})

})(jQuery);

var but=document.getElementsByClassName('but');
but.onclick=function () {
	alert('搜索中');
}

/*登录框*/
playauto();

function playauto() {
	//获取浏览器宽高度
	var _width = $(window).width(); //宽
	var _height = $(window).height(); //高
	//alert(_width)
	$("#dl").css({
		left: _width / 2 - 300,
		top: _height / 2 - 175
	})
}
//当动态改变浏览器窗口时
$(window).resize(function() {
	playauto();
})
//点击按钮显示
$(".but_login").click(function() {
	playauto();
	$("#bg").show(); //显示
	$("#dl").show();

})
//点击按钮关闭
$(".close").click(function() {
	$("#bg").hide(); //隐藏
	$("#dl").hide();
})
//登陆框移动
//鼠标按下
$(".title").mousedown(function(e) {
	//获取鼠标位置
	var x = e.clientX;
	var y = e.clientY;
	var $left = $("#dl").offset().left; //登陆框距离左边位置
	var $top = $("#dl").offset().top; //登陆框距离上边位置
	var l = x - $left;
	var t = y - $top;
	//鼠标移动
	$(document).mousemove(function(e) {
		//动态获取鼠标位置
		var nx = e.clientX;
		var ny = e.clientY;
		var n_left = nx - l; //定位左边
		var n_top = ny - t; //定位上边
		$("#dl").css({
			left: n_left,
			top: n_top
		})
	})
	//鼠标抬起
	$(document).mouseup(function() {
		$(document).unbind("mousemove");
		$(document).unbind("mouseup");
	})
})

/*图片轮换*/
var _index = 0; 
var timePlay = null;
$("#Adv .ImgList").eq(0).show().siblings("div").hide(); 

$("ul.button li").hover(function() { 
	clearInterval(timePlay); 
	_index = $(this).index(); 
	$(this).addClass("hover").siblings().removeClass("hover");   
	$("#Adv .ImgList").eq(_index).fadeIn().siblings("div").fadeOut(); 
}, function() {
	autoPlay(); 
});

//自动轮播
//构建自动轮播的函数
function autoPlay() {
	timePlay = setInterval(function() {
		_index++;
		if(_index < 4) {
			if(_index == 3) {
				_index = -1;
			} //变成-1 
			$("ul.button li").eq(_index).addClass("hover").siblings().removeClass("hover"); 
			$("#Adv .ImgList").eq(_index).fadeIn().siblings("div").fadeOut(); 

		} else {
			_index = -1; /*设置序列号为-1,跳到播放第一张图片*/
		}
	}, 2000);
};
autoPlay(); 


/*第一个导航*/
$("li a.second").click(function() {
	$("ul .second-1").slideToggle(300, function() {

	});

});

$(function() {

	$("li a.second").toggle(function() {

		$(".shiwai").addClass('changeBg');
		$(this).css("color", "white")

	}, function() {

		$(".shiwai").removeClass('changeBg');
		$(this).css("color", "#8aa4af")
	});

})

/*第二个导航*/
$("li a.thrid").click(function() {
	$("ul .thrid-1").slideToggle(300, function() {

	});
});

$(function() {

	$("li a.thrid").toggle(function() {

		$(".shinei").addClass('changeBg');
		$(this).css("color", "white")

	}, function() {

		$(".shinei").removeClass('changeBg');
		$(this).css("color", "#8aa4af")
	});

});

/*查找导航*/
$("li a.search_head").click(function() {
	$("ul .search").slideToggle(300, function() {

	});

});

$(function() {

	$("li a.search_head").toggle(function() {

		$(".chaxun").addClass('changeBg');
		$(this).css("color", "white")

	}, function() {

		$(".chaxun").removeClass('changeBg');
		$(this).css("color", "#8aa4af")
	});

})

$("ul.second-1 li").click(function(){
		if($(this).find(".datas").is(':hidden')){
		$(this).find(".datas").show();}
		else{
		$(this).find(".datas").hide();}
	});
	
$("ul.thrid-1 li").click(function(){
		if($(this).find(".datas").is(':hidden')){
		$(this).find(".datas").show();}
		else{
		$(this).find(".datas").hide();}
	});

$("ul.search li").click(function(){
		if($(this).find(".search_1").is(':hidden')){
		$(this).find(".search_1").show();}
		else{
		$(this).find(".search_1").hide();}
		if($(this).find(".search_2").is(':hidden')){
		$(this).find(".search_2").show();}
		else{
		$(this).find(".search_2").hide();}
		if($(this).find(".search_3").is(':hidden')){
		$(this).find(".search_3").show();}
		else{
		$(this).find(".search_3").hide();}
	});
