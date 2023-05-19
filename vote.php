<?php
include_once 'checkLogin.php';
include_once 'conn.php';
$id = $_GET['id'] ?? '';
//$code = $_GET['code'];
////判断验证码是否正确
//if(strtolower($_SESSION['captcha']) == strtolower($code)){
//    $_SESSION['captcha'] = '';
//}
//else{
//    $_SESSION['captcha'] = '';
//    echo "<script>alert('验证码错误');location.href='index.php';</script>";
//    exit;
//}
if(!is_numeric($id) || $id == ''){
    echo "<script>alert('参数错误');history.back();</script>";
    exit;
}
//投票条件判断
//第1个条件：一个人一天只能给一辆车最多投5票
//第一种方法
/*$sql = "select 1 from votedetail where userID = ".$_SESSION['loggedUserID']." and carID = $id and voteTime = '".date("Y-m-d")."'";
$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
if($num == 5){
    //说明当前用户给当前车辆已经投过5票了
    echo "<script>alert('当前用户给当前车辆已经投过5票了');history.back();</script>";
    exit;
}*/
//第2种方法
$sql = "select count(1) as num from votedetail where userID = ".$_SESSION['loggedUserID']." and photoID = $id and FROM_UNIXTIME(voteTime,'%Y-%m-%d') = '".date("Y-m-d")."'";
$result = mysqli_query($conn,$sql);
$info = mysqli_fetch_array($result);
if($info['num'] == 5){
    //说明当前用户已经投过5票了
    echo "<script>alert('当前用户给已经投过5票了');history.back();</script>";
    exit;
}
//第2个条件
//要求一人一天最多可以给三辆车投票
$sql = "select photoID from votedetail where userID = ".$_SESSION['loggedUserID']." and FROM_UNIXTIME(voteTime,'%Y-%m-%d') = '".date("Y-m-d")."' and photoID <> $id group by photoID";
$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
if($num >= 3){  //
    echo "<script>alert('每人每天最多只能给三张图投票');history.back();</script>";
    exit;
}
//第3个条件
//两次投票之间要求间隔60s以上。
$sql = "select voteTime from votedetail where userID = " . $_SESSION['loggedUserID'] . " order by id desc limit 0,1";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)){
    //说明此用户曾经投过票
    $info = mysqli_fetch_array($result);
    if(time() - $info['voteTime'] <= 60){
        //说明投票间隔未超过60s，不可以投票
        echo "<script>alert('两次投票之间，必须间隔1分钟。');history.back();</script>";
        exit;
    }
}
//第4个条件
//IP投票限制。限制一个IP一天只能投15票
//$sql = "select 1 from votedetail where from_unixtime(voteTime,'%Y-%m-%d') = CURRENT_DATE() and ip = '".getIp()."'";
//if(mysqli_num_rows($result)>=15){
//    //说明当前IP地址已经投过15票了
//    echo "<script>alert('一个IP地址一天之内最多只能投15票。');history.back();</script>";
//    exit;
//}
//确认可以投票
//第1步操作，更新
$sql1 = "update photo set photoNum = photoNum + 1 where id = $id";
//第2步操作，更新votedteail表
$sql2 = "insert into votedetail (userID, photoID, voteTime, ip) VALUES ('".$_SESSION['loggedUserID']."','$id','".time()."','".getIp()."')";
//引入事务机制
mysqli_autocommit($conn,0); //取消自动提交
$result1 = mysqli_query($conn,$sql1);
//echo mysqli_error($conn);
$result2 = mysqli_query($conn,$sql2);
if (!$result2) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
echo mysqli_error($result2);
if($result1 and $result2){
    mysqli_commit($conn);//提交操作
    echo "<script>alert('投票成功');location.href='index.php';</script>";

}
else{
    mysqli_rollback($conn);
    echo "<script>alert('投票失败');history.back();</script>";
}
function getIp()
{
    static $ip = '';
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
    return $ip;
}