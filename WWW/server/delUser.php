<?php
# 引入php类
require '../library/phpLibrary.php';

// 判断是否传入数据
if($_GET['user_email']) {
    $userEmail = $_GET['user_email'];
    $bool = dbUpdate("delete from dragon_users where email='$userEmail'");
    if($bool) {
        print_r('true');
    } else {
        print_r('false');
    }
} else {print_r('false');}
?>