function code(){
    //局部刷新验证码
    var code = document.getElementById('code');
    code.onclick = function () {
        //alert('change');
        this.src = 'code.php?tm=' + Math.random();
    };
}