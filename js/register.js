/**
 * Created by lkc on 2016/11/25.
 */
window.onload = function() {

    code();

    $("#username").focus(function() {
        $("span.a").css("display", "block");
    }); $("#username").blur(function() {
        $("span.b").css("display", "none");
        $("span.a").css("display", "none");
        var x1 = document.getElementById("username").value.length;
        if(x1 < 2 || x1 > 10) {
            $("span.b").css("display", "block");
        } else {
            $("span.b").css("display", "none");
        }

       //ajax检验用户命名是否已经存在
        var username=document.getElementById("username");
        //调用检测用户名是否重复的函数
        usernameisrepeat(username.value);
    });

    $("#pwd").focus(function() {
        $("span.c").css("display", "block");
    }); $("#pwd").blur(function() {
        $("span.c").css("display", "none");
        $("span.d").css("display", "none");
        var x2 = document.getElementById("pwd").value.length;
        if(x2 < 6) {

            $("span.d").css("display", "block");

        } else {
            $("span.d").css("display", "none");
        }

    });

    $("#repwd").focus(function() {
        $("span.e").css("display", "block");
    }); $("#repwd").blur(function() {
        $("span.f").css("display", "none");
        $("span.e").css("display", "none");
        var x3 = document.getElementById("repwd").value;
        var x4 = document.getElementById("pwd").value;
        if(x3 != x4) {

            $("span.f").css("display", "block");

        } else {
            $("span.f").css("display", "none");
        }

    });

    $("#tel").focus(function() {
        $("span.g").css("display", "block");
    }); $("#tel").blur(function() {
        $("span.h").css("display", "none");
        $("span.g").css("display", "none");
        var x5 = document.getElementById("tel").value.length;
        var tel= document.getElementById("tel").value;
        if(x5 != 11 || !/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/.test(tel)) {
            $("span.h").css("display", "block");
        } else {
            $("span.h").css("display", "none");
        }
        telisrepeat(tel);
    });

    $("#check").click(function() {
        if($(".b").css("display") == "block" || $(".d").css("display") == "block" || $(".f").css("display") == "block" || $(".h").css("display") == "block"
            ||  $(".isrepeat").css("display") == "block" || $(".i").css("display") == "block" ||$("#username").val()=="" || $("#pwd").val()=="" || $("#repwd").val()=="" ||$("#tel").val()=="" ||$("#HostCodeStrZJ").val()=="vdcode"   ) {
            $(".but").prop("disabled", true);
            alert("再检查一下还有什么没填或者填错了哦^-^")
        } else {
            $(".but").css("cursor", "pointer");
            $(".but").prop("disabled", false);
        }
    });
};

//ajax,浏览器兼容
function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        //Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

//显示是否重复
function stateChanged()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
        //当用户名重复时，显示提示信息
        if(xmlHttp.responseText=='yes'){
            $("span.isrepeat").css("display", "block");

        } else {
            $("span.isrepeat").css("display", "none");
        }
    }
}

function stateChanged1()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
        if(xmlHttp.responseText=='yes'){
            $("span.i").css("display", "block");

        } else {
            $("span.i").css("display", "none");
        }
    }
}


function usernameisrepeat(username)
{
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
    {
        alert ("浏览器不支持");
        return
    }
    var url="ajax.php";
    url=url+"?action=isrepeatusername&&";
    url=url+"username="+username;
    url=url+"&&sid="+Math.random();
    xmlHttp.onreadystatechange=stateChanged;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function telisrepeat(tel)
{
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
    {
        alert ("浏览器不支持");
        return
    }
    var url="ajax.php";
    url=url+"?action=isrepeattel&&";
    url=url+"tel="+tel;
    url=url+"&&sid="+Math.random();
    xmlHttp.onreadystatechange=stateChanged1;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}