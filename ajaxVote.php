<?php
session_start();
//判断是否登录
$a=array();
if(!(isset($_SESSION['loggedUsername'])&& $_SESSION['loggedUsername'])){
    $a['error']=1;
    $a['errMsg']='请先登录再访问本页面!';
    echo json_decode($a);
    exit;
}
include_once 'conn.php';
$id=$_GET['id']??'';
$code=$_GET['code'];
if(strtolower($_SESSION['captcha'])==strtolower($code)){
    $_SESSION['captcha']=='';
}else{
    $_SESSION['captcha']=='';
    $a['error']=1;
    $a['errMsg']='验证码错误';
    echo json_decode($a);
    exit;
}
if(!is_numeric($id)||$id==''){
    $a['error']=1;
    $a['errMsg']='参数错误';
    echo json_decode($a);
    exit;
}
//投票条件
//一个人在一天给一个图片只能投5票
$sql="select 1 from votedetail where userID=".$_SESSION['loggedUserID']." and photoID=$id and FROM_UNIXTIME(voteTime,'%Y-%m-%d')='".date("Y-m-d")."'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
//if (!$result) {
//    printf("Error: %s\n", mysqli_error($conn));
//    exit();
//}
if($num==5){
//    当前用户已经给该照片投至5票
    $a['error']=1;
    $a['errMsg']='已经给同一照片投了5票了！';
    echo json_decode($a);
    exit;
}
//一人一天只能给三张不同照片投票
$sql="select photoID from votedetail where userID=".$_SESSION['loggedUserID']." and FROM_UNIXTIME(voteTime,'%Y-%m-%d')='".date("Y-m-d")."' and photoID<>$id group by photoID";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
if($num>= 3){
    $a['error']=1;
    $a['errMsg']='已经给三张不同的照片投过票了!';
    echo json_decode($a);
    exit;
};
//两次投票间隔要求60s以上
$sql="select voteTime from votedetail where userID=".$_SESSION['loggedUserID']." order by id desc limit0,1 ";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)){
//    用户已经投过票
    $info=mysqli_fetch_array($result);
    if(time() - $info['voteTime']<=60){
        $a['error']=1;
        $a['errMsg']='60s以后再投票';
        echo json_decode($a);
        exit;
    }
}

//第一步：更新photonum
$sql1="update photo set photonum = photoNum + 1 where id = $id";
//第二步：更新votedetail、
$sql2=" insert into votedetail (userID,photoID,voteTime,ip) values ('".$_SESSION['loggedUserID']."','$id','".time()."','".getip()."')";
//引入事务机制
echo $sql2;
mysqli_autocommit($conn,0);
$result1 = mysqli_query ($conn,$sql1);
$result2 = mysqli_query ($conn,$sql2);
//if (!$result2) {
//    printf("Error: %s\n", mysqli_error($conn));
//    exit();
//}
echo $result2;
mysqli_error($result2);
if($result1 and $result2){
    mysqli_commit($conn);
    $a['error']=0;
    echo json_decode($a);
}
else{
    mysqli_rollback($conn);
    $a['error']=1;
    $a['errMsg']='投票失败';
    echo json_decode($a);
    exit;
}

//获取ip
function getip() {
    static $ip= '';
    $ip = $_SERVER['REMOTE_ADDR'];
    if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
        $ip = $_SERVER['HTTP_CDN_SRC_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return ($ip);

}