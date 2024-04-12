<?php
# 开启session
session_start();
$root = $_SERVER["HTTP_HOST"];
/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    header("location: http://$root/sign.php");
}

# 引入php类
require 'library/phpLibrary.php';
// 获取个人信息
$my = dbSelSent('select * from dragon_users where email="' . $_SESSION['email'] . '"')[0];
/* 判断用户是否有会员权限 */
if (!($my['member'] == '1')) {
    exit('没有会员权限，请联系管理员');
}
// 获取所有用户信息
$users = dbSelect('dragon_users');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
    <!-- 引入js library -->
    <script src="library/jsLibrary.js"></script>
    <!-- 引入css library -->
    <link rel='stylesheet' href='library/cssLibrary.css'>
    <!-- 引入顶部nav css -->
    <link rel="stylesheet" href="style/top_nav.css">
    <!-- 引入icon图片 -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- 引入字体图标 -->
    <link rel="stylesheet" href="iconfont/iconfont.css">
    <!-- 引入本页面css -->
    <link rel="stylesheet" href="style/userManage.css">
    <!-- 引入 查看图片 css -->
    <link rel="stylesheet" href="style/seeImg.css">
</head>

<body>
    <div class="big">
        <!-- 顶部导航条 -->
        <div class="top_nav">
            <!-- logo -->
            <p class="logo"><a href="<?php echo 'http://' . $root; ?>/index.php" class='ordinary'>Dragon_BBS</a></p>
            <!-- 友情链接 -->
            <ul>
                <li>
                    <a href="videos.php" target='_blank' class='ordinary'>精品视频</a>
                </li>
                <li>
                    <a href="games/五子棋/index.html" target='_blank' class='ordinary'>五子棋</a>
                </li>
                <li>
                    <a href="games/greedySnake/index.php" target='_blank' class='ordinary'>贪吃蛇</a>
                </li>
                <li>
                    <a href="oneself.php?email=<?php echo $my['email'];?>" target='_blank' class='ordinary'>查看个人页面</a>
                </li>
                <li>
                    <a href="userManage.php" class='ordinary'>用户管理</a>
                </li>
            </ul>
            <!-- 用户登录信息 -->
            <div class="user">
                <div>
                    <div class='headimg'>
                        <!-- 如果用户是会员则应该有个会员标 -->
                        <?php
                        if ($my['member'] == '1') {
                            echo '<img src=' . $my['headimg'] . ' title="查看个人信息" class="vipimg">';
                            echo '<span class="vip iconfont dragon-vip"></span>';
                        } else {
                            echo '<img src=' . $my['headimg'] . ' title="查看个人信息">';
                        }
                        ?>
                    </div>
                    <p><?php print_r($my['nickname']); ?></p>
                </div>
                <div>
                    <a href="javascript:;" class='quit ordinary'>
                        登出
                        <span class='iconfont dragon-a-icon_tuichudengchu'></span>
                    </a>
                </div>
            </div>
        </div>
        <!-- 个人信息面板 -->
        <div class="informationBg" style='display:none;'>
            <div class="information">
                <div class="close">&times;</div>
                <div class="content">
                    <div>
                        <div class='headimg'>
                            <img src="<?php echo $_SESSION['headimg']; ?>" title='上传个人头像'>
                        </div>
                    </div>
                    <ul>
                        <li>
                            <label>昵称：</label>
                            <input type="text" value='<?php echo $my['nickname']; ?>' readonly />
                        </li>
                        <li>
                            <label>密码：</label>
                            <input type="password" value='<?php echo $my['password']; ?>' readonly />
                        </li>
                        <li>
                            <label>邮箱：</label>
                            <input type="text" value='<?php echo $my['email']; ?>' readonly />
                        </li>
                        <li>
                            <label>发帖：</label>
                            <a href='oneself.php?email=<?php echo $my['email']; ?>' target="_blank">
                                <input type="text" value='<?php echo $my['posts']; ?>' readonly title='查看自己发的帖' />
                            </a>
                        </li>
                        <li>
                            <label>生日：</label>
                            <input type="text" value='<?php if ($my['birthday'] != 'null') echo $my['birthday'];
                                                        else echo '还没设置~'; ?>' readonly />
                        </li>
                        <li>
                            <label>会员：</label>
                            <input type="text" value='<?php if ($my['member'] != 'null') echo '会员权限';
                                                        else echo '还不是会员~'; ?>' readonly />
                        </li>
                    </ul>
                </div>
                <div class="update">
                    <a href='http://<?php echo $_SERVER["HTTP_HOST"]; ?>/setInformation.php' class='ordinary' target='_blank'>修改个人信息+</a>
                </div>
            </div>
        </div>
        <!-- 用户 -->
        <div class="users">
            <div class="title">
                <p>序号</p>
                <p>头像</p>
                <p>昵称</p>
                <p>邮箱</p>
                <p>密码</p>
                <p>生日</p>
                <p>会员</p>
                <p>发帖</p>
                <p>选择</p>
            </div>
            <div class="content">
                <?php
                for ($i = 0; $i < count($users); $i++) {
                    $order = $i+1;
                    $headimg = $users[$i]['headimg'];
                    $nickname = $users[$i]['nickname'];
                    $email = $users[$i]['email'];
                    $password = $users[$i]['password'];
                    $birthday = $users[$i]['birthday'];
                    $member = $users[$i]['member']=='1'?'会员权限':'无会员权限';
                    $posts = $users[$i]['posts'];
                    echo "<div>
                        <p>$order</p>
                        <p><img src='$headimg' class='usershead'/></p>
                        <p>$nickname</p>
                        <p>$email</p>
                        <p>$password</p>
                        <p>$birthday</p>
                        <p>$member</p>
                        <p>$posts</p>
                        <p><input type='checkbox' name='sel'></p>
                    </div>";
                }
                ?>
            </div>
        </div>
        <!-- 查看图片 -->
        <div class="seeImg" style='display: none;'>
            <p><span class='iconfont dragon-guanbi'></span></p>
            <img src="" alt='请选择图片'>
        </div>
    </div>
    <!-- 引入查看图片js -->
    <script src="style/seeImg.js"></script>
    <script>
        // 查看用户们的头像
        var usersimg = getElement('.usershead');
        seeImg(usersimg);
    </script>
    <!-- 引入top_nav js -->
    <script src="style/top_nav.js"></script>
</body>

</html>