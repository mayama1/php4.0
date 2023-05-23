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
    <link rel="stylesheet" href="layui/css/layui.css">
    <title>会员管理系统</title>
    <style>
        .main{
            width: 80%;
            margin: 50px auto;
            height: 300px;
            text-align: center;
            /*margin-top: 50px;*/
        }
        td{
            padding: 20px;
        }
        h2{
            font-size: 20px;
        }
        h2 a{
            color: aquamarine;
            text-decoration: none;
            margin-right:15px ;
        }
        h2 a:last-child{
            margin-right: 0;
        }
        h2 a:hover{
            color: gray;
            text-decoration: underline;
        }
        .red{
            color: red;
        }
        .layui-layout{
            height: 744px;
            /*border: 1px solid red;*/
            background-image: url("img/bg.jpg");
            background-size: 100% 100%;
        }
    </style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="layui/layui.js"></script>
<div class="layui-layout layui-layout-admin" style="text-align:center">
    <h2 style="text-align: center;font-size: 45px">投票系统</h2>
    <!--    <div class="layui-layout layui-layout-admin">-->
    <div class="layui-header" style="background-color: #4e4f4f2b;">
        <!-- 头部区域（可配合layui 已有的水平导航） -->
        <ul class="layui-nav layui-layout-left" style="left: 480px;">
            <!-- 移动端显示 -->
            <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
                <i class="layui-icon layui-icon-spread-left"></i>
            </li>
            <li class="layui-nav-item layui-hide-xs"><a href="index.php">首页</a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="login.php">登录</a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="singup.php">注册</a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="javascript:;">修改资料</a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="admin1.0.php">后台管理</a></li>
        </ul>
    </div>


    <!--        <div class="layui-body">-->
    <div class="main" style="padding: 15px">
        <?php
        include_once 'conn.php';
        $username=$_GET['username']??'';
        $sql="select * from  userinfo where username='".$_SESSION['loggedUsername']."'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)){
            $info=mysqli_fetch_array($result);
        }else{
            die("未找到有效用户");
        }
        ?>

        <form action="postModify.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse: collapse"cellpadding="10" cellspacing="0">
                <tr>
                    <td align="right">用户名</td>
                    <td align="left"><input name="username" value="<?php echo $info['username']?>"></td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input type="password" name="pw" placeholder="不修改密码不填"></td>
                </tr>
                <tr>
                    <td align="right">确认密码</td>
                    <td align="left"><input type="password" name="cpw"  placeholder="不修改密码不填"></td>
                </tr>
                <tr>
                    <td align="right">邮箱</td>
                    <td align="left">
                        <input name="email" value="<?php echo $info['email']?>"></td>
                </tr>
                <tr>
                    <td align="right"><input type="submit" value="提交"></td>
                    <td align="left"><input type="reset" value="重置">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- 内容主体区域 -->
</div>


</body>
<script>
    layui.use(['element', 'layer', 'util'], function(){
        var element = layui.element;
        var layer = layui.layer;
        var util = layui.util;
        var $ = layui.$;
        //头部事件
        util.event('lay-header-event', {
            menuLeft: function(othis){ // 左侧菜单事件
                layer.msg('展开左侧菜单的操作', {icon: 0});
            },
            menuRight: function(){  // 右侧菜单事件
                layer.open({
                    type: 1
                    ,title: '更多'
                    ,content: '<div style="padding: 15px;">处理右侧面板的操作</div>'
                    ,area: ['260px', '100%']
                    ,offset: 'rt' //右上角
                    ,anim: 'slideLeft'
                    ,shadeClose: true
                    ,scrollbar: false
                });
            }
        });
    });

function check(){
    let pw=document.getElementsByName('pw')[0].value.trim();
    let cpw=document.getElementsByName('cpw')[0].value.trim();
    let email=document.getElementsByName('email')[0].value.trim();
//    用户名验证
    let pwreg=/^[a-zA-Z0-9_*]{6,10}$/;
    if(pw.length>0){
        if(!pwreg.test(pw)){
            alert("密码必填，且只能大小写字符和数字以及*和_构成，长度为6到10个字符")
            return false;
        }else {
            if(pw!=cpw){
                alert("两次密码不同");
                return false;
            }
        }
    }
    //判断邮箱
    let eamilReg=/^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
    if(email.length>0){
        if(!emailReg.test(email)){
            alert('信箱格式不正常');
            return false;
        }
    }

    return true;
}
</script>
</html>
