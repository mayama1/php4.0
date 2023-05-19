<?php
session_start();
//判断是否是管理员
if(!(isset($_SESSION['isAdmin'])&& $_SESSION['isAdmin'])){
    echo"<script>alert('请以管理员身份访问本页面!');location.href='login.php'</script>";
    exit;
}
?>