function css(obj, attr, value)
{
	if(arguments.length==2)
	{
		if(attr=='alpha')
		{
			if(obj.myOpacity==undefined)
				obj.myOpacity=parseInt(100*parseFloat(obj.currentStyle?obj.currentStyle.opacity:getComputedStyle(obj, false).opacity));
			return obj.myOpacity;
		}
		else
		{
			return parseInt(obj.currentStyle?obj.currentStyle[attr]:getComputedStyle(obj, false)[attr]);
		}
	}
	else if(arguments.length==3)
		switch(attr)
		{
			case 'width':
			case 'height':
			case 'paddingLeft':
			case 'paddingTop':
			case 'paddingRight':
			case 'paddingBottom':
				value=Math.max(value,0);
			case 'left':
			case 'right':
			case 'bottom':
			case 'top':
			case 'marginLeft':
			case 'marginTop':
			case 'marginRight':
			case 'marginBottom':
				obj.style[attr]=value+'px';
				break;
			case 'alpha':
				obj.myOpacity=value;
				obj.style.filter="alpha(opacity:"+value+")";
				obj.style.opacity=value/100;
				break;
			default:
				obj.style[attr]=value;
		}
	
	return function (attr_in, value_in){css(obj, attr_in, value_in)};
}

var moveType={
	BUFFER: 1,			//缓冲
	FLEX: 2,			//弹性
	BUFFER_FAST: 3,		//缓冲—快
	COLLIS: 4,			//碰撞
	NORMAL: 5,			//匀速
	FAST: 6				//匀速—快
};

function startMove(obj, oTarget, iType, fnCallBack, fnDuring)
{
	if(!iType)iType=moveType.BUFFER;
	var fnMove=null;
	if(obj.timer)
	{
		clearInterval(obj.timer);
	}
	switch(iType)
	{
		case moveType.BUFFER:
			fnMove=DoMoveBuffer(5);
			break;
		case moveType.FLEX:
			fnMove=DoMoveFlex;
			break;
		case moveType.BUFFER_FAST:
			fnMove=DoMoveBuffer(3);
			break;
	}
	
	obj.timer=setInterval(function (){
		fnMove(obj, oTarget, fnCallBack, fnDuring);
	}, 30);
}

function DoMoveBuffer(iScale)
{
	return function (obj, oTarget, fnCallBack, fnDuring){
		var bStop=true;
		var attr='';
		var speed=0;
		var cur=0;
		
		for(attr in oTarget)
		{
			cur=css(obj, attr);
			if(oTarget[attr]!=cur)
			{
				bStop=false;
				
				
				
				speed=(oTarget[attr]-cur)/iScale;
				speed=speed>0?Math.ceil(speed):Math.floor(speed);
				
				css(obj, attr, cur+speed);
			}
		}
		
		if(fnDuring)fnDuring.call(obj);
		
		if(bStop)
		{
			clearInterval(obj.timer);
			obj.timer=null;
			
			if(fnCallBack)fnCallBack.call(obj);
		}
	};
}

function DoMoveFlex(obj, oTarget, fnCallBack, fnDuring)
{
	var bStop=true;
	var attr='';
	var speed=0;
	var cur=0;
	
	for(attr in oTarget)
	{
		if(!obj.oSpeed)obj.oSpeed={};
		if(!obj.oSpeed[attr])obj.oSpeed[attr]=0;
		cur=css(obj, attr);
		if(Math.abs(oTarget[attr]-cur)>1 || Math.abs(obj.oSpeed[attr])>1)
		{
			bStop=false;
			
			obj.oSpeed[attr]+=(oTarget[attr]-cur)/5;
			obj.oSpeed[attr]*=0.7;
			var maxSpeed=65;
			if(Math.abs(obj.oSpeed[attr])>maxSpeed)
			{
				obj.oSpeed[attr]=obj.oSpeed[attr]>0?maxSpeed:-maxSpeed;
			}
			
			css(obj, attr, cur+obj.oSpeed[attr]);
		}
	}
	
	if(fnDuring)fnDuring.call(obj);
	
	if(bStop)
	{
		clearInterval(obj.timer);
		obj.timer=null;
		if(fnCallBack)fnCallBack.call(obj);
	}
}

function DoMoveCollis(g, fScale)
{
	return function (obj, oTarget, fnCallBack, fnDuring)
	{
		var bStop=true;
		var attr='';
		var cur=0;
		
		for(attr in oTarget)
		{
			if(!obj.oSpeed)obj.oSpeed={};
			if(!obj.oSpeed[attr])obj.oSpeed[attr]=0;
			
			cur=css(obj, attr);
			if(Math.abs(oTarget[attr]-cur)>1 || Math.abs(obj.oSpeed[attr])>1)
			{
				bStop=false;
				
				obj.oSpeed[attr]+=(oTarget[attr]-cur)/5;
				obj.oSpeed[attr]*=0.7;

				css(obj, attr, cur+obj.oSpeed[attr]);
			}
		}
		
		if(fnDuring)fnDuring.call(obj);
		
		if(bStop)
		{
			clearInterval(obj.timer);
			obj.timer=null;
			if(fnCallBack)fnCallBack.call(obj);
		}
	}
}


function $(id)
{
	return document.getElementById(id);
}

function getByClass(oParent,sClass)
{
	var aEle = oParent.getElementsByTagName('*');
	var aResult = [];
	var re=new RegExp('\\b'+sClass+'\\b', 'i');
	
	for(var i=0; i<aEle.length;i++)
	{
		if(aEle[i].className.search(re)!=-1)
		{
			aResult.push(aEle[i]);
		}
	}
	return aResult;
}
