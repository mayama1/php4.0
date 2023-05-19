<?php
include_once 'checkAdmin.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>投票照片更改</title>
    <style>
        h1,h2{text-align: center}
        h2{font-size: 20px;}
        h2 a{text-decoration: none;color: #4476A7;}
        h2 a:hover{text-decoration: underline;color: brown}
        .img{width: 100%;max-width: 250px;}
        .current{color: blueviolet}
    </style>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<h1>照片管理</h1>
<!--<h2><a href="index.php">返回首页</a> <a href="admin1.0.php" class="current">图片管理</a> <a href="show.php">数据查看</a> <a href="logout.php.php">注销</a></h2>-->
<?php
include_once 'conn.php';
$id = $_GET['id'] ?? 0;
$sql = "select * from photo where id = $id";
$result = mysqli_query($conn,$sql);
if(!mysqli_num_rows($result)){
    echo "<script>alert('未查询到当前图片');history.back();</script>";
    exit;
}
$info = mysqli_fetch_array($result);
?>
<h2>图片修改</h2>
<form onsubmit="return check()" enctype="multipart/form-data" method="post" action="postModifyPhoto.php">
    <table width="70%" align="center" style="border-collapse: collapse;" border="1" bordercolor="gray" cellpadding="10" cellspacing="0" >
        <tr>
            <td align="right">图片名</td>
            <td align="left"><input name="photoName" id="photoName" value="<?php echo $info['photoName'];?>"></td>
        </tr>
        <tr>
            <td align="right">描述</td>
            <td align="left"><textarea name="photoDesc" id="photoDesc"><?php echo $info['photoDesc'];?></textarea></td>
        </tr>
        <tr>
            <td align="right">图片</td>
            <td align="left"><input type="file" id="Pic" name="Pic">
                <img class="img" src="img/<?php echo $info['Pic'];?>"
            </td>
        </tr>
        <tr>
            <td align="right">
                <input type="submit" value="修改">
                <input type="hidden" name="id" value="<?php echo $info['id'];?>">
            </td>
            <td align="left"><input type="reset" value="重置"></td>
        </tr>
    </table>
</form>
<script>
    function check(){
        let photoName = $("#photoName").val().trim();
        let photoDesc = $("#photoDesc").val().trim();
        let Pic = $("#Pic").val().trim();
        if(photoName == '' || photoDesc == ''){
            alert('名称、描述都必须要填写');
            return false;
        }
        return true;
    }
</script>
</body>
</html>