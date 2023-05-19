<?php
include_once 'checkAdmin.php';
$id=$_GET['id']??0;
include_once 'conn.php';
$sql="delete from photo where id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    //echo "<script>alert('删除成功！');location.href='admin.php'</script>";
//    laiui设置的后台
    echo "<script>alert('删除成功！');location.href='admin1.0.php'</script>";
    exit;
}
else{
    echo "<script>alert('删除失败！');history.back();</script>";
    exit;
}