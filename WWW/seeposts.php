<?php
# 打开 session 会话
session_start();
# 引入php
require 'library/phpLibrary.php';

$root = $_SERVER["HTTP_HOST"];
/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    header("location: http://$root/sign.php");
}

# 检查是否传入了数据
if (!$_GET['resouse']) {
    header("location: http://$root/index.php");
    jssent('<mark>滚蛋！没有这个资源</mark>');
}

$sent = 'select * from dragon_posts where id=' . $_GET['resouse'];
// 获取帖子信息
$posts = dbSelSent($sent);
// 用户个人信息
$user = null;
// 帖子回复信息
$replys = null;

if (!$posts) {
    header("location: http://$root/index.php");
    exit('没有此用户信息');
} else if ($posts == '请查看表是否存在或完好') {
    header("location: http://$root/index.php");
    exit('请查看表是否存在或完好');
} else {
    # 赋值给帖子信息
    $user = dbSelSent('select * from dragon_users where email="' . $posts[0]['email'] . '"');
    # 赋值给帖子回复信息
    $replys = dbSelSent('select * from dragon_reply where postid=' . $_GET['resouse']);
}
# 获取为本帖子点赞的人
$like_ren = dbSelSent('select email from dragon_postslike where postsid=' . $_GET['resouse']);
$flag = true;
$like_class = null;
for ($i = 0; $i < count($like_ren); $i++) {
    if ($like_ren[$i][0] == $_SESSION['email']) {
        $like_class =  'like2';
        $flag = false;
        break;
    }
}
if ($flag) {
    $like_class = 'like1';
}

# 获取收藏本贴的人
$collect_ren = dbSelSent('select email from dragon_postscollect where postsid=' . $_GET['resouse']);
$flag1 = true;
$collect_class = null;
for ($i = 0; $i < count($collect_ren); $i++) {
    if ($collect_ren[$i][0] == $_SESSION['email']) {
        $collect_class = 'collect2';
        $flag1 = false;
        break;
    }
}
if ($flag1) {
    $collect_class = 'collect1';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $user[0]['nickname']; ?> - <?php echo $posts[0]['title']; ?></title>
    <!-- 引入js library -->
    <script src="library/jsLibrary.js"></script>
    <!-- 引入字体图标 -->
    <link rel="stylesheet" href="iconfont/iconfont.css">
    <!-- 引入css library -->
    <link rel="stylesheet" href="library/cssLibrary.css">
    <!--  引入顶部导航条css -->
    <link rel="stylesheet" href="style/top_nav.css">
    <!-- 引入本页面css -->
    <link rel="stylesheet" href="style/seeposts.css">
    <!-- 引入icon图片 -->
    <link rel="shortcut icon" href="images/favicon.ico"> 
    <!-- 引入 查看图片 css -->
    <link rel="stylesheet" href="style/seeImg.css">
</head>

<body>
    <!-- 顶部导航条 -->
    <div class="top_nav">
        <!-- logo -->
        <p class="logo"><a href="http://localhost" class='ordinary'>Dragon_BBS</a></p>
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
                <a href="oneself.php?email=<?php echo $user[0]['email']; ?>" target='_blank' class='ordinary'>查看个人页面</a>
            </li>
            <li>
                <a href="userManage.php" target='_blank' class='ordinary'>用户管理</a>
            </li>
        </ul>
        <!-- 用户登录信息 -->
        <div class="user">
            <div>
                <div class='headimg'>
                    <!-- 如果用户是会员则应该有个会员标 -->
                    <?php
                    if ($_SESSION['member'] == '1') {
                        echo '<img src=' . $_SESSION['headimg'] . ' title="查看个人信息" class="vipimg">';
                        echo '<span class="vip iconfont dragon-vip"></span>';
                    } else {
                        echo '<img src=' . $_SESSION['headimg'] . ' title="查看个人信息">';
                    }
                    ?>
                </div>
                <p><?php print_r($_SESSION['nickname']); ?></p>
            </div>
            <div>
                <a href="javascript:;" class='quit ordinary'>
                    登出
                    <span class='iconfont dragon-a-icon_tuichudengchu'></span>
                </a>
            </div>
        </div>
    </div>
    <div class="big">
        <!-- 楼主帖子 -->
        <div class="landlord">
            <div class='landlordImg'>
                <div>
                    <img src="<?php echo $user[0]['headimg']; ?>">
                </div>
            </div>
            <div class='postcontent'>
                <p class='poststitle'><?php echo $posts[0]['title']; ?></p>
                <p class='postscontent'><?php echo $posts[0]['content']; ?></p>
                <div>
                    <div>
                        用户:
                        <?php
                        $un = $user[0]['nickname'];
                        $email = $user[0]['email'];
                        if ($user[0]['member'] == 1) {
                            echo "<a href='oneself.php?email=$email'><span class='landvip'>$un<span class='iconfont dragon-vip'></span></span></a>&nbsp;&nbsp;&nbsp;";
                        } else {
                            echo "<a href='oneself.php?email=$email'><span class='land'>$un</span></a>&nbsp;&nbsp;&nbsp;";
                        }
                        echo '时间: ' . $posts[0]['releasetime'];
                        ?>
                    </div>
                    <div>
                        <a href='javascript:;' class='<?php echo $like_class; ?>'><span class='iconfont dragon-xihuan1'>喜欢</span></a>
                        <a href='javascript:;' class='<?php echo $collect_class; ?>'><span class='iconfont dragon-shoucangfill'>收藏</span></a>
                        <a href='javascript:;' class='reply1'><span class='iconfont dragon-huifu'>回复</span></a>
                        <a href='javascript:;' class='jubao1'><span class='iconfont dragon-jubao'>举报</span></a>
                        <?php
                        // 判断浏览的人是否是帖主或者是管理员
                        if ($user[0]['email'] == $_SESSION['email'] || $_SESSION['member'] == '1') {
                            echo "<a href='javascript:;' class='del'><span class='iconfont dragon-shanchu'>删除</span></a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- 回复信息 -->
        <div class="reply">
            <p class='title'><?php echo count($replys); ?> 个回复</p>
            <?php
            for ($i = 0; $i < count($replys); $i++) {
                # 回复信息
                $replyid = $replys[$i]['replyid'];
                $email = $replys[$i]['email'];
                $username = $replys[$i]['username'];
                $releasetime = $replys[$i]['releasetime'];
                $content = $replys[$i]['content'];
                $content = $replys[$i]['content'];
                $content = $replys[$i]['content'];
                # 获取用户信息
                $reply_user = dbSelSent('select * from dragon_users where email="' . $email . '"')[0];
                $reply_user_headimg = $reply_user['headimg'];
                $reply_user_nickname = $reply_user['nickname'];
                echo "<div class='reply_content'>
                    <div class='head_img'>
                    <a href='oneself.php?email=$email'>
                    <img src='$reply_user_headimg'/>
                    </a>
                    </div>
                    <div class='body'>
                    <div class='title'>$reply_user_nickname</div>
                    <div class='content'>$content</div>
                    <div class='date_name'>
                    <span>时间：$releasetime</span>
                    <div>";
                $replylikes = dbSelSent('select * from dragon_replylike where replyid=' . $replyid);
                $replylikes_num = count($replylikes);
                $flag = true;
                if (count($replylikes) > 0) {
                    for ($j = 0; $j < count($replylikes); $j++) {
                        if ($replylikes[$j]['email'] == $_SESSION['email']) {
                            // 点赞了
                            echo "<span class='iconfont dragon-xihuan1 colRed' id=$replyid> $replylikes_num</span>";
                            $flag = false;
                            break;
                        }
                    }
                }
                if ($flag) {
                    echo "<span class='iconfont dragon-xihuan1' id=$replyid> $replylikes_num</span>";
                }
                // 判断浏览的人是否是帖主或管理员
                if ($user[0]['email'] == $_SESSION['email'] || $_SESSION['member'] == '1') {
                    echo "<span class='iconfont dragon-shanchu'>删除</span>";
                }
                echo "</div>
                    </div>
                    </div>
                    </div>";
            }
            ?>
        </div>
        <!-- 查看图片 -->
        <div class="seeImg" style='display: none;'>
            <p><span class='iconfont dragon-guanbi'></span></p>
            <img src="" alt='请选择图片'>
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
                        <input type="text" value='<?php echo $_SESSION['nickname']; ?>' readonly />
                    </li>
                    <li>
                        <label>密码：</label>
                        <input type="password" value='<?php echo $_SESSION['password']; ?>' readonly />
                    </li>
                    <li>
                        <label>邮箱：</label>
                        <input type="text" value='<?php echo $_SESSION['email']; ?>' readonly />
                    </li>
                    <li>
                        <label>发帖：</label>
                        <a href='oneself.php?email=<?php echo $user[0]['email']; ?>' target="_blank">
                            <input type="text" value='<?php echo $user[0]['posts']; ?>' readonly title='查看自己发的帖' />
                        </a>
                    </li>
                    <li>
                        <label>生日：</label>
                        <input type="text" value='<?php if ($_SESSION['birthday'] != 'null') echo $_SESSION['birthday'];
                                                    else echo '还没设置~'; ?>' readonly />
                    </li>
                    <li>
                        <label>会员：</label>
                        <input type="text" value='<?php if ($_SESSION['member'] != '1') echo '会员权限';
                                                    else echo '还不是会员~'; ?>' readonly />
                    </li>
                </ul>
            </div>
            <div class="update">
                <a href='http://<?php echo $_SERVER["HTTP_HOST"]; ?>/setInformation.php' class='ordinary' target='_blank'>修改个人信息+</a>
            </div>
        </div>
    </div>
    <!-- 回复框 -->
    <form method="get" class='startreply' style='display:none;'>
        <div class='close'><span class='iconfont dragon-guanbi'></span></div>
        <p class='title'>回复</p>
        <textarea require maxlength='150' checked></textarea>
        <button type='submit'>评论</button>
    </form>
    <!-- 引入查看图片js -->
    <script src="style/seeImg.js"></script>
    <!-- 查看楼主头像 -->
    <script>
        var loImg = getElement('.landlordImg > div > img');
        seeImg(loImg);
    </script>
    <!-- 获取帖子ID -->
    <script>
        var resouseId = '<?php echo $_GET['resouse']; ?>';
    </script>
    <!-- 引入导航条的js文件 -->
    <script src='style/top_nav.js'></script>
    <!-- 引入本页面的js文件 -->
    <script src="style/seeposts.js"></script>
</body>

</html>