// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('main'));

var labelRight = {
    normal: {
        position: 'right'
    }
};

//初始数据
var defaultValue=[
    {value: -0.2, label: labelRight},
    {value: 0, label: labelRight},
    {value: 26.5, label: labelRight},
    {value: 186.2, label: labelRight},
    {value: 0.7 , label: labelRight},
    {value: 0.8, label: labelRight},
    {value: 87.6, label: labelRight},
    {value: 27.6, label: labelRight},
    {value: -2, label: labelRight},
    {value: -75, label: labelRight},
    {value: 7.8, label: labelRight},
    {value: 8.5, label: labelRight},
    {value: 184.7, label: labelRight},
    {value: 0.7, label: labelRight},
    {value: 98.4, label: labelRight},
    {value: 24.9, label: labelRight}
];

option = {

    title: {
        text: '实时数据',
        subtext: '最后更新：2016-10-09 09:14:00'
    },
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    grid: {
        top: 100,
        bottom: 30
    },
    textStyle:{
        color: '#8B8989',
        fontSize: 18
    },
    xAxis: {
        type : 'value',
        position: 'top',
        splitLine: {lineStyle:{type:'dashed'}},
        axisLabel: {
            show: true,
            textStyle:{
                color: '#8B8989',
                fontSize: 18
            }
        }
    },
    yAxis: {
        type : 'category',
        nameLocation: 'middle',
        axisLine: {show: false},
        axisLabel: {
            show: true,
            textStyle:{
                color: '#8B8989',
                fontSize: 18
            }
        },
        axisTick: {show: false},
        splitLine: {show: false},
        data: ['室外温度','室外湿度','室外风速','室外风向','光合有效','太阳辐射','气象雨雪','气象雨量','室内温度','室内湿度','室内光照','室内光合','室内co2','土壤温度','土壤湿度','土壤PH']
    },
    series : [
        {
            name:'',
            type:'bar',
            label: {
                normal: {
                    show: true,
                    formatter: '{c}'
                },
                emphasis:{
                    show: true,
                    textStyle:{
                        color: '#212121'
                    }
                }
            },
            itemStyle: {
                normal: {
                    color: '#9FB6CD'
                },
                emphasis:{
                    color: '#668B8B',
                    shadowColor: '#141414',
                    shadowBlur: 15,
                    opacity: 0.8
                }
            },
            data:defaultValue
        }
    ]
};

// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);

// 异步加载数据
setInterval(function () {
    $.get('ajax.php?action=real_time_data').done(function (data) {
        //将后台传回的json字符串转换为对象
        data=$.parseJSON(data);
        //从json对象中将数据赋值给echarts数组对象
        var value=[];
        for (var i=0;i<16;i++){
            value[i]={
                value:data[i+1],
                label:labelRight
            };
        }
        // 填入数据
        myChart.setOption({
            title: {
                text: '实时数据',
                subtext: '最后更新：'+data[0]
            },
            series: [{
                // 根据名字对应到相应的系列
                data:value
            }]
        });
    });
},1000);


// setInterval(function () {
//     $.get('ajax.php?action=real_time_data').done(function (data){
//         alert(data);
//         //将后台传回的json字符串转换为对象
//         data=$.parseJSON(data);
//
//         for(var i in data){
//             alert(data[i]);
//         }
//     });
// },5000);




