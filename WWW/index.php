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

# 获取帖子表
$posts = dbSelSent('select * from dragon_posts order by releasetime desc');
$user = dbSelSent('select * from dragon_users where email="'.$_SESSION['email'].'"')[0];
$posts_num = count($posts);

# 获取帖子ID
$postsIds = [];
for($i = 0;$i < count($posts);$i++) {
    $id = $posts[$i]['id'];
    $title = $posts[$i]['title'];
    $arr = [$id,$title];
    array_push($postsIds,$arr);
}

/* 获取点赞次数 */
for($i = 0;$i < count($postsIds);$i++) {
    $likes = count(dbSelSent('select * from dragon_postslike where postsid='.$postsIds[$i][0]));
    array_push($postsIds[$i],$likes);
}

/* 排序 */
for($i = 0;$i < count($postsIds)-1;$i++) {
    for($j = count($postsIds)-1;$j>$i;$j--) {
        if($postsIds[$j][2] > $postsIds[$j-1][2]) {
            $test = $postsIds[$j-1];
            $postsIds[$j-1] = $postsIds[$j];
            $postsIds[$j] = $test;
        }
    }
}

// 获取贪吃蛇排行榜前十名
$snake_list = dbSelSent('select * from dragon_snake order by score desc limit 15');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon bbs</title>
    <!-- 引入js library -->
    <script src="library/jsLibrary.js"></script>
    <!-- 引入css library -->
    <link rel='stylesheet' href='library/cssLibrary.css'>
    <!-- 引入顶部nav css -->
    <link rel="stylesheet" href="style/top_nav.css">
    <!-- 引入本页面的样式 -->
    <link rel="stylesheet" href="style/index.css">
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

        <!-- 搜索框 与 热门 -->
        <div class="searchAndHot">
            <div class="search">
                <form method="get" action='search.php' target='_blank'>
                    <input type="search" name='search'  maxlength='20' required >
                    <button type="submit" class='iconfont dragon-sousuo'>搜索</button>
                </form>
            </div>
            <div class="hot">
                <p>热度榜：</p>
                <div>
                    <?php
                        for($i = 0;$i < 3;$i++) {
                            $id = $postsIds[$i][0];
                            $title = $postsIds[$i][1];
                            if($i == 0) {
                                echo "<span class='one'><a href='seeposts.php?resouse=$id' target='_blank'>$title</a></span>";
                            } else {echo "<span><a href='seeposts.php?resouse=$id' target='_blank'>$title</a></span>";}
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- 功能按钮集 -->
        <div class="funBtns">
            <div class="publish">
                <a href="javascript:;">发布帖子</a>
            </div>
            <div class="release">
                <a href="javascript:;">发布资源</a>
            </div>
            <div class="publish">
                <a href="javascript:;">功能暫無</a>
            </div>
            <div class="publish">
                <a href="javascript:;">功能暫無</a>
            </div>
            <div class="publish">
                <a href="javascript:;">功能暫無</a>
            </div>
            <div class="publish">
                <a href="javascript:;">功能暫無</a>
            </div>
        </div>

        <!-- banner背景 -->
        <div class="ban">
            <div>
            </div>
        </div>

        <!-- 帖子 -->
        <div class="postsContent">
            <div class='sort'>
                <p><?php echo $posts_num;?> 条帖子</p>
                <select>
                    <option selected>按时间排序</option>
                    <option>按点赞数排序</option>
                </select>
            </div>
            <div class='posts_cont'>
                <?php
                if($posts_num == 0) {
                    echo '<div class="no">没人发布帖子~</div>';
                } else {
                    for ($i = 0; $i < count($posts); $i++) {
                        # 将帖子的信息赋值给变量
                        $id = $posts[$i]['id'];
                        $email = $posts[$i]['email'];
                        $username = dbSelSent("select * from dragon_users where email='$email'")[0]['nickname'];
                        $title = $posts[$i]['title'];
                        $releaseTime = $posts[$i]['releasetime'];
                        $likepost = count(dbSelSent('select * from dragon_postslike where postsid='.$id));
                        $collectpost = count(dbSelSent('select * from dragon_postscollect where postsid='.$id));
                        $replypost = count(dbSelSent('select * from dragon_reply where postid='.$id));
                        echo "<a href='http://$root/seeposts.php?resouse=$id' target=_blank>
                        <div class='posts'>
                        <div class='post_headimg'>
                        <img src='informations/$email/images/headimg.jpg' >
                        </div>
                        <div class='cont'>
                        <div class='title'>$title</div>
                        <div>
                        <div class='data_name'>
                        <span class='name'>$username</span>
                        <span class='data'>$releaseTime</span>
                        </div>
                        <div>
                        <span class='iconfont dragon-xihuan1'>$likepost</span>
                        <span class='iconfont dragon-shoucangfill'>$collectpost</span>
                        <span class='iconfont dragon-huifu'>$replypost</span>
                        </div>
                        </div>
                        </div>
                        </div>
                        </a>";
                    }
                }
                ?>
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

        <!-- 发布帖子 -->
        <div class="publishform" style='display:none;'>
            <form method="get">
                <div class="close"><span class='iconfont dragon-guanbi'></span></div>
                <p><span class='iconfont dragon-tiezi'></span> 发布帖子</p>
                <div class='title'>
                    <label>标题: </label>
                    <div><input type="text" maxlength='20' required /></div>
                </div>
                <div class="content">
                    <label>内容：</label>
                    <textarea value='' maxlength="200"></textarea>
                </div>
                <div>
                    <button type="submit">发布</button>
                </div>
            </form>
        </div>

        <!-- 游戏排行榜 -->
        <div class="game_list">
            <div class="game_type">
                <div class="replaceBtn"><span class='iconfont dragon-xiangzuo'></span></div>
                <div class="replaceBtn"><span class='iconfont dragon-xiangyou'></span></div>
                <div class='select'>贪吃蛇</div>
                <div>飞机大战</div>
                <div>五子棋</div>
            </div>
            <div class="list_content">
                <div class='select'>
                    <div class="tit">
                        榜单
                    </div>
                    <?php
                        for($i = 0;$i < count($snake_list);$i++) {
                            $o = $i+1;
                            $snake_user = dbSelSent('select * from dragon_users where email="'.$snake_list[$i]['email'].'"')[0];
                            $e = $snake_list[$i]['email'];
                            $h = $snake_user['headimg'];
                            $u = $snake_user['nickname'];
                            $sc = $snake_list[$i]['score'];
                            $ti = $snake_list[$i]['times'];
                            echo "<div class='lis'>
                                <p class='order'>$o</p>
                                <div><div><img src='$h' ></div></div>
                                <p><a href='oneself.php?email=$e' target='_BLANK'>$u</a></p>
                                <p>$sc</p>
                                <p>$ti</p>
                            </div>";
                        }
                    ?>
                </div>
                <div>宋家乐</div>
                <div>大哥傻逼</div>
            </div>
        </div>

        <!-- 资源分享 -->
        <div class="shareResource">
            <div class="tit">资源分享</div>
            <div class="resCon">
                <div class='resNav'>
                    <ul>
                        <li class='select'>安卓</li>
                        <li>软件</li>
                        <li>安装包</li>
                        <li>压缩包</li>
                    </ul>
                </div>
                <div class='resources'>
                    <div class='select'>
                        <ul>
                            <?php
                                $path = 'resource/安卓';
                                if(is_dir($path)) {
                                    $resdir = scandir($path);
                                    for($i = 0;$i < count($resdir);$i++) {
                                        if($resdir[$i] != '.' && $resdir[$i] != '..' && !is_dir($resdir[$i])) {
                                            echo '<li>
                                                <a href="'.$path.'/'.$resdir[$i].'">'.$resdir[$i].'</a>
                                                <span>3033-13-32 12:4:30</span>
                                            </li>';
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <?php
                                $path = 'resource/软件';
                                if(is_dir($path)) {
                                    $resdir = scandir($path);
                                    for($i = 0;$i < count($resdir);$i++) {
                                        if($resdir[$i] != '.' && $resdir[$i] != '..' && !is_dir($resdir[$i])) {
                                            echo '<li>
                                                <a href="'.$path.'/'.$resdir[$i].'">'.$resdir[$i].'</a>
                                                <span>3033-13-32 12:4:34</span>
                                            </li>';
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <?php
                                $path = 'resource/安装包';
                                if(is_dir($path)) {
                                    $resdir = scandir($path);
                                    for($i = 0;$i < count($resdir);$i++) {
                                        if($resdir[$i] != '.' && $resdir[$i] != '..' && !is_dir($resdir[$i])) {
                                            echo '<li>
                                                <a href="'.$path.'/'.$resdir[$i].'">'.$resdir[$i].'</a>
                                                <span>3033-13-32 12:4:32</span>
                                            </li>';
                                        }
                                    }
                                }
                            ?>                            
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <?php
                                $path = 'resource/压缩包';
                                if(is_dir($path)) {
                                    $resdir = scandir($path);
                                    for($i = 0;$i < count($resdir);$i++) {
                                        if($resdir[$i] != '.' && $resdir[$i] != '..' && !is_dir($resdir[$i])) {
                                            echo '<li>
                                                <a href="'.$path.'/'.$resdir[$i].'">'.$resdir[$i].'</a>
                                                <span>3033-13-32 12:4:35</span>
                                            </li>';
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 发布资源release recource -->
        <div class="relrec" style='display:none;'>
            <div class="relcon">
                <div class="close"><span class='iconfont dragon-guanbi'></span></div>
                <p class='tit'><span class='iconfont dragon-tiezi'></span> 发布资源</p>
                <form method="post" target='_blank' action='server/pubsofe.php' enctype='multipart/form-data'>
                    <div>
                        <label>软件名：</label>
                        <input type="text" name="title" maxlength='40' required autocomplete='off'>
                    </div>
                    <div>
                        <label>类型：</label>
                        <div>
                            <label>
                                <input type="radio" name="type" value='安卓' checked>
                                <span>安卓</span>
                            </label>
                            <label>
                                <input type="radio" name="type" value='软件'>
                                <span>软件</span>
                            </label>
                            <label>
                                <input type="radio" name="type" value='安装包'>
                                <span>安装包</span>
                            </label>
                            <label>
                                <input type="radio" name="type" value='压缩包'>
                                <span>压缩包</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label>软件：</label>
                        <input type="file" name="software" required>
                    </div>
                    <div>
                        <input type="submit" name="subsofe" value='发布'>
                    </div>
                </form>
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
    <!-- 获取用户 -->
    <script>
        var user = [];
        user.push('<?php echo $_SESSION['email']; ?>');
        user.push('<?php echo $_SESSION['nickname']; ?>');
    </script>
    <!-- 引入顶部nav的js文件 -->
    <script src='style/top_nav.js'></script>
    <!-- 引入本页面js -->
    <script src="style/index.js"></script>
</body>

</html>