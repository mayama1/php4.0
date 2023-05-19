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
    <title>投票后台管理</title>
    <style>
        h1{
            text-align: center;
        }
        h2{
            text-align: center;
            font-size: 16px;
        }
        h2 a{
            text-decoration: none;
        }
        .img{
            width: 100%;
            max-width: 150px;
        }
    </style>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script src="layer/layer.js"></script>
</head>
<body>
<h1>照片管理</h1>
<!--<h2><a href="index.php">返回首页</a>  <a href="admin.php">图片管理</a>-->
<!--    <a href="show.php">数据查看</a>   <a href="logout.php">注销 </a></h2>-->
<?php
include_once 'conn.php';
include_once 'page.php';
$sql="select count(1) as total from photo";
$result=mysqli_query($conn,$sql);
$info=mysqli_fetch_array($result);
$total=$info['total'];//得到记录总数
$perpage=4;//设置每页显示的数据多少
$page=$_GET['page']??1;//读取当前页码
paging($total,$perpage);//引用分页函数
$sql="select * from photo order by id desc";
$result=mysqli_query($conn,$sql);
?>
<table border="0" width="100%" align="center">
<!--    <tr>-->
<!--        <td>-->
<!--            <table align="center" width="100%" border="1" bordercolor="black" cellspacing="0" cellpadding="10">-->
<!--                <tr>-->
<!--                    <td align="center" width="8%">序号</td>-->
<!--                    <td align="center" width="20%">名称</td>-->
<!--                    <td align="center" width="39%">描述</td>-->
<!--                    <td align="center" width="10%">图片</td>-->
<!--                    <td align="center" width="8%">当前票数</td>-->
<!--                    <td align="center" width="15%">操作</td>-->
<!--                </tr>-->
<!--                --><?php
//                $i=($page-1)+$perpage+1;
//                while ($info=mysqli_fetch_array($result)){
//
//
//                    ?>
<!--                    <tr>-->
<!--                        <td align="center">--><?php //echo $i;?><!--</td>-->
<!--                        <td align="center">--><?php //echo $info['photoName'];?><!--</td>-->
<!--                        <td align="center">--><?php //echo $info['photoDesc'];?><!--</td>-->
<!--                        <td align="center"><img class="img" src="img/--><?php //echo $info['Pic'];?><!--"></td>-->
<!--                        <td align="center">--><?php //echo $info['photoNum'];?><!--</td>-->
<!--                        <td align="center">-->
<!--                            <a href="modifyPhoto.php?id=--><?php //echo $info['id'];?><!--">修改</a>-->
<!--                            <a href="javascript:del(--><?php //echo $info['id'];?><!--)">删除</a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    --><?php
//                    $i++;
//                }
//                ?>
<!--            </table>-->
<!--        </td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td align="right">-->
<!--            --><?php
//            echo $perpage;
//            ?>
<!--        </td>-->
<!--    </tr>-->
    <tr>
        <td>
            <h2>照片添加</h2>
            <form onsubmit="return check()" enctype="multipart/form-data" method="post" action="postAdd.php">
                <table width="70%" align="center" style="border-collapse: collapse;" border="1" bordercolor="gray" cellpadding="10" cellspacing="0" >
                    <tr>
                        <td align="right">照片名称</td>
                        <td align="left"><input name="photoName" id="photoName"></td>
                    </tr>
                    <tr>
                        <td align="right">照片描述</td>
                        <td align="left"><textarea name="photoDesc" id="photoDesc"></textarea></td>
                    </tr>
                    <tr>
                        <td align="right">图片</td>
                        <td align="left"><input type="file" id="Pic" name="Pic"></td>
                    </tr>
                    <tr>
                        <td align="right"><input type="submit" value="添加"></td>
                        <td align="left"><input type="reset" value="重置"></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
<script>
    function del(id){
        layer.confirm('确认删除该图片?',{icon:3,title:'提示'},function (index){
            location.href="delPhoto.php?id="+id;
        })
    }
    function check(){
        let photoName = $("#photoName").val().trim();
        let photoDesc = $("#photoDesc").val().trim();
        let Pic = $("#Pic").val().trim();
        if(photoName == '' || photoDesc == '' || Pic == ''){
            alert('照片名称、描述、图片都必须要填写');
            return false;
        }
        return true;
    }
</script>
</html>
