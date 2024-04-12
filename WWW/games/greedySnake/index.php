<?php
# 打开 session 会话
session_start();
# 引入php类
require "../../library/phpLibrary.php";

$root = $_SERVER["HTTP_HOST"];

/* 判断用户是否已登录 */
if (!isset($_SESSION['email'])) {
    # 未登录直接跳转到登录页面
    header("location: http://$root/sign.php");
}
# 获取登录用户的信息
$user = dbSelSent('select * from dragon_users where email="' . $_SESSION['email'] . '"')[0];

# 获取用户的贪吃蛇记录
$snake_record = dbSelSent('select * from dragon_snake where email="' . $user['email'] . '" order by times DESC');
# 获取用户最高纪录
$user_score_top = dbSelSent('select * from dragon_snake where email="' . $user['email'] . '" order by score DESC')[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon BBS 贪吃蛇</title>
    <link rel="stylesheet" href="style/snake.css">
    <!-- 引入css类 -->
    <link rel="stylesheet" href="../../library/cssLibrary.css">
    <!-- 引入js类 -->
    <script src="../../library/jsLibrary.js"></script>
</head>

<body>
    <div class="big">
        <div class="top_nav">
            <p class='title'><a href='http://<?php echo $root;?>'>Dragon BBS</a></p>
            <p>Score: <span>0</span></p>
        </div>
        <div class="map" style='display:none;'>
            <div class='snake'></div>
        </div>
        <div class="start">
            <p>Greedy snake</p>
            <p>new game</p>
        </div>
        <!-- 历史战绩 -->
        <div class="record">
            <p class="title">历史战绩</p>
            <div class="score_top">
                <?PHP
                    if(count($snake_record) > 0) {
                        $top_email = $user_score_top['email'];
                        $top_score = $user_score_top['score'];
                        $top_times = $user_score_top['times'];
                        echo "<p>最高纪录</p>
                        <div><img src='../../informations/$top_email/images/headimg.jpg'></div>
                        <div>分数：<span>$top_score</span></div>
                        <div>$top_times</div>";
                    } else {
                        echo '<div class="no">没有记录</div>';
                    }
                ?>
                
            </div>
            <div class="record_content">
                <?php
                if (count($snake_record) > 0) {
                    for ($i = 0; $i < count($snake_record); $i++) {
                        $o = $i + 1;
                        $u = dbSelSent('select * from dragon_users where email="' . $snake_record[$i]['email'] . '"')[0];
                        $hi = $u['headimg'];
                        $ni = $u['nickname'];
                        $s = $snake_record[$i]['score'];
                        $t = $snake_record[$i]['times'];
                        echo "<div>
                            <div>$o</div>
                                <div><img src='../../$hi' ></div>
                                <div>$ni</div>
                                <div>分数：<span>$s</span></div>
                                <div>$t</div>
                            </div>";
                    }
                } else {
                    echo '<div class="no">没有记录</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="style/snake.js"></script>
    <script>
        //点击按钮开始游戏
        var startGame = getElement('.start > p:nth-of-type(2)')[0];
        startGame.onclick = function() {
            start_j.style.display = 'none';
            map.style = '';
            snake = new Snake();
            snake.move();
            food.show();
        };
    </script>
</body>

</html>