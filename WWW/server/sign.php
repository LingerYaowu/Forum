<?php
include '../library/phpLibrary.php';
# 判断GET传没传用户信息
if($_GET['sign_email'] && $_GET['sign_password']) {
    // 将用户信息存入变量
    $email = $_GET['sign_email'];
    $password = $_GET['sign_password'];
    $id = randId(6,0);
    // 头像位置
    $headimg = "informations/$email/images/headimg.jpg";
    // 插入数据库
    $result = dbAdd("insert into dragon_users(email,password,nickname,headimg) values('$email','$password','$id','$headimg')");
    // 判断插入是否成功

    // 创建用户目录
    $dir = $_SERVER['DOCUMENT_ROOT']."/informations/$email";
    if($result) {
        mkdir($dir,0777,true);
        mkdir($dir.'/images',0777,true);
        copy($_SERVER['DOCUMENT_ROOT'].'/images/information/headimg.png',$_SERVER['DOCUMENT_ROOT']."/informations/$email/images/headimg.jpg");
        var_dump(true);
    } else {
        var_dump(false);
    }
}
?>