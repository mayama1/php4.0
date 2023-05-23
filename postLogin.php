<?php
session_start();
$username=trim($_POST['username']);
//采用了MD5隐藏密码
$pw=trim($_POST['pw']);
$code=$_POST['code'];
//判断验证码的正确
if(strtolower($_SESSION['captcha'])==strtolower($code)){
    $_SESSION['captcha']=='';
}else{
    $_SESSION['captcha']=='';
    echo "<script>alert('验证码错误');location.href='login.php?id=3';</script>";
    exit;
}
//判断用户名和密码
if (!strlen($username)||!strlen($pw)){
    echo "<script>alert('用户名和密码均要填写');history.back();</script>";
    exit;
}
else{
//    判断用户名
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写字符和数字构成，长度为3到10个字符1');history.back();</script>";
        exit;
    }
    if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)){
        echo "<script>alert('密码必填，且只能大小写字符和数字以及*和_构成，长度为6到10个字符');history.back();</script>";
        exit;
    }
}
include_once'conn.php';
//$sql="select * from info where username='$username' and pw='".md5($pw)."'";
$sql="select * from userinfo where username='$username'and pw='$pw'";
//$result=mysqli_query($conn,$sql);
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
if($num){

    $_SESSION['loggedUsername']=$username;
    $info=mysqli_fetch_array($result);
    $_SESSION['loggedUserID']=$info['id'];
    if($info['admin']){
        $_SESSION['isAdmin']=1;
    }else{
        $_SESSION['isAdmin']=0;
    }
    echo "<script>alert('登录成功');location.href='index.php';</script>";

}else{
    unset($_SESSION['isAdmin']);
    unset($_SESSION['loggedUsername']);
    echo "<script>alert('登录失败');window.parent.closeLayer() ;</script>";
}