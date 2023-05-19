<?php
include_once 'checkAdmin.php';
include_once 'conn.php';
$id=$_GET['id']??0;

$sql="delete from photo where id=$id";
//$sql="drop table photo where id=$id";
$result=mysqli_query($conn,$sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
if($result){
    //echo "<script>alert('删除成功！');location.href='admin.php'</script>";
//    laiui设置的后台
    echo "<script>alert('删除成功！');history.back();</script>";
    exit;
}
else{
    echo "<script>alert('删除失败！');history.back();</script>";

    //
    exit;
}