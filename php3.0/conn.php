<?php
//连接数据库
$conn=mysqli_connect("localhost","root","root","member");
if(!$conn){
    die("连接数据库服务器失败");
}
//设置字符集
mysqli_query($conn,"set names utf8 ");