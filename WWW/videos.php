<?php
# 打开 session 会话
session_start();
# 引入php类
require "library/phpLibrary.php";

$root = $_SERVER["HTTP_HOST"];

/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    header("location: http://$root/sign.php");
}

$user = dbSelSent('select * from dragon_users where email="'.$_SESSION['email'].'"')[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos</title>
    <!-- 引入js library -->
    <script src="library/jsLibrary.js"></script>
    <!-- 引入css library -->
    <link rel='stylesheet' href='library/cssLibrary.css'>
    <!-- 引入顶部nav css -->
    <link rel="stylesheet" href="style/top_nav.css">
    <!-- 本页面的css -->
    <link href='style/videos.css' rel='stylesheet' />
    <!-- 引入字体图标 -->
    <link rel="stylesheet" href="iconfont/iconfont.css">
    <!-- 引入icon图片 -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- 引入 查看图片 css -->
    <link rel="stylesheet" href="style/seeImg.css">
</head>
<body>
    <div class="big">
        <!-- 顶部导航条 -->
        <div class="top_nav">
            <!-- logo -->
            <p class="logo"><a href="<?php echo 'http://'.$root; ?>/index.php" class='ordinary'>Dragon_BBS</a></p>
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
                    <a href="oneself.php?email=<?php echo $user['email'];?>" target='_blank' class='ordinary'>查看个人页面</a>
                </li>
                <li>
                    <a href="userManage.php" target='_blank'  class='ordinary'>用户管理</a>
                </li>
            </ul>
            <!-- 用户登录信息 -->
            <div class="user">
                <div>
                    <div class='headimg'>
                        <!-- 如果用户是会员则应该有个会员标 -->
                        <?php
                        if ($user['member'] == '1') {
                            echo '<img src=' . $user['headimg'] . ' title="查看个人信息" class="vipimg">';
                            echo '<span class="vip iconfont dragon-vip"></span>';
                        } else {
                            echo '<img src="' . $user['headimg'] . '" title="查看个人信息">';
                        }
                        ?>
                    </div>
                    <p><?php print_r($user['nickname']); ?></p>
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
                            <input type="text" value='<?php echo $user['nickname']; ?>' readonly />
                        </li>
                        <li>
                            <label>密码：</label>
                            <input type="password" value='<?php echo $user['password']; ?>' readonly />
                        </li>
                        <li>
                            <label>邮箱：</label>
                            <input type="text" value='<?php echo $user['email']; ?>' readonly />
                        </li>
                        <li>
                            <label>发帖：</label>
                            <a href='oneself.php?email=<?php echo $user['email'];?>' target="_blank">
                                <input type="text" value='<?php echo $user['posts']; ?>' readonly title='查看自己发的帖' />
                            </a>
                        </li>
                        <li>
                            <label>生日：</label>
                            <input type="text" value='<?php if ($user['birthday'] != 'null') echo $user['birthday'];
                                                        else echo '还没设置~'; ?>' readonly />
                        </li>
                        <li>
                            <label>会员：</label>
                            <input type="text" value='<?php if ($user['member'] == '1') echo '会员权限';
                                                        else echo '还不是会员~'; ?>' readonly />
                        </li>
                    </ul>
                </div>
                <div class="update">
                    <a href='http://<?php echo $_SERVER["HTTP_HOST"]; ?>/setInformation.php' class='ordinary' target='_blank'>修改个人信息+</a>
                </div>
            </div>
        </div>

        <!-- 查看图片 -->
        <div class="seeImg" style='display: none;'>
            <p><span class='iconfont dragon-guanbi'></span></p>
            <img src="" alt='请选择图片'>
        </div>

        <!-- 轮播图 -->
        <div class="rotation">
            <div class="left">
                <a href="javascript:;">
                    <span class='iconfont dragon-xiangzuo'></span>
                </a>
            </div>
            <div class="rota">
                <div class='rotacenter' style='transform: rotateX(-5deg) rotateY(0deg);'>
                    
                    <div class='rotademo01'></div>
                    <div class='rotademo01'>
                        <img src="images/rotaimgs/001.png">
                    </div>

                    <div class='rotademo02'></div>
                    <div class='rotademo02'>
                        <img src="images/rotaimgs/002.png">
                    </div>

                    <div class='rotademo03'></div>
                    <div class='rotademo03'>
                        <img src="images/rotaimgs/003.png">
                    </div>

                    <div class='rotademo04'></div>
                    <div class='rotademo04'>
                        <img src="images/rotaimgs/004.png">
                    </div>

                    <div class='rotademo05'></div>
                    <div class='rotademo05'>
                        <img src="images/rotaimgs/005.png">
                    </div>

                    <div class='rotademo06'></div>
                    <div class='rotademo06'>
                        <img src="images/rotaimgs/006.png">
                    </div>

                </div>
            </div>
            <div class="right">
                <a href="javascript:;">
                    <span class='iconfont dragon-xiangyou'></span>
                </a>
            </div>
        </div>
    </div>
    <!-- 引入查看图片js -->
    <script src="style/seeImg.js"></script>
    <script>
        var user = [];
        user.push('<?php echo $_SESSION['email']; ?>');
        user.push('<?php echo $_SESSION['nickname']; ?>');
    </script>
    <!-- 引入顶部nav的js文件 -->
    <script src='style/top_nav.js'></script>
    <!-- 引入本页面的js文件 -->
    <script src="style/videos.js"></script>
</body>
</html>