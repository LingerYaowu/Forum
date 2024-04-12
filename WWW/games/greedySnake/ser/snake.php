<?php
// 开启session
session_start();

# 判断用户是否提交分数
if($_GET['score']) {
    # 引入php类
    require '../../../library/phpLibrary.php';

    $email = $_SESSION['email'];
    $score = $_GET['score'];
    $time = date('Y-m-d  H:i:s');
    $bool = dbAdd("insert into dragon_snake values('$email',$score,'$time')");
    if($bool) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo $_GET;
}
?>