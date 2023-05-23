<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的漂亮朋友们投票</title>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js">
    </script>
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="layer/layer.js"></script>
    <style>
        body{
            background-image: url("img/bg.jpg");
            background-size: cover;
        }
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
        .td img{
            padding: 10px !important;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">投票</h1>
    <p class="login">
        <?php
        if(isset($_SESSION['loggedUsername']) and $_SESSION['loggedUsername'] != ''){
            //说明已经登录了
            ?>
            当前登录者：<?php echo $_SESSION['loggedUsername'];?> <a href="logout.php">注销</a>
            <a href="singup.php">注册</a>
            <a href="modify.php">修改资料</a>
<!--            <a href="javascript:open('singup.php','用户注册')">注册</a>-->
<!--            <a href="javascript:open('modify.php','修改资料')">修改资料</a>-->
            <?php if($_SESSION['isAdmin']){?> <a href="admin1.0.php">后台管理</a><?php }?>
            <?php
        }
        else{
            ?>
<!--            <a href="singup.php">注册</a>-->
            <a href="login.php">登录</a>
            <a href="modify.php">修改资料</a>
             <a href="singup.php">注册</a>
            <?php
        }
        ?>

    </p>
    <div class="row">
        <?php
        include_once 'conn.php';
        $sql = "select * from photo order by id desc ";
        $result = mysqli_query($conn,$sql);
        $i = 1;
        while($info = mysqli_fetch_array($result)){
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="img">
                    <?php
                    if(isset($_SESSION['loggedUsername']) and $_SESSION['loggedUsername'] != ''){
                        //说明已经登录了
                        ?>
                        <a href="vote.php?id=<?php echo $info['id'];?>"><img src="img/<?php echo $info['Pic'];?>"></a>
                        <?php
                    }
                    else{
                        ?>
                        <img src="img/<?php echo $info['Pic'];?>">
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <p class="text-center"><?php echo $info['photoName'];?></p>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-6">
                            <p class="text-center">当前票数：<?php echo $info['photoNum'];?></p>
                        </div>
                    </div>
                </div>
                <p><?php echo $info['photoDesc'];?></p>
            </div>
            <?php
            if($i % 2 == 0){
                echo '<div class="clearfix visible-sm-block"></div>';
            }
            if($i %3 == 0){
                echo '<div class="clearfix visible-md-block"></div>';
            }
            if($i %4 == 0){
                echo '<div class="clearfix visible-lg-block"></div>';
            }
            $i++;
        }
        ?>
    </div>
</div>
<script>
    // function open(url,title){
    //     layer.open({
    //         type: 2,
    //         title:title,
    //         area: ['700px', '450px'],
    //         fixed: false, //不固定
    //         maxmin: true,
    //         content: url
    //     });
    // }
    // function closeLayer(){
    //     layer.closeAll();
    // }
</script>
</body>
</html>