<?php
$photoName = $_POST['photoName'];
$photoDesc = $_POST['photoDesc'];
//print_r($_FILES['carPic']);
//第一步，判断图片上传是否有错
if($_FILES['Pic']['error']){
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
//导进数据库
include_once 'conn.php';
$sql="insert into photo (photoName, photoDesc, Pic, photoNum) 
values ('$photoName','$photoDesc','$fileName','0')";
$result=mysqli_query($conn,$sql);
if($result){
    echo "<script>alert('添加图片成功');location.href='admin.php';</script>";
}else{
    echo "<script>alert('添加图片失败');history.back();</script>";
    exit;
}