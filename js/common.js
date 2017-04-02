window.onload = function()
{
	var oNav = $('nav');
	var oCont = $('content');
	var oRightNav = $('rightNav');
	var oClose = $('close');
	var oTitle = $('title');
	var aA = oRightNav.getElementsByTagName('a');
	var timer = null;
	var iNow = 0;
	
	startMove(oNav, {width:document.documentElement.clientWidth},1,function(){
		oRightNav.style.display = 'block';
		move(35,2);
	});
	
	for(var i=3; i<aA.length;i++)
	{
		aA[i].i = i;
		aA[i].onclick = function()
		{
			oTitle.innerHTML = this.innerHTML;
			iNow = 0;
			move(100,1,function(){
				setTimeout(function(){
					oCont.style.top = document.documentElement.clientHeight/2 + 'px';
					startMove(oCont, {height:350,marginTop:-200},1)
				},500)
			});
		}
	}
	
	//关闭
	oClose.onclick = function()
	{
		iNow = 0;
		startMove(oCont, {height:0,marginTop:0},1,function(){
			move(35,2);
		})
	}
	
	function move(iTarget,type,fnEnd)
	{
		
		timer = setInterval(function(){
			
			startMove(aA[iNow], {top:iTarget},type);
			var bStop=true;	
			if(iNow==aA.length-1)
			{
				clearInterval(timer);
			}
			else
			{
				iNow++;
				bStop = false;
			}
			
			if(bStop)
			{
				clearInterval(timer);
				if(fnEnd)
				{
					fnEnd();
				}
			}
		},110)
	}
	
}