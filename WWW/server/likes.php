<?php
# 开启SESSION
session_start();
# 判断用户是否传入数据
if($_GET['operateType']) {
    # 引入php类
    require '../library/phpLibrary.php';
    # 判断用户的操作
    switch($_GET['operateType']) {
        case 'like':
            $id = $_GET['id'];
            $email = $_SESSION['email'];
            $releasetime = date('Y-m-d  H:i:s');
            // 先查看用户是否已经喜欢过了
            $flag = true;
            $arr = dbSelect('dragon_postslike');
            for($i = 0;$i < count($arr);$i++) {
                if($arr[$i]['postsid'] == $id && $arr[$i]['email'] == $email) {
                    echo 'false';
                    $flag = false;
                    break;
                }
            }
            if($flag) {
                $bool = dbSelSent("insert into dragon_postslike values($id,'$email','$releasetime')");
                if($bool) {
                    print_r('true');
                } else {
                    print_r('false');
                }
            }
        break;
        case 'nolike':
            $id = $_GET['id'];
            $email = $_SESSION['email'];
            $bool = dbSelSent("delete from dragon_postslike where email='$email' and postsid=$id");
            if($bool) {
                print_r('true');
            } else {
                print_r('false');
            }
        break;
        case 'collect':
            $id = $_GET['id'];
            $email = $_SESSION['email'];
            $releasetime = date('Y-m-d  H:i:s');
            // 查看用户是否已经收藏过了
            $flag = true;
            $arr = dbSelect('dragon_postscollect');
            for($i = 0;$i < count($arr);$i++) {
                if($arr[$i]['postsid'] == $id && $arr[$i]['email'] == $email) {
                    echo 'false';
                    $flag = false;
                    break;
                }
            }
            if($flag) {
                $bool = dbUpdate("insert into dragon_postscollect values($id,'$email','$releasetime')");
                if($bool) {
                    print_r('true');
                } else {
                    print_r('false');
                }
            }
        break;
        case 'nocollect':
            $id = $_GET['id'];
            $email = $_SESSION['email'];
            $bool = dbUpdate("delete from dragon_postscollect where email='$email'");
            if($bool) {
                print_r('true');
            } else {
                print_r('false');
            }
        break;
    }
}
?>