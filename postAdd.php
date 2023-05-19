<?php
$photoName = $_POST['photoName'];
$photoDesc = $_POST['photoDesc'];
$fileName = '';
//print_r($_FILES['carPic']);
//第一步，判断图片上传是否有错
if($_FILES['Pic']['error']){
    echo "<script>alert('图片上传错误');history.back();</script>";
    exit;
}
//第二步，判断文件格式以及大小是否正确
if(!empty($_FILES['Pic']['name'])){//说明有上传图片
    //先判断文件尺寸，不得大于2MB
    if($_FILES['Pic']['size'] > 2048*1024){
        echo "<script>alert('图片文件大小不能超过2MB');history.back();</script>";
        exit;
    }
    //接下来判断文件格式
    $allowType = array("image/gif","image/pjpeg","image/jpeg","image/jpg","image/png");
    if(!in_array($_FILES['Pic']['type'],$allowType)){
        echo "<script>alert('图片类型错误，只能是jpg、png、gif图片。');history.back();</script>";
        exit;
    }
    $allowExt = array("jpg","jpeg","png","gif");
    $nameArray = explode(".",$_FILES['Pic']['name']);
    $nameExt = end($nameArray);
    if(!in_array(strtolower($nameExt),$allowExt)){
        //echo "<script>alert('图片文件扩展名错误，只能是jpg、jpeg、png、gif文件。');history.back();</script>";
        exit;
    }
    $fileName = uniqid().".".$nameExt;
    $result = move_uploaded_file($_FILES['Pic']['tmp_name'],"img/".$fileName);
    if(!$result){
        //说明文件保存不成功
        echo "<script>alert('保存文件出错。');history.back();</script>";
        exit;
    }
}
//第三步，写入数据库。
include_once 'conn.php';
$sql = "insert into photo (photoName, photoDesc, Pic, photoNum) VALUES ('$photoName','$photoName','$fileName','0')";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>alert('添加成功。');history.back();</script>";
}
else{
    echo "<script>alert('添加失败。');history.back();</script>";
}