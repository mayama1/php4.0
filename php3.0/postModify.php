<?php
$username=trim($_POST['username']);
//采用了MD5隐藏密码
$pw=trim($_POST['pw']);
$cpw=trim($_POST['cpw']);
$sex=$_POST['sex'];
$fav=$_POST['fav'];
$fav=@implode(",",$_POST['fav']);
$email=$_POST['email'];
$source=$_POST['source'];
$page=$_POST['page'];
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
    $sql="update info set pw='".md5($pw)."',email='$email',fav='$fav' where username='$username'";
    $url='logout.php';
}
else{
    $sql="update info set email='$email',fav='$fav' where username='$username'";
    $url='index.php';
}
if($source=='admin'){
    $url='admin.php?id=5&page='.$page;
}
$result=mysqli_query($conn,$sql);
if($result){

    echo "<script>alert('修改数据成功');location.href='$url ';</script>";
}
else{
    echo "<script>alert('修改数据失败');history.back();</script>";
}