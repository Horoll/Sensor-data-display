/**
 * Created by lkc on 2016/11/25.
 */
window.onload=function(){
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
                    data: ['室外温度', '室外湿度', '室外风向', '室外风速', '光合有效', '太阳辐射', '气象雨雪', '气象雨量']
                },
                toolbox: {
                    show: true,
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
                        },
                    }
                },
                calculable: true,
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: ['1月', '2月', '3月', '4月', '6月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [{
                    name: '室外温度',
                    type: 'line',
                    stack: '总量',
                    data: [25.9, 26, 26, 26, 26, 26, 26, 26, 25.9, 25.9, 25.9, 25.9]
                }, {
                    name: '室外湿度',
                    type: 'line',
                    stack: '总量',
                    data: [96, 96.2, 96.2, 96.2, 96.2, 96.1, 96.1, 96.1, 95.9, 96, 96.1, 96.1]
                }, {
                    name: '室外风向',
                    type: 'line',
                    stack: '总量',
                    data: [0.7, 0.7, 0.7, 0.7, 0.7, 0.7, 0.7, 0.7, 0.7, 0.7, 0.7, 0.7]
                }, {
                    name: '室外风速',
                    type: 'line',
                    stack: '总量',
                    data: [207.4, 207.4, 207.4, 207.4, 229.9, 184.7, 229.7, 252.4, 207.4, 229.9, 229.9, 207.4]
                }, {
                    name: '光合有效',
                    type: 'line',
                    stack: '总量',
                    data: [1.6, 1.6, 1.6, 1.6, 1.6, 1.6, 1.6, 1.6, 1.6, 1.6, 1.6, 1.6]
                }, {
                    name: '太阳辐射',
                    type: 'line',
                    stack: '总量',
                    data: [1.3, 1.3, 1.3, 1.3, 1.3, 1.3, 1.2, 1.3, 1.3, 1.3, 1.3, 1.3]
                }, {
                    name: '气象雨雪',
                    type: 'line',
                    stack: '总量',
                    data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1]
                }, {
                    name: '气象雨量',
                    type: 'line',
                    stack: '总量',
                    data: [0, 0.4, 0.4, 0.4, 0.4, 0.4, 0.4, 0.4, 0.4, 0.4, 0.4, 0]
                }, ]
            };

            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
};