<?php
# 开启session会话
session_start();
# 引入php类
require '../library/phpLibrary.php';
switch($_GET['type']) {
    case 'setSession':
        # 设置session
        $_SESSION[$_GET['k']] = $_GET['v'];
    break;
    case 'destorySession':
        # 更新用户状态
        dbUpdate('update dragon_users set state=0 where email="'.$_SESSION['email'].'"');
        # 销毁session
        session_destroy();
    break;
    case 'getSession':
        # 获取session
        print_r($_SESSION[$_GET['k']]);
    break;
    default:
        var_dump(true);
}
?>