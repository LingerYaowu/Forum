/* 获取相关页面 */
var pages = getElement('.information_content > div');

// 使所有页面z-inde都=0
function hidePage() {
    for (var i = 0; i < pages.length; i++) {
        pages[i].style.zIndex = '0';
    }
}

// 按钮点击显示页面
function showPage(obj) {
    obj.style.zIndex = '10';
}

// 获取功能按钮集
var funbtns = getElement('.funbtns > div');

// 清空按钮样式
function clearStyleBtn() {
    for (var i = 0; i < funbtns.length; i++) {
        var clsStr = funbtns[i].className;
        if (clsStr.indexOf('selectBtn') >= 0) {
            clsStr = clsStr.replace(' selectBtn', '');
            funbtns[i].className = clsStr;
        }
    }
}

// 给按钮添加点击事件
for (let i = 0; i < funbtns.length; i++) {
    funbtns[i].onclick = function() {
        // 先清除所有按钮样式
        clearStyleBtn();
        // 获取此按钮的类
        var clsStr = this.className;
        if (clsStr.indexOf('selectBtn') < 0) {
            this.className += ' selectBtn';
        }
        // 将所有页面z-inde设置为0
        hidePage();
        // 显示相应页面
        showPage(pages[i]);
    };
}

// 初始化按钮
funbtns[0].onclick();