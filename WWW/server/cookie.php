<?php
switch($_GET['type']){
    case 'setCookie':
        # 设置cookie
        setcookie($_GET['k'],$_GET['v'],0);
    break;
    case 'removeCookie':
        # 删除cookie
        setcookie($_GET['k'],'',time()-1);
    break;
    case 'getCookie':
        # 获取cookie
        print_r($_COOKIE[$_GET['k']]);
    break;
    default:
        var_dump(true);
}
?>