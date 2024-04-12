<?php
# 开启SESSION
session_start();
// 查看用户是否传入数据
if($_GET['replyid'] && $_GET['postsid'] && $_GET['type']) {
    # 查看要操作的类型
    $type = $_GET['type'];
    # 引入php类
    require '../library/phpLibrary.php';
    $postsid = $_GET['postsid'];
    $replyid = $_GET['replyid'];
    $email = $_SESSION['email'];
    $releasetime = date('Y-m-d  H:i:s');
    switch($type) {
        case 'add':
            // 先查看用户是否已经喜欢过了
            $flag = true;
            $arr = dbSelect('dragon_replylike');
            for($i = 0;$i < count($arr);$i++) {
                if($arr[$i]['replyid'] == $replyid && $arr[$i]['email'] == $email) {
                    // 已经喜欢过了
                    echo 'false';
                    $flag = false;
                    break;
                }
            }
            if($flag) {
                // 存入数据库
                $bool = dbAdd("insert into dragon_replylike values($postsid,$replyid,'$email','$releasetime')");
                if($bool) {
                    echo count(dbSelSent('select * from dragon_replylike where replyid='.$replyid));
                } else {echo 'false';}
            }
        break;
        case 'del':
            // 从数据库中删除
            $bool = dbUpdate('delete from dragon_replylike where replyid='.$replyid.' and email="'.$_SESSION['email'].'"');
            if($bool) {
                echo count(dbSelSent('select * from dragon_replylike where replyid='.$replyid));
            } else {echo 'false';}
        break;
        default:
            echo 'false';
    }
} else {echo 'false';}
?>