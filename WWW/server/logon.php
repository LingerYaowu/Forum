<?php

/**
 * 提交登录
 */
# 检查是否传入数据
if ($_GET['logon_email'] && $_GET['logon_password']) {
    require '../library/phpLibrary.php';
    $informations = dbSelect('dragon_users');
    $flag = true;
    for ($i = 0; $i < count($informations); $i++) {
        if ($_GET['logon_email'] == $informations[$i]['email']) {
            // 数据库中找到了用户
            $flag = false;
            // 判断密码是否正确
            if ($_GET['logon_password'] == $informations[$i]['password']) {
                // 向前端传回json类型的数组
                $userArr = [];
                array_push($userArr, $informations[$i]['email'], $informations[$i]['password'], $informations[$i]['nickname'], $informations[$i]['headimg'], $informations[$i]['birthday'], $informations[$i]['member']);
                print_r(json_encode($userArr));
            } else {
                echo 'false';
            }
        }
    }
    // 如果数据库中没有找到用户
    if ($flag) {
        echo '用户未注册';
    }
}
