<?php
include_once 'conn.php';
$id=$_GET['id']??'';
if(!is_numeric($id)||$id==''){
    echo "<script>alert('参数错误');history.back();</script>";
    exit;
}
$sql="update photo set photonum=photonuum+1 where id=$id";
$result=mysqli_connect($conn,$sql);
if($result){
    echo "<script>alert('投票成功');location.href='index.php';</script>";
}
else{
    echo "<script>alert('投票失败');history.back();</script>";
}