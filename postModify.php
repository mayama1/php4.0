<?php
$username=trim($_POST['username']);
//采用了MD5隐藏密码
$pw=trim($_POST['pw']);
$cpw=trim($_POST['cpw']);
$email=$_POST['email'];
if (!strlen($username)){
    echo "<script>alert('用户名要填写');history.back();</script>";
    exit;
}
else{
//    判断用户名
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写字符和数字构成，长度为3到10个字符');history.back();</script>";
        exit;
    }
}
if(!empty($pw)){
    if($pw<>$cpw){
        echo "<script>alert('两次密码不同');history.back();</script>";
        exit;
    }
//判断密码
    if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)){
        echo "<script>alert('密码必填，且只能大小写字符和数字以及*和_构成，长度为6到10个字符');history.back();</script>";
        exit;
    }
}
//判断email
if(!empty($email)){
    if(!preg_match('/^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/',$pw)){
        echo "<script>alert('信箱格式不正常');history.back();</script>";
        exit;
    }
}
include_once 'conn.php';
if($pw){
//    如果有密码需要更新密码
    $sql="update userinfo set pw='$pw',email='$email' where username='$username'";
}
else{
    $sql="update userinfo set email='$email' where username='$username'";
}

$result=mysqli_query($conn,$sql);
if($result){

    echo "<script>alert('修改数据成功');window.parent.closeLayer();</script>";
}
else{
    echo "<script>alert('修改数据失败');history.back();</script>";
}