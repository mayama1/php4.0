<?php
$id=$_POST['id'];
$photoName = $_POST['photoName'];
$photoDesc = $_POST['photoDesc'];
//print_r($_FILES['carPic']);
//第一步，判断图片上传是否有错
if($_FILES['Pic']['error']>0 and $_FILES['Pic']['error']<>4){
    echo "<script>alert('图片上传错误');history.back();</script>";
    exit;
}
//判断图片大小
if(!empty($_FILES['Pic']['name'])){
    if($_FILES['Pic']['size']>2048*1024){
        echo "<script>alert('图片不能大于2MB');history.back();</script>";
        exit;
    }
//    判断图片类型
    $allowType=array("image/gif","image/pjpeg","image/jpeg","image/png","image/png");
    if(!in_array($_FILES['Pic']['type'],$allowType)){
        echo "<script>alert('图片类型错误');history.back();</script>";
        exit;
    }
//    判断拓展名
    $allowExt=array("jpg","jpeg","png","gif");
    $nameArray=explode(".",$_FILES['Pic']['type']);
    $nameExt=end($nameArray);
    if(!in_array(strtolower($nameExt),$allowExt)){
        echo "<script>alert('图片拓展名错误');history.back();</script>";
        exit;
    }
    //保存文件名
    $fileName=uniqid().".".$nameExt;
    $result=move_uploaded_file($_FILES['Pic']['tmp_name'],"img/".$fileName);
    if(!$result){
        echo "<script>alert('保存文件出错');history.back();</script>";
        exit;
    }
}
//判断是否有图片
include_once 'conn.php';
if($fileName){
    //上传
    $sql="update photo set photoName='$photoName',photoDesc='$photoDesc',Pic='$fileName'where id=$id";
}else{
    $sql="update photo set photoName='$photoName',photoDesc='$photoDesc' where id=$id";
}
$result=mysqli_query($conn,$sql);
if($result){
    echo "<script>alert('资料修改成功');location.href='admin1.0.php';</script>";
}else{
    echo "<script>alert('资料修改失败');history.back();</script>";
    exit;
}