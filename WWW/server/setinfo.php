<?php
# 打开session
session_start();
# 处理用户提交的修改个人信息表单
if($_POST['setSub']) {
    # 引入php类
    require '../library/phpLibrary.php';
    // 获取表单内的信息
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $headimg = $_FILES['headimg'];
    // 定义变量判断哪一步不成功
    $nickok = dbUpdate("update dragon_users set nickname='$nickname' where email='$email'");
    $passok = dbUpdate("update dragon_users set password='$password' where email='$email'");
    $birthok = dbUpdate("update dragon_users set birthday='$birthday' where email='$email'");
    $ok = ['nickname'=>$nickok,'password'=>$passok,'birthday'=>$birthok];
    // 定义flag，检测是否修改成功
    $flag = true;
    foreach($ok as $k=>$v) {
        if(!$v) {
            jssent("alert('在修改 $k 时出错')");
            $flag = false;
        }
    }
    # 修改头像
    // 判断是否提交了头像
    if(!($headimg['error'] > 0)) {
        // 判断是否是图片类型
        if(($headimg['type'] == 'image/jpeg') || ($headimg['type'] == 'image/png') || ($headimg['type'] == 'image/pjpeg')) {
            $bool = move_uploaded_file($headimg['tmp_name'],"../informations/$email/images/headimg.jpg");
            if(!$bool) {
                jssent('alert("头像上传失败");');
                $flag = false;
            }
        }
    }
    if($flag) jssent('alert("个人信息修改成功，请重新登录");'); else jssent('alert("部分信息修改成功，请重新登录");');
    # 清除session，让用户重新登录
    session_destroy();
    jssent('history.go(-1);');
}
?>