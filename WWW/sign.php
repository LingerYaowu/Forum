<?php
# 打开 session 会话
session_start();
# 判断用户是否登录
if(isset($_SESSION['email'])) {
    header('location: ./index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon BBS</title>
    <!-- 引入css类库 -->
    <link rel='stylesheet' href='library/cssLibrary.css'>
    <!-- 引入javascript类库 -->
    <script src="library/jsLibrary.js"></script>
    <link rel="stylesheet" href="style/sign.css">
    <!-- 引入icon图片 -->
    <link rel="shortcut icon" href="images/favicon.ico"> 
</head>
<body>
    <div class="forms">
        <!-- 登录表单 -->
        <form method='get'>
            <p class='title'>登录</p>
            <div class="cons">
                <div class='controls'>
                    <label>邮箱: </label>
                    <div><input type="email" name='logon_email' required maxlength='25' placeholder='123abc@126.com' /></div>
                </div>
                <div class='controls'>
                    <label>密码: </label>
                    <div><input type="password" name='logon_password' maxlength='8' required /></div>
                </div>
                <div class='controls'>
                    <label>验证码: </label>
                    <div class="logonCode">
                        <input type="text" name='logon_code' maxlength='4' required />
                        <div></div>
                    </div>
                </div>
                <span class='reminder'>温馨提示: 验证码的组成是前两位小写英文,后两位数字,请注意填写</span>
                <input type='submit' value='登录' class='btn btn_white'>
            </div>
            <div class='links'>
                <button type='button' class='retrieve btn btn_link'>找回密码+</button>
                <button type='button' class='goSign btn btn_link'>去注册+</button>
            </div>
        </form>
        <!-- 注册表单 -->
        <form method='get' style='display: none;'>
            <p class='title'>注册</p>
            <div class="cons">
                <div class='controls'>
                    <label>邮箱: </label>
                    <div>
                        <input type="email" name='sign_email' required maxlength='30' placeholder='123abc@126.com' />
                        <span class='email_repeat'></span>
                    </div>
                </div>
                <div class='controls'>
                    <label>密码: </label>
                    <div><input type="password" name='sign_password' maxlength='8' required /></div>
                </div>
                <div class='controls signCode'>
                    <label>验证码: </label>
                    <div><input type="text" name='sign_code' disabled/></div>
                    <button type='button' class='sendCode'>发送<span class='countdown'></span></button>
                </div>
                <input type='submit' value='注册' class='btn btn_white'>
            </div>
            <div class='links'>
                <button type='button' name='sign_submit' class='goLogon btn btn_link'>去登录+</button>
            </div>
        </form>

    </div>

    <script src="style/sign.js"></script>
</body>
</html>