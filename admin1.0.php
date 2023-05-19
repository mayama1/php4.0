<?php
include_once 'checkAdmin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台管理</title>
    <link rel="stylesheet" href="layui/css/layui.css">
</head>
<style>
    .img{
        width: 90%;
        max-width: 150px;
    }
</style>
<body>
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
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">后台管理</div>
        <!-- 头部区域（可配合layui 已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <!-- 移动端显示 -->
            <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
                <i class="layui-icon layui-icon-spread-left"></i>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide layui-show-md-inline-block">

            </li>
            <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-more-vertical"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item"><a href="index.php;">返回首页</a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;">图片管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="photoAdd.php;">添加图片</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="logout.php;">注销</a></li>
                <li class="layui-nav-item"><a href="show.php">数据查看</a></li>
            </ul>
        </div>
    </div>
    <!-- 内容主体区域 -->
    <div class="layui-body">
        <div style="padding: 15px;">
<!--            //内容主体区域。记得修改 layui.css 和 js 的路径-->
            <table border="0" width="100%" align="center">
                <tr>
                    <td>
                        <table align="center" width="100%" border="1" bordercolor="black" cellspacing="0" cellpadding="10">
                            <tr>
                                <td align="center" width="20%">序号</td>
                                <td align="center" width="8%">名称</td>
                                <td align="center" width="35%">描述</td>
                                <td align="center" width="14%">图片</td>
                                <td align="center" width="8%">当前票数</td>
                                <td align="center" width="15%">操作</td>
                            </tr>
                            <?php
                            $i=($page-1)+$perpage+1;
                            while ($info=mysqli_fetch_array($result)){


                                ?>
                                <tr>
                                    <td align="center"><?php echo $i;?></td>
                                    <td align="center"><?php echo $info['photoName'];?></td>
                                    <td align="center"><?php echo $info['photoDesc'];?></td>
                                    <td align="center"><img class="img" src="img/<?php echo $info['Pic'];?>"></td>
                                    <td align="center"><?php echo $info['photoNum'];?></td>
                                    <td align="center">
                                        <a href="modifyPhoto.php?id=<?php echo $info['id'];?>">修改</a>
                                        <a href="javascript:del(<?php echo $info['id'];?>)">删除</a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <?php
                        echo $perpage;
                        ?>
                    </td>
                </tr>
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
        </div>
    </div>

</div>
<script src="layui/layui.js"></script>
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
    //JS
    layui.use(['element', 'layer', 'util'], function(){
        var element = layui.element
            ,layer = layui.layer
            ,util = layui.util
            ,$ = layui.$;

        //头部事件
        util.event('lay-header-event', {
            //左侧菜单事件
            menuLeft: function(othis){
                layer.msg('展开左侧菜单的操作', {icon: 0});
            }
            ,menuRight: function(){
                layer.open({
                    type: 1
                    ,content: '<div style="padding: 15px;">处理右侧面板的操作</div>'
                    ,area: ['260px', '100%']
                    ,offset: 'rt' //右上角
                    ,anim: 5
                    ,shadeClose: true
                });
            }
        });

    });
</script>
</body>
</html>