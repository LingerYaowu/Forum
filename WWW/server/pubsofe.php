<?php
# 打开 session 会话
session_start();
# 引入php
require '../library/phpLibrary.php';

$root = $_SERVER["HTTP_HOST"];
/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    header("location: http://$root/sign.php");
}

# 查看是否传入资源
$sofe = $_POST['title'];
$type = $_POST['type'];
$software = $_FILES['software'];
if($sofe && $type && $sofeware) {
    // move_uploaded_file($sofeware['tmp_name'],"http://$root/resource/$type/$sofe");
}
var_dump($software);
?>