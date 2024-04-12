// 获取左右切换按钮
var roteLeft = getElement('.rotation > .left span')[0];
var roteRight = getElement('.rotation > .right span')[0];

// 获取轮播图
var rote = getElement('.rotation > div.rota > div.rotacenter')[0];

var deg = 0;
/* 定义左转函数 */
function turnleft(){
    deg += 60;
    rote.style.transform = 'rotateX(-5deg) rotateY('+deg+'deg)';
    if(deg > 360) {
        deg = 0;
        rote.style.transform = 'rotateX(-5deg) rotateY('+deg+'deg)';
        console.log('00');
    }
}

roteLeft.addEventListener('click',function(){
    turnleft();
});