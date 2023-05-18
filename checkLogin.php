<?php
session_start();
//判断是否登录
if(!(isset($_SESSION['loggedUsername'])&& $_SESSION['loggedUsername'])){
    echo"<script>alert('请先登录再访问本页面!');location.href='login.php'</script>";
    exit;
}
?>