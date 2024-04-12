<?php
# 引入php类
require '../library/phpLibrary.php';
// 判断前端用户是否传入数据
if($_GET['email'] && $_GET['title'] && $_GET['content']) {
    /* 将帖子信息存入变量 */
    $email = $_GET['email'];
    $title = str_replace('"','“',str_replace("'",'‘',$_GET['title']));
    $content = str_replace('"','“',str_replace("'",'‘',$_GET['content']));
    $releasetime = date('Y-m-d  H:i:s');
    $bool = dbAdd("insert into dragon_posts values(0,'$email','$title','$content','$releasetime')");
    if($bool) {
        dbUpdate("update dragon_users set posts=posts+1 where email='$email'");
        print_r('true');
    } else {
        print_r('false');
    }
} else {
    print_r('jghj');
}
?>