<?php
# 开启SESSION
session_start();
# 引入php类
require '../library/phpLibrary.php';

// 判断用户是否传入数据
if($_GET['postsid']) {
    # 给 用户表 posts 字段-1
    # 获取帖主
    $posts_user = dbSelSent('select * from dragon_posts where id='.$_GET['postsid'])[0]['email'];
    $update_users = dbUpdate('update dragon_users set posts=posts-1 where email="'.$posts_user.'"');
    # 删除 帖子表 内的信息
    $del_posts = dbUpdate('delete from dragon_posts where id = '.$_GET['postsid']);
    # 删除 收藏表 内所有包含该帖子的数据
    $del_collect = dbUpdate('delete from dragon_postscollect where postsid = '.$_GET['postsid']);
    # 删除 点赞表 内所有包含该帖子的数据
    $del_likes = dbUpdate('delete from dragon_postslike where postsid = '.$_GET['postsid']);
    # 删除 回复表 内所有包含帖子的回复
    $del_reply = dbUpdate('delete from dragon_reply where postid = '.$_GET['postsid']);
    # 删除 喜欢回复 表内所有包含该帖子的记录
    $del_replylike = dbUpdate('delete from dragon_replylike where postsid = '.$_GET['postsid']);

    if($del_posts && $del_collect && $del_likes && $del_reply && $del_replylike && $update_users) {
        echo 'true';
    } else {echo 'false';}
} else {echo 'false';}
?>