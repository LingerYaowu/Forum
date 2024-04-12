/* 获取发布帖子按钮 */
var publish = getElement('.funBtns > .publish')[0];
/* 获取发布帖子的背景 */
var publishformBg = getElement('.publishform')[0];
// 给按钮添加功能
publish.onclick = function () {
    so_hd(publishformBg, 'show');
};

// 添加关闭按钮功能
var close_publishform = getElement('.publishform > form > .close')[0];
// 添加功能
close_publishform.onclick = function () {
    so_hd(publishformBg, 'hide');
};

var publishform = getElement('.publishform > form')[0];
/* 一次只能发一个 */
var flag = true;
publishform.onsubmit = function () {
    if (flag) {
        // 获取用户填写的信息
        var email = user[0];
        var nickname = user[1];
        var title = getElement('.publishform  .title > div > input')[0].value;
        var content = getElement('.publishform  .content > textarea')[0].value;
        var url = 'server/publish.php?email=' + email + '&title=' + title + '&content=' + content;
        ajaxRequest('get', url, function (data) {
            if (data == 'true') {
                flag = false;
                alert('发布成功');
                location.reload();
            } else {
                alert('发布失败');
            }
        });
        return false;
    }
};

/* 切换榜单 */
// 获取向左、向右按钮
var game_left = getElement('.game_type > div.replaceBtn')[0];
var game_right = getElement('.game_type > div.replaceBtn')[1];
/* 获取标题集与内容集 */
var game_title = getElement('.game_type > div:not(.replaceBtn)');
var game_list_content = getElement('.list_content > div');
// 游戏目前选择的榜单
var select_list = 0;
// 定义清楚选择的样式
function clearSelect() {
    for(var i = 0;i < game_title.length;i++) {
        game_title[i].className = '';
        game_list_content[i].className = '';
    }
}
game_left.onclick = function(){
    clearSelect();
    if(select_list-1 < 0) {
        select_list = game_title.length-1;
    } else {select_list--;}
    game_title[select_list].className = 'select';
    game_list_content[select_list].className = 'select';
};
game_right.onclick = function(){
    clearSelect();
    if(select_list+1 > game_title.length-1) {
        select_list = 0;
    } else {select_list++;}
    game_title[select_list].className = 'select';
    game_list_content[select_list].className = 'select';
};

/*
    资源导航条
*/
//获取导航按钮
var resbtns = getElement('.shareResource > .resCon > .resNav ul li');
var resban = getElement('.shareResource > .resCon > .resources > div');
//定义 [选中状态的按钮取消状态] 函数
//定义 [选中状态的资源板块取消状态] 函数
function removeSel() {
    for(var i = 0;i < resbtns.length;i++) {
        resbtns[i].className = '';
    }
    for(var i = 0;i < resban.length;i++) {
        resban[i].className = '';
    }
}

//点击导航按钮后
for(let i = 0;i < resbtns.length;i++) {
    resbtns[i].onclick = function(){
        //取消所有按钮与板块的选中状态
        removeSel();
        //为点击的按钮添加选中样式
        this.className = 'select';
        //为对应的板块解开‘封印’
        resban[i].className = 'select';
    };
}

/* 发布资源 */
var release = getElement('.funBtns>.release')[0];
var relBan = getElement('.relrec')[0];
release.onclick = function(){
    so_hd(relBan,'show');
};
var closerel = getElement('.relrec > .relcon > .close span')[0];
closerel.onclick = function(){
    so_hd(relBan,'hide');
};
