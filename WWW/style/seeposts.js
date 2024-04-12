/* 获取[喜欢]按钮 */
var likebtn = getElement('.landlord > .postcontent > div > div:nth-of-type(2) > a:nth-of-type(1) > span')[0];
/* 获取哦[喜欢]按钮的a标记 */
var like_a = getElement('.landlord > .postcontent > div > div:nth-of-type(2) > a:nth-of-type(1)')[0];
/* 给[喜欢]按钮添加功能 */
likebtn.onclick = function(){
    var like_cls = like_a.className;
    if(like_cls == 'like1') {
        var url = 'server/likes.php?operateType=like&id='+resouseId;
        ajaxRequest('get',url,function(data){
            if(data == 'false') {
                alert('操作失败');
            } else {
                like = 'like2';
                like_a.className = like;
            }
        });
    } else {
        var url = 'server/likes.php?operateType=nolike&id='+resouseId;
        ajaxRequest('get',url,function(data){
            if(data == 'false') {
                alert('操作失败');
            } else {
                like = 'like1';
                like_a.className = like;
            }
        });
    }
};

/* 获取[收藏]按钮 */
var collectbtn = getElement('.landlord > .postcontent > div > div:nth-of-type(2) > a:nth-of-type(2) > span')[0];
/* 获取哦[收藏]按钮的a标记 */
var collect_a = getElement('.landlord > .postcontent > div > div:nth-of-type(2) > a:nth-of-type(2)')[0];
/* 给[收藏]按钮添加功能 */
var collect = collect_a.className;
collectbtn.onclick = function(){
    if(collect == 'collect1') {
        var url = 'server/likes.php?operateType=collect&id='+resouseId;
        ajaxRequest('get',url,function(data){
            if(data == 'false') {
                alert('操作失败');
            } else {
                collect = 'collect2';
                collect_a.className = collect;
            }
        });
    } else {
        var url = 'server/likes.php?operateType=nocollect&id='+resouseId;
        ajaxRequest('get',url,function(data){
            if(data == 'false') {
                alert('操作失败');
            } else {
                collect = 'collect1';
                collect_a.className = collect;
            }
        });
    }
};

/* 获取回复框 */
var startreply = getElement('.startreply')[0];
var replykuang = getElement('.startreply > textarea')[0];
/* 提交回复内容 */
startreply.onsubmit = function(){
    /* 获取回复内容 */
    var replycontent = getElement('.startreply > textarea')[0].value;
    var url = 'server/reply.php?id='+resouseId+'&content='+replycontent;
    ajaxRequest('get',url,function(data){
        console.log(data);
        if(data != 'true') {
            alert('操作失败！');
        } else {
            alert('回复成功！');
            location.reload();
        }
    });
    return false;
};

/* 打开回复框 */
// 获取回复按钮
var replyBtn = getElement('.landlord > .postcontent > div > div:nth-of-type(2) > a:nth-of-type(3)')[0];
replyBtn.onclick = function(){
    so_hd(startreply,'show');
    replykuang.select();
};

/* 关闭回复框 */
var closeReply = getElement('.startreply > .close')[0];
closeReply.onclick = function(){
    so_hd(startreply,'hide');
};


/* 获取删除按钮(删除帖子) */
var delBtn = getElement('.landlord > .postcontent > div > div:nth-of-type(2) > a:nth-of-type(5)')[0];
if(delBtn) {
    delBtn.onclick = function(){
        var url = 'server/delPosts.php?postsid='+resouseId;
        ajaxRequest('get',url,function(data){
            if(data == 'true') {
                alert('删除成功！');
                location.reload();
            } else {
                alert('操作时出现错误！');
            }
        });
    };
}

var like = 'iconfont dragon-xihuan1 colRed';
var nolike = 'iconfont dragon-xihuan1';
/* 获取[喜欢回复信息]按钮 */
var likeReply = getElement('.reply > .reply_content > .body .date_name > div span:nth-of-type(1)');
for(var i = 0; i < likeReply.length;i++) {
    likeReply[i].onclick = function(){
        // 获取此按钮的类
        var cls = this.className;
        if(cls.indexOf('colRed') < 0) {
            // 没点赞呢
            var replyid = this.id;
            var url = 'server/reply_likes.php?replyid='+replyid+'&postsid='+resouseId+'&type=add';
            var th = this;
            ajaxRequest('get',url,function(data){
                if(data != 'false') {
                    th.className = like;
                    th.innerHTML = ' '+data;
                } else {
                    alert('操作失败！');
                }
            });
        } else {
            // 已经点过赞了
            var replyid = this.id;
            var url = 'server/reply_likes.php?replyid='+replyid+'&postsid='+resouseId+'&type=del';
            var th = this;
            ajaxRequest('get',url,function(data){
                if(data != 'false') {
                    th.className = nolike;
                    th.innerHTML = ' '+data;
                } else {
                    alert('操作失败！');
                }
            });
        }
    };
}

/* 获取[删除回复信息]按钮 */
var removeReplybtn = getElement('.reply > .reply_content > .body .date_name > div span:nth-of-type(2)');
for(var i = 0;i < removeReplybtn.length;i++) {
    removeReplybtn[i].onclick = function(){
        ajaxRequest('get',url,function(data){
            
        });
    };
}