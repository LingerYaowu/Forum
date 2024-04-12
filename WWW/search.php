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
if (!$_GET['search']) {
    exit('请输入要查找的关键字或词！');
}

/* 用户 */
$user = dbSelSent('select * from dragon_users where email="' . $_SESSION['email'] . '"')[0];
/* 查询所有标题 */
$posts_title = dbSelSent('select * from dragon_posts order by releasetime desc');
# 存放查询结果的数组
$search_true = [];
for ($i = 0; $i < count($posts_title); $i++) {
    if (strstr($posts_title[$i]['title'], $_GET['search'])) {
        array_push($search_true, $posts_title[$i]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户搜索 -> (<?php echo $_GET['search'];?>)</title>
    <!-- 引入js library -->
    <script src="library/jsLibrary.js"></script>
    <!-- 引入css library -->
    <link rel='stylesheet' href='library/cssLibrary.css'>
    <!-- 引入字体图标 -->
    <link rel="stylesheet" href="iconfont/iconfont.css">
    <!-- 引入顶部nav css -->
    <link rel="stylesheet" href="style/top_nav.css">
    <!-- 引入ico图片 -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- 引入 查看图片 css -->
    <link rel="stylesheet" href="style/seeImg.css">
    <!-- 引入本页面css -->
    <link rel="stylesheet" href="style/search.css">
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
                    <a href="oneself.php?email=<?php echo $user['email']; ?>" target='_blank' class='ordinary'>查看个人页面</a>
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
                            <a href='oneself.php?email=<?php echo $user['email']; ?>' target="_blank">
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
                            <input type="text" value='<?php if ($user['member'] != 'null') echo '会员权限';
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
        <!-- 查找到的内容 -->
        <div class="searchcontent">
            <p>共 <?php echo count($search_true);?> 个搜索结果</p>
            <?php
            if(count($search_true) > 0) {
                for($i = 0;$i < count($search_true);$i++) {
                    $order = $i+1;
                    $postsid = $search_true[$i]['id'];
                    $title = $search_true[$i]['title'];
                    $email = $search_true[$i]['email'];
                    $releasetime = $search_true[$i]['releasetime'];
                    /* 获取帖主信息 */
                    $u = dbSelSent('select * from dragon_users where email="'.$email.'"')[0];
                    $nickname = $u['nickname'];
                    /* 获取点赞、收藏、回复数 */
                    $like = count(dbSelSent('select * from dragon_postslike where postsid='.$postsid));
                    $collect = count(dbSelSent('select * from dragon_postscollect where postsid='.$postsid));
                    $reply = count(dbSelSent('select * from dragon_reply where postid='.$postsid));
                    echo "<div>
                        <p class='order'>$order ：</p>
                        <div class='c'>
                            <a href='seeposts.php?resouse=$postsid'>
                                <div class='head'>
                                    <img src='informations/$email/images/headimg.jpg'>
                                </div>
                                <div class='desc'>
                                    <p>$title</p>
                                    <div>
                                        <p>$nickname $releasetime</p>
                                        <div>
                                            <span class='iconfont dragon-xihuan1'>$like</span>&nbsp;
                                            <span class='iconfont dragon-shoucangfill'>$collect</span>&nbsp;
                                            <span class='iconfont dragon-huifu'>$reply</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>";
                }
                
            } else {
                echo '<div class="noselect">没有相关的帖子~</div>';
            }
            ?>
        </div>
    </div>
    <!-- 引入查看图片js -->
    <script src="style/seeImg.js"></script>
    <!-- 引入顶部nav的js文件 -->
    <script src='style/top_nav.js'></script>
</body>

</html>