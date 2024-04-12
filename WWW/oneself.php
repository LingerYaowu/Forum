<?php
# 打开 session 会话
session_start();
$root = $_SERVER["HTTP_HOST"];
/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    header("location: http://$root/sign.php");
}

/* 引入php */
require 'library/phpLibrary.php';

// 判断是否传入email
if((count(dbSelSent('select * from dragon_users where email="'.$_GET['email'].'"')) == 0)) {
    exit('没有这个用户！');
}

# 获取用户 [user]
$user = dbSelSent('select * from dragon_users where email="' . $_SESSION['email'] . '"')[0];

// 判断用户是否是自己
$nick = null;
$otherUser = null;
if($_GET['email'] == $_SESSION['email']) {
    $otherUser = $user;
    $nick = '我';
    # 获取用户收藏的帖子
    $postscollects = dbSelSent('select postsid from dragon_postscollect where email= "' . $user['email'] . '"');
    # 获取用户发布的帖子
    $postspublishs = dbSelSent('select * from dragon_posts where email= "' . $user['email'] . '"');
} else {
    $otherUser = dbSelSent('select * from dragon_users where email="' . $_GET['email'] . '"')[0];
    $nick = $otherUser['nickname'];
    # 获取用户收藏的帖子
    $postscollects = dbSelSent('select postsid from dragon_postscollect where email= "' . $otherUser['email'] . '"');
    # 获取用户发布的帖子
    $postspublishs = dbSelSent('select * from dragon_posts where email= "' . $otherUser['email'] . '"');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nick;?> 的个人主页</title>
    <!-- 将css类导入 -->
    <link rel="stylesheet" href="library/cssLibrary.css">
    <!-- 将js类导入 -->
    <script src="library/jsLibrary.js"></script>
    <!-- 将顶部导航条css导进来 -->
    <link rel="stylesheet" href="style/top_nav.css">
    <!-- 导入本页面css -->
    <link rel="stylesheet" href="style/oneself.css">
    <!-- 引入iconfont css -->
    <link rel="stylesheet" href="iconfont/iconfont.css">
    <!-- 引入ico图片 -->
    <link rel="shortcut icon" href="images/favicon.ico">
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
                    <a href="oneself.php?email=<?php echo $user['email'];?>" target='_blank' class='ordinary'>查看个人页面</a>
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
                        if ($user['member'] == '1') {
                            echo '<img src=' . $user['headimg'] . ' title="查看个人信息" class="vipimg">';
                            echo '<span class="vip iconfont dragon-vip"></span>';
                        } else {
                            echo '<img src=' . $user['headimg'] . ' title="查看个人信息">';
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
        <!-- 个人信息内容 -->
        <div class="information_content">
            <!-- 个人信息 -->
            <div class="oneself">
                <p class="title"><?php echo $nick;?> 基本信息：</p>
                <div class="oneself_content">
                    <ul>
                        <li>头像：<div class='seeheadimg'><img src='<?php echo $otherUser['headimg'];?>' title='查看头像'></div></li>
                        <li>昵称：<?php echo $otherUser['nickname'];?></li>
                        <li>邮箱：<?php echo $otherUser['email'];?></li>
                        <li>生日：<?php echo $otherUser['birthday'];?></li>
                        <li>发帖：<?php echo $otherUser['posts'];?></li>
                        <li>会员：<?php if($otherUser['member'] == 1){echo '会员权限';} else {echo '没有会员权限';}?></li>
                    </ul>
                </div>
            </div>
            <!-- 发布的 -->
            <div class="publish">
                <p class="title"><?php echo $nick;?> 发布的：</p>
                <div class="publish_content">
                    <?php
                    if(count($postspublishs) <= 0) {
                        echo '<div class="no">没有发布过~</div>';
                    } else {
                        for ($i = 0; $i < count($postspublishs); $i++) {
                            # 获取帖子的 点赞 收藏 回复数
                            $postsid = $postspublishs[$i]['id'];
                            $like = count(dbSelSent("select * from dragon_postslike where postsid=$postsid"));
                            $collect = count(dbSelSent("select * from dragon_postscollect where postsid=$postsid"));
                            $reply = count(dbSelSent("select * from dragon_reply where postid=$postsid"));
    
                            $email = $postspublishs[$i]['email'];
                            $title = $postspublishs[$i]['title'];
                            $content = $postspublishs[$i]['content'];
                            $releasetime = $postspublishs[$i]['releasetime'];
                            # 获取帖主的头像 和 昵称
                            $headimg = dbSelSent('select * from dragon_users where email="' . $email . '"')[0]['headimg'];
                            $nickname = dbSelSent('select * from dragon_users where email="' . $email . '"')[0]['nickname'];
                            echo "<div class='c'>
                                <a href='seeposts.php?resouse=$postsid'>
                                    <div class='head'>
                                        <div><img src='$headimg'></div>
                                    </div>
                                    <div class='desc'>
                                        <p>$title</p>
                                        <div>
                                            <p>$nickname $releasetime</p>
                                            <div>
                                                <span class='iconfont dragon-xihuan1'>$like</span>
                                                <span class='iconfont dragon-shoucangfill'>$collect</span>
                                                <span class='iconfont dragon-huifu'>$reply</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- 收藏 -->
            <div class="collect">
                <p class="title"><?php echo $nick;?> 收藏的：</p>
                <div class="collect_content">
                    <?php
                    if(count($postscollects) <= 0) {
                        echo '<div class="no">没有收藏过~</div>';
                    } else {
                        for ($i = 0; $i < count($postscollects); $i++) {
                            $p = dbSelSent('select * from dragon_posts where id=' . $postscollects[$i]['postsid']);
                            # 获取帖子的 点赞 收藏 回复数
                            $postsid = $p[0]['id'];
                            $like = count(dbSelSent("select * from dragon_postslike where postsid=$postsid"));
                            $collect = count(dbSelSent("select * from dragon_postscollect where postsid=$postsid"));
                            $reply = count(dbSelSent("select * from dragon_reply where postid=$postsid"));
    
                            $email = $p[0]['email'];
                            $title = $p[0]['title'];
                            $content = $p[0]['content'];
                            $releasetime = $p[0]['releasetime'];
                            # 获取帖主的头像 和 昵称
                            $headimg = dbSelSent('select * from dragon_users where email="' . $email . '"')[0]['headimg'];
                            $nickname = dbSelSent('select * from dragon_users where email="' . $email . '"')[0]['nickname'];
                            echo "<div class='c'>
                                <a href='seeposts.php?resouse=$postsid'>
                                    <div class='head'>
                                        <div><img src='$headimg'></div>
                                    </div>
                                    <div class='desc'>
                                        <p>$title</p>
                                        <div>
                                            <p>$nickname $releasetime</p>
                                            <div>
                                                <span class='iconfont dragon-xihuan1'>$like</span>
                                                <span class='iconfont dragon-shoucangfill'>$collect</span>
                                                <span class='iconfont dragon-huifu'>$reply</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- 功能按钮组 -->
        <div class="funbtns">
            <div class='oneself_btn selectBtn'><?php echo $nick;?>的基本信息</div>
            <div class='publish_btn'><?php echo $nick;?>发布的</div>
            <div class='collect_btn'><?php echo $nick;?>收藏的</div>
        </div>
        <!-- 查看图片 -->
        <div class="seeImg" style='display: none;'>
            <p><span class='iconfont dragon-guanbi'></span></p>
            <img src="" alt='请选择图片'>
        </div>
    </div>

    <!-- 引入查看图片js -->
    <script src="style/seeImg.js"></script>
    <!-- 将顶部导航条js导入 -->
    <script src="style/top_nav.js"></script>
    <!-- 引入本页面js -->
    <script src="style/oneself.js"></script>
    <!-- 定义可查看图片 -->
    <script>
        /* 个人信息内的头像查看 */
        var imgtrue = getElement('.seeheadimg img');
        seeImg(imgtrue);
    </script>
</body>

</html>