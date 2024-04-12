// 获取开始游戏界面
var start_j = getElement('.start')[0];
// 获取地图
var map = getElement('.map')[0];

// 声明食物与蛇
var food , snake;
// 创建 蛇 类
function Snake() {
    this.width = 20;
    this.height = 20;
    this.cls = 'snake';
    // 设置分数
    this.score = 0;
    // 设置速度
    this.speed = 120;
    // 默认移动方向
    this.direction = 'right';
    this.move_timer = null;
    this.body = [[2, 0, null], [1, 0, null], [0, 0, null]];

    // 显示
    this.show = function () {
        for (var i = 0; i < this.body.length; i++) {
            if (this.body[i][2] == null) {
                // 创建div
                this.body[i][2] = document.createElement('div');
                this.body[i][2].style.width = this.width + 'px';
                this.body[i][2].style.height = this.height + 'px';
                this.body[i][2].className = this.cls;
                this.body[i][2].style.left = this.body[i][0] * this.width + 'px';
                this.body[i][2].style.top = this.body[i][1] * this.height + 'px';
                // 添加到map
                map.appendChild(this.body[i][2]);
            }
            this.body[i][2].style.left = this.body[i][0] * this.width + 'px';
            this.body[i][2].style.top = this.body[i][1] * this.height + 'px';
        }
    };
    // 移动
    this.move = function () {
        if (this.move_timer == null) {
            var th = this;
            th.move_timer = setInterval(function () {
                // 交换除蛇头外的坐标
                function replaceHead() {
                    for (var i = th.body.length - 1; i > 0; i--) {
                        th.body[i][0] = th.body[i - 1][0];
                        th.body[i][1] = th.body[i - 1][1];
                    }
                }
                // 判断蛇头吃到自己的身体
                function headover(th) {
                    var head = th.body[0];
                    for (var i = 1; i < th.body.length; i++) {
                        if (head[0] == th.body[i][0] && head[1] == th.body[i][1]) {
                            th.over();
                        }
                    }
                }
                // 判断移动方向
                var dire = th.direction;
                switch (dire) {
                    case 'right':
                        if (th.body[0][0] * th.width + th.width >= map.clientWidth) {
                            th.over();
                        } else {
                            replaceHead();
                            th.body[0][0]++;
                            headover(th);
                        }
                        break;
                    case 'left':
                        if (th.body[0][0] * th.width + th.width <= th.width) {
                            th.over();
                        } else {
                            replaceHead();
                            th.body[0][0]--;
                            headover(th);
                        }
                        break;
                    case 'bottom':
                        if (th.body[0][1] * th.width + th.width >= map.clientHeight) {
                            th.over();
                        } else {
                            replaceHead();
                            th.body[0][1]++;
                        }
                        break;
                    case 'top':
                        if (th.body[0][1] * th.width + th.width <= th.height) {
                            th.over();
                        } else {
                            replaceHead();
                            th.body[0][1]--;
                            headover(th);
                        }
                        break;
                }
                snake.show();

                // 若吃到食物
                if (th.body[0][0] == food.x && th.body[0][1] == food.y){
                    // 增加速度
                    th.speed -= 20;
                    // 增加蛇节数
                    th.body.push([0,0,null]);
                    // 显示分数
                    getElement('.top_nav > p > span')[0].innerHTML = ++th.score;
                    // 重新显示食物
                    food.show();
                }
            }, th.speed);
        }
    };
    this.over = function () {
        clearInterval(this.move_timer);
        this.move_timer = null;
        var s = this.score;
        this.score = 0;
        // 分数归零
        getElement('.top_nav > p > span')[0].innerHTML = 0;
        // 循环删除残余蛇
        for(var i = 0;i < this.body.length;i++) {
            map.removeChild(this.body[i][2]);
        }
        // 将得分存入数据库
        var url = 'ser/snake.php?score="'+s+'"';
        ajaxRequest('get',url,function(data){
            if(data == 'true') {
                alert('Game Over! Your score is '+s);
                // 隐藏地图
                map.style.display = 'none';
                // 显示开始游戏界面
                start_j.style = '';
            }
        });
    };
}

// 创建实食物类
function food() {
    this.cls = 'food';
    this.x = null;
    this.y = null;
    this.food_div = null;
    // 显示
    this.show = function () {
        if (this.food_div == null) {
            this.food_div = document.createElement('div');
            this.food_div.className = this.cls;
            this.x = Math.round(Math.random() * 29);
            this.y = Math.round(Math.random() * 29);
            this.food_div.style.left = this.x * 20 + 'px';
            this.food_div.style.top = this.y * 20 + 'px';
            map.appendChild(this.food_div);
        }
        this.x = Math.round(Math.random() * 29);
        this.y = Math.round(Math.random() * 29);
        this.food_div.style.left = this.x * 20 + 'px';
        this.food_div.style.top = this.y * 20 + 'px';
    };
}

// 实例化食物
food = new food();

var flag = true;
// 按键改变蛇的运动方向
document.onkeydown = function (event) {
    if (flag) {
        event = event || window.event;
        switch (event.code) {
            case 'ArrowUp':
                if (snake.direction != 'bottom') {
                    snake.direction = 'top';
                }
                break;
            case 'ArrowDown':
                if (snake.direction != 'top') {
                    snake.direction = 'bottom';
                }
                break;
            case 'ArrowLeft':
                if (snake.direction != 'right') {
                    snake.direction = 'left';
                }
                break;
            case 'ArrowRight':
                if (snake.direction != 'left') {
                    snake.direction = 'right';
                }
                break;
        }
        flag = false;
        var t = setInterval(function () {
            flag = true;
            clearInterval(t);
            t = null;
        }, 80);
    }
};