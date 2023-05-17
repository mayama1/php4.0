<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>投票</title>
    <script src="jQueryDownload/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="layer/layer.js"></script>
    <style>
        .login{
            text-align: right;
            margin-bottom: 20px;
        }
        .img{
            position: relative;
        }
        .row img{width: 100%;

        }
        .img .row{
            position: absolute;
            bottom: 0;
            left: 15px;
            background-color: rgba(0,0,0,0.5);
            width: 100%;
            color: white;
        }
        p{
            margin: 10px 0 !important;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">投票系统</h1>
    <p class="login"> <a href="javascript:open('admin/login.php','用户登录')">登录</a>
        <a href="javascript:open('admin/singup.php','用户注册')">注册</a></p>
    <div class="row">
        <?php
        include_once 'conn.php';
        $sql="select * from photo order by id desc ";
        $result=mysqli_query($conn,$sql);
        $i=1;
        while($info=mysqli_fetch_array($result)){


        ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div class="img">
               <a href="vote.php?id=<?php echo $info['id'];?>" > <img src="img/<?php echo $info['Pic'];?>"></a>
                <div class="row">

                    <div class="col-xs-12 col-sm-8 col-md-6" >
                        <p class="text-center"><?php echo $info['photoName'];?></p>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-6" >
                        <p class="text-center"><?php echo $info['photoNum'];?></p>
                    </div>
                </div>
            </div>
            <p><?php echo $info['photoDesc'];?></p>
        </div>

        <?php
//            每两个清理浮动
            if($i%2==0){
                echo '<div class="clearfix visible-sm-block"></div>';
            }
            if($i%3==0){
                echo '<div class="clearfix visible-md-block"></div>';
            }
            if($i%4==0){
                echo '<div class="clearfix visible-lg-block"></div>';
            }
            $i++;
        }
        ?>
    </div>
</div>
</body>
<script>
    function open(url,title){
        layer.open({
            type: 2,
            title:'',
            area: ['700px', '450px'],
            fixed: false, //不固定
            maxmin: true,
            content: 'test/iframe.html'
        });
    }
</script>
</html>