<?php

//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

/**
 * _average_data():求出某天或某个月的数据平均值
 * @param string $date 日期 格式：YYYY-MM-DD 或 YYYY-MM
 * @param string $_dataname:返回具体某一项数据的平均值
 * @return array|bool  当输入的日期有值，返回存放各项数据平均值的数据(平均值去小数点后2位)；否则返回false
 */
function _average_data($date,$_dataname=null){
    global $_conn;
    $_sql="SELECT * FROM data WHERE 时间 LIKE '%$date%' ";

    $_source=mysqli_query($_conn,$_sql) or die('SQL执行失败'.mysqli_error($_conn).mysqli_errno($_conn));
    $_row=mysqli_fetch_all($_source,MYSQLI_ASSOC);
    if(!$_row){
        return false;
    }

    //建立一个数组，用来存放平均值
    $_average_data=array();

    //用foreach获取每条数据的所有字段
    foreach ($_row[0] as $key=>$value){
        //跳过时间字段
        if($key=='时间'){
            continue;
        }
        $sum=0;
        //求出当前字段所有数据之和
        for ($i=0;$i<count($_row);$i++){
            $sum=$sum+$_row[$i][$key];
        }

        //求出当前字段的平均值，存放在对应键名（字段名）的数组中
        $_average_data[$key]=round($sum/count($_row),2);
//        echo '平均'.$key.'：'.$_average_data[$key].'</br>';
    }
    if($_dataname!=null) {
        return $_average_data[$_dataname];
    }else{
        return $_average_data;
    }
}


/**
 * _insert_month_average_date()：将一个月的平均数据插入month_average_data表中
 * @param string $date 月份，格式：YYYY-MM
 */
function _insert_month_average_date($date){
    global  $_conn;

    //求出该月的平均值
    $_average_month_data=_average_data($date);
    var_dump($_average_month_data);

    //将各项平均值插入表中
    $_sql="INSERT INTO month_average_data(
                                            时间,
                                            平均室外温度,
                                            平均室外湿度,
                                            平均室外风速,
                                            平均室外风向,
                                            平均光合有效,
                                            平均太阳辐射,
                                            平均气象雨雪,
                                            平均气象雨量,
                                            平均室内温度,
                                            平均室内湿度,
                                            平均室内光照,
                                            平均室内光合,
                                            平均室内co2,
                                            平均土壤温度,
                                            平均土壤湿度,
                                            平均土壤PH
                                            )
                                      values(
                                            '$date',
                                            '{$_average_month_data['室外温度']}',
                                            '{$_average_month_data['室外湿度']}',
                                            '{$_average_month_data['室外风速']}',
                                            '{$_average_month_data['室外风向']}',
                                            '{$_average_month_data['光合有效']}',
                                            '{$_average_month_data['太阳辐射']}',
                                            '{$_average_month_data['气象雨雪']}',
                                            '{$_average_month_data['气象雨量']}',
                                            '{$_average_month_data['室内温度']}',
                                            '{$_average_month_data['室内湿度']}',
                                            '{$_average_month_data['室内光照']}',
                                            '{$_average_month_data['室内光合']}',
                                            '{$_average_month_data['室内co2']}',
                                            '{$_average_month_data['土壤温度']}',
                                            '{$_average_month_data['土壤湿度']}',
                                            '{$_average_month_data['土壤PH']}'
                                             )
                                             ";
    mysqli_query($_conn,$_sql) or exit('SQL执行失败'.mysqli_error($_conn).mysqli_errno($_conn));

}


/**
 * _month_average_data()：从month_average_data表中读取月份的平均数据
 * @param string $_month 输入月份，格式为YYYY-MM
 * @param string $_dataname: 某一项数据的平均值
 * @return array|bool|null
 */
function _month_average_data($_month,$_dataname=null){
    global $_conn;
    $_sql="SELECT * FROM month_average_data WHERE 时间='$_month' LIMIT 1";

    $_source=mysqli_query($_conn,$_sql) or die('SQL执行失败'.mysqli_error($_conn).mysqli_errno($_conn));
    $_row=mysqli_fetch_array($_source,MYSQLI_ASSOC);
    if(!$_row){
        return false;
    }else{
        if($_dataname!=null){
            return $_row[$_dataname];
        }else{
            return $_row;
        }
    }
}


/**
 * _somedays_data()：求出一段时间内每天的数据平均值（采用字符串处理方法）
 * @param string $_day_start 开始的日期 格式：YY-MM-DD
 * @param string $_day_end 结束的日期 格式：YY-MM-DD
 * @return array 返回一个存放每一天皮平均数据的二维数组
 */
function _somedays_data($_day_start,$_day_end){
    $_average_data=array();
    $_date=$_day_start;

    //当没有到达$_day_end时，循环
    do{
        //取得这段日期里每天的数据平均值
        if(_average_data($_date)){
            $_average_data[$_date]=_average_data($_date);
        }

        //获取年 月 日
        $_year=substr($_date,0,4);
        $_month=substr($_date,5,2);
        $_day=substr($_date,8,2);
        $_day++;

        //当天数超过31天时，月份+1，天数变为01
        if($_day>31){
            //当月份超过12时，年份+1，月份、天数变为1
            if($_month>=12){
                $_day=1;
                $_month=1;
                $_year++;
                $_year=(string)$_year;
            }else{
                $_day=1;
                $_month++;
            }

            //将$_month转换为正确格式
            if ($_month < 10) {
                $_month='0'.$_month;
            }
            $_month=(string)$_month;
        }

        if ($_day < 10) {
            $_day='0'.$_day;
        }
        $_day=(string)$_day;

        //得到下一天的日期
        $_date=$_year.'-'.$_month.'-'.$_day;
    }while($_date!=$_day_end);

    return $_average_data;
}


/**
 * _somedays_data()：求出一段时间内每天的数据平均值（采用时间戳转换方法）
 * @param string $_day_start 开始的日期 格式：YY-MM-DD
 * @param string $_day_end 结束的日期 格式：YY-MM-DD
 * @return array 返回一个存放每一天皮平均数据的二维数组
 */
function _somedays_data1($_day_start,$_day_end){
    $dt_start = strtotime($_day_start);
    $dt_end = strtotime($_day_end);
    $_average_data=array();
    while ($dt_start<=$dt_end){
        //取得这段日期里每天的数据平均值
        $_average_data[date('Y-m-d',$dt_start)]=_average_data(date('Y-m-d',$dt_start));
        //日期+1
        $dt_start = strtotime('+1 day',$dt_start);
    }
    return $_average_data;
}

?>
