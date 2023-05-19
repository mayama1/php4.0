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
    <form action="postLogin.php" method="post" onsubmit="return check()">
        <table align="center" border="1" style="border-collapse: collapse"cellpadding="10" cellspacing="0">
            <tr>
                <td align="right">用户名</td>
                <td align="left"><input name="username"><span class="red">*</span></td>
            </tr>
            <tr>
                <td align="right">验证码</td>
                <td align="left">
                    <input  name='code'><img src="code.php" onclick="this.src='code.php'+new Date().getTime();" width="100";height="70">
                    <span class="red">*</span></td>
            </tr>
            <tr>
                <td align="right">密码</td>
                <td align="left"><input type="password" name="pw"><span class="red">*</span></td>
            </tr>
            <tr>
                <td align="right"><input type="submit" value="提交"></td>
                <td align="left"><input type="reset" value="重置"></td>
            </tr>
        </table>
    </form>
</div>
</body>
<script>
    function check(){
        let username=document.getElementsByName('username')[0].value.trim();
        let pw=document.getElementsByName('pw')[0].value.trim();
//    用户名验证
        let usernameReg=/^[a-zA-Z0-9]{3,10}$/;
        if(!usernameReg.test(username)){
            alert("用户名必填，且只能大小写字符和数字构成，长度为3到10个字符123")
            return false;
        }
        let pwreg=/^[a-zA-Z0-9_*]{6,10}$/;
        if(!pwreg.test(pw)) {
            alert("密码必填，且只能大小写字符和数字以及*和_构成，长度为6到10个字符")
            return false;
        }
        let code=document.getElementsByName('code')[0].value.trim();
        let codereg=/^[a-zA-Z0-9_*]{4}$/;
        if(!codereg.test(code)) {
            alert("验证码必填")
            return false;
        }
        return true;
    }
</script>
</html>
