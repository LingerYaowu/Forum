/**
 * 登出
 */
function quit() {
    ajaxRequest('get', 'server/session.php?type=destorySession', function () {
        location.reload();
    });
};

/**
 * 获取 [登出] 按钮
 */
var quitbtn = getElement('.quit')[0];
//点击后登出
quitbtn.addEventListener('click', function () { quit(); });

/**
 * 打开 [个人信息] 面板
 */
// 获取 [查看个人信息] 按钮
var lookInformation = getElement('.user > div:nth-of-type(1)')[0];
// 获取 [关闭个人信息] 按钮
var closeInformation = getElement('.information .close')[0];
// 获取 [个人信息面板]
var information = getElement('.informationBg')[0];
// 点击按钮，显示个人信息面板
lookInformation.addEventListener('click', function () {
    so_hd(information, 'show');
});

// 点击按钮，关闭个人信息面板
closeInformation.addEventListener('click', function () {
    so_hd(information, 'hide');
});

/**
 * 鼠标经过密码框时显示密码
 */
// 获取个人信息密码框
var infPw = getElement('.information .content ul li input[type=password]')[0];
infPw.onmouseover = function () {
    this.type = 'text';
};
infPw.onmouseout = function () {
    this.type = 'password';
};

/* 个人信息面板中头像的查看 */
var img = getElement('.information > .content > div > div.headimg > img');
seeImg(img);