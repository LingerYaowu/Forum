/**
 * document.querySelectorAll() 获取元素
 * getElement(元素)
 */
function getElement(elements){
    return document.querySelectorAll(elements);
}

/*
 * 隐藏/显示元素
 * so_hd(要操作的元素, hide/show)
 */
function so_hd(obj,sh) {
    switch(sh){
        case 'show':
            obj.style = '';
            return true;
        break;
        case 'hide':
            obj.style.display = 'none';
            return true;
        break;
        default:
            return false;
    }
}

/* 
 * Ajax请求
 * ajaxRequest(请求方法，url，操作数据的函数)
 */
function ajaxRequest(method,url, calBack) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState==4 && ajax.status==200) {
            if(calBack) {
                calBack(ajax.responseText);
            }
        }
    }
    ajax.open(method,url);
    ajax.send();    
}

/*
 * 随机生成ID
 * randId(英文数量,数字数量)
 */
function randId(s,n){
    var result = '';
    var randEngId = 'abcdefghijklmnopqrstuvwxyz';
    for(var i = 0;i < s;i++) {
        result += randEngId[Math.floor(Math.random()*randEngId.length)];
    }
    for(var i = 0;i < n;i++) {
        result += Math.floor(Math.random()*9);
    }
    return result;
}