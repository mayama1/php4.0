<?php
include_once "checkAdmin.php"
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>图片管理</title>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script src="layer/layer.js"></script>
    <script src="js/echarts.js"></script>
    <style>
        h1{
            text-align: center;
        }
        h2{
            text-align: center;
            font-size: 16px;
        }
        h2 a{
            text-decoration: none;
        }
        .current{
            color: #01AAED;
        }
        #main{
            margin: 0 auto;
        }
    </style>
</head>
<body>
<h1>照片管理</h1>
<!--<h2><a href="index.php">返回首页</a>  <a href="admin1.0.php">图片管理</a>-->
<!--    <a href="show.php" class="current">数据查看</a>   <a href="logout.php">注销 </a></h2>-->
<div id="main" style="width: 600px;height: 400px;"></div>
<script type="text/javascript">
    var myChart = echarts.init(document.getElementById('main'));
    myChart.setOption({
        title: {
            text: '最受欢迎照片票数柱状图'
        },
        tooltip: {},
        legend: {
            data:['票数']
        },
        xAxis: {
            data: []
        },
        yAxis: {},
        series: [{
            name: '票数',
            type: 'bar',
            data: []
        }]
    });
    $.ajax({
        url:'getData.php',
        dataType:'json',
        success:function (data){
            myChart.setOption({
                xAxis: {
                    data: data.categories,
                    axisLabel: {
                        interval: 0,
                        rotate: 35
                    }

                },
                series: [{
                    name: '票数',
                    data: data.data
                }]
            });
        },
        error:function (){
            alert('获取数据出错');
        }
    })
</script>
</body>
</html>
