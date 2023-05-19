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
    <title>会员管理系统</title>
    <style>
        .main{
            width: 80%;
            margin: 0 auto;
            text-align: center;
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
        .current{
            color: cadetblue;
        }
        .red{
            color: red;
        }
    </style>
</head>
<body>
<div class="main">
    <?php
    include_once 'nav.php';
    ?>
    <form action="postReg.php" method="post" onsubmit="return check()">
        <table align="center" border="1" style="border-collapse: collapse"cellpadding="10" cellspacing="0">
            <tr>
                <td align="right">用户名</td>
                <td align="left"><input name="username" onblur="checkUsername()"><span class="red">*</span><span id="usernameMsg"></span></td>
            </tr>
            <tr>
                <td align="right">密码</td>
                <td align="left"><input type="password" name="pw"><span class="red">*</span></td>
            </tr>
            <tr>
                <td align="right">确认密码</td>
                <td align="left"><input type="password" name="cpw"><span class="red">*</span></td>
            </tr>
            <tr>
                <td align="right">验证码</td>
                <td align="left">
                    <input  name='code'><img src="code.php" onclick="this.src='code.php'+new Date().getTime();" width="100";height="70">
                    <span class="red">*</span></td>
            </tr>
            <tr>
                <td align="right">邮箱</td>
                <td align="left">
                    <input name="email"></td>
            </tr>
            <tr>
                <td align="right">性别</td>
                <td align="left">
                    <input name="sex" type="radio" checked value="1">男
                    <input name="sex" type="radio" value="0">女
                </td>
            </tr>
            <tr>
                <td align="right">爱好</td>
                <td align="left">
                    <input name="fav[]" type="checkbox" checked value="听音乐">听音乐
                    <input name="fav[]" type="checkbox" value="玩游戏">玩游戏
                    <input name="fav[]" type="checkbox" value="其他">其他
                </td>
            </tr>
            <tr>
                <td align="right"><input type="submit" value="提交"></td>
                <td align="left"><input type="reset" value="重置"></td>
            </tr>
        </table>
    </form>
</div>
</body>
<script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script>
    function checkUsername(){
        let username=document.getElementsByName('username')[0].value.trim();
        let usernameReg=/^[a-zA-Z0-9]{3,10}$/;
        if(!usernameReg.test(username)){
            alert("用户名必填，且只能大小写字符和数字构成，长度为3到10个字符")
            return false;
        }
        $.ajax({
            url:"checkUsername.php";
            type:'post',
            dataType:'json',
            data:{
                username:username,  }
                success:function (data){
                    if(data.code==0){
                        $("#usernameMsg").text(data.msg);
                    }
                    else if(data.code==2){
                        $("#usernameMsg").text(data.msg);
                    }
                },error:function (){
                alert('网络错误');
            }
        })
    }
function check(){
    let username=document.getElementsByName('username')[0].value.trim();
    let pw=document.getElementsByName('pw')[0].value.trim();
    let cpw=document.getElementsByName('cpw')[0].value.trim();
    let email=document.getElementsByName('email')[0].value.trim();
//    用户名验证
    let usernameReg=/^[a-zA-Z0-9]{3,10}$/;
    if(!usernameReg.test(username)){
        alert("用户名必填，且只能大小写字符和数字构成，长度为3到10个字符")
        return false;
    }
    let pwreg=/^[a-zA-Z0-9_*]{6,10}$/;
    if(!pwreg.test(pw)){
        alert("密码必填，且只能大小写字符和数字以及*和_构成，长度为6到10个字符")
        return false;
    }else {
        if(pw!=cpw){
            alert("两次密码不同");
            return false;
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
