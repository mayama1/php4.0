<?php
session_start();
session_destroy();
header("history.back();");
echo ("您已注销账号");