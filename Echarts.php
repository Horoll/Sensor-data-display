<?php
//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
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

if(isset($_COOKIE['username'])){
?>

<script type="text/javascript">

    /*echart图形*/
    // 路径配置
    require.config({
        paths: {
            echarts: 'http://echarts.baidu.com/build/dist'
        }
    });

    // 使用
    require(
        [
            'echarts',
            'echarts/chart/line',
            'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
        ],
        function(ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main'));

            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['室外温度','室外湿度','室外风速','室外风向','光合有效','太阳辐射','气象雨雪','气象雨量','室内温度','室内湿度','室内光照','室内光合','室内co2','土壤温度','土壤湿度','土壤PH']
                },
                toolbox: {
                    show: true,
                    x:'900',
                    y:'30',

                    feature: {
                        dataZoom: {
                            show: true,
                            title: {
                                dataZoom: '区域缩放',
                                dataZoomReset: '区域缩放后退'
                            }
                        },
                        dataView: {
                            show: true,
                            readOnly: false
                        },
                        magicType: {
                            show: true,
                            type: ['line', 'bar', 'stack', 'tiled']
                        },
                        restore: {
                            show: true
                        }
                    }
                },
                calculable: true,

                <?php if(!isset($_POST['date_day']) && !isset($_POST['date_month']) && !isset($_POST['somedays1']) && !isset($_POST['somedays2'])){?>
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [<?php
                        foreach (_month_average_data('2016-11') as $key=>$value){
                        if($key=='时间'){
                            continue;
                        }
                        ?>{
                        name: '<?php echo $key;?>',
                        type: 'line',
                        stack: '总量',
                        data: [<?php
                            for($i=1;$i<=12;$i++) {
                                if ($i < 10) {
                                    $i='0'.$i;
                                }
                                if (!_month_average_data("2016-$i",$key)) {
                                    $_data = '';
                                } else {
                                    $_data = _month_average_data("2016-$i",$key);
                                }
                                 echo $_data . ',';
                        }
                            ?>]
                }, <?php }?>]
                <?php }
                //统计具体某一天的数据
                elseif(isset($_POST['date_day'])){?>
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        <?php for ($j=0;$j<24;$j++){
                        $time = '\''.$j.'点\',';
                        echo $time;
                    }?>
                    ]
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [<?php
                    foreach (_average_data('2016-10-09 09:14:00') as $key=>$value){
                    ?>{
                    name: '<?php echo $key;?>',
                    type: 'line',
                    stack: '总量',
                    data: [<?php
                        for($i=0;$i<24;$i++){
                            if ($i < 10) {
                                $i='0'.$i;
                            }
                            if ($_data[$i][$key]) {
                                echo $_data[$i][$key] . ',';
                            }else{
                                echo ' ,';
                            }
                        }
                        ?>]
                }, <?php }?>]
                <?php
                }elseif(isset($_POST['date_month'])){ ?>
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        <?php for ($j=1;$j<32;$j++){
                        $time = '\''.$j.'日\',';
                        echo $time;
                    }?>
                    ]
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [<?php
                    foreach (_average_data('2016-10-09 09:14:00') as $key=>$value){
                    ?>{
                    name: '<?php echo $key;?>',
                    type: 'line',
                    stack: '总量',
                    data: [<?php
                        for($i=1;$i<32;$i++){
                            if ($i < 10) {
                                $i='0'.$i;
                            }
                            if ($_data[$i][$key]) {
                                echo $_data[$i][$key] . ',';
                            }else{
                                echo ' ,';
                            }
                        }
                        ?>]
                }, <?php }?>]
            <?php }elseif(isset($_POST['somedays1']) && isset($_POST['somedays2'])){?>
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        <?php foreach ($_data as $date=>$data){
                         echo '\''.$date.'\',';
                    }?>
                    ]
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [<?php
                    foreach (_average_data('2016-10-09 09:14:00') as $key=>$value){
                    ?>{
                    name: '<?php echo $key;?>',
                    type: 'line',
                    stack: '总量',
                    data: [<?php
                            foreach ($_data as $date=>$data){
                                echo $_data[$date][$key].',';
                            }
                        ?>]
                }, <?php }?>]
            <?php }?>
            };
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
</script>
<?php }?>