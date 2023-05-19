<?php
header("Content-Type:text/html;charset=utf-8");
//获取表单
$username=trim($_POST['username']);
//采用了MD5隐藏密码
$pw=trim($_POST['pw']);
$cpw=trim($_POST['cpw']);
$sex=$_POST['sex'];
$fav=$_POST['fav'];
$fav=@implode(",",$_POST['fav']);
$email=$_POST['email'];
$sex==1?'男':'女';
include_once 'conn.php';//引入公共文件
//验证
if (!strlen($username)||!strlen($pw)){
    echo "<script>alert('用户名和密码均要填写');history.back();</script>";
    exit;
}
else{
//    判断用户名
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写字符和数字构成，长度为3到10个字符');history.back();</script>";
        exit;
    }
}
if($pw<>$cpw){
    echo "<script>alert('两次密码不同');history.back();</script>";
    exit;
}
//判断密码
if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)){
    echo "<script>alert('密码必填，且只能大小写字符和数字以及*和_构成，长度为6到10个字符');history.back();</script>";
    exit;
}
//判断email
if(!empty($email)){
    if(preg_match('/^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/',$pw)){
        echo "<script>alert('信箱格式不正常');history.back();</script>";
        exit;
    }
}
//判断用户名是否重复
$sql="select * from info where username='$username'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
if($num){
    echo "<script>alert('用户名已存在');history.back();</script>";
    exit;
}
//数据的插入
$sql="insert into info(username,pw,sex,email,fav,createtime) values ('$username','".md5($pw)."','$sex','$email','$fav','".time()."')";

$result=mysqli_query($conn,$sql);
echo $result;
if($result){
    echo "<script>alert('数据插入成功！');location.href='index.php'</script>";
}else{
    echo "<script>alert('数据插入失败！');history.back()</script>";
    echo mysqli_error();
}