<?php
# 打开session
session_start();
/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    $root = $_SERVER["HTTP_HOST"];
    header("location: http://$root/sign.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改个人信息</title>
    <!-- 引入css -->
    <link rel="stylesheet" href="library/cssLibrary.css">
    <link rel="stylesheet" href='style/setInformation.css'>
    <!-- 引入icon图片 -->
    <link rel="shortcut icon" href="images/favicon.ico"> 
</head>
<body>
    <div class="big">
        <form action="server/setinfo.php" method='post' enctype='multipart/form-data'>
            <h1>修改个人信息</h1>
            <div class='controls'>
                <label>昵称: </label>
                <div><input type="text" value='<?php echo $_SESSION['nickname'];?>' name='nickname' maxlength='10' required /></div>
            </div>
            <div class='controls'>
                <label>密码: </label>
                <div><input type="password" value='<?php echo $_SESSION['password'];?>' name='password' maxlength='8' required /></div>
            </div>
            <div class='controls'>
                <label>邮箱: </label>
                <div><input type="text" value='<?php echo $_SESSION['email'];?>' name='email' maxlength='10' required readonly /></div>
            </div>
            <div class='controls'>
                <label>生日: </label>
                <div><input type="date" value='<?php echo $_SESSION['birthday'];?>' name='birthday' maxlength='10' required /></div>
            </div>
            <div class='controls'>
                <label>头像: </label>
                <div class='headimgBox'>
                    <input type="file" value='<?php echo $_SESSION['heading'];?>' name='headimg' />
                </div>
            </div>
            <span class='waring'>注：由于技术原因，请选择长宽相同的图片当作头像，体验更佳</span>
            <div class="btns">
                <input type="button" value="← 取消" id='back'>
                <input type="submit" name='setSub' class='btn' value="提交">
            </div>
        </form>
    </div>
    <script>
        back.onclick=function(){
            location.replace('www.baidu.com');
        };
    </script>
</body>
</html>