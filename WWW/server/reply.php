<?php
# 开启session
session_start();
# 引入php类
require '../library/phpLibrary.php';

# 判断用户是否传入数据
if($_GET['id'] && $_GET['content']) {
    $resouseId = $_GET['id'];
    $user_email = $_SESSION['email'];
    $releasetime = date('Y-m-d  H:i:s');
    $content = $_GET['content'];
    $bool = dbAdd("insert into dragon_reply values(0,$resouseId,'$user_email','$releasetime','$content',0,0)");
    if($bool) {
        print_r('true');
    } else {
        print_r('false');
    }
} else {
    print_r('false');
}
?>