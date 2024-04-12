// 获取期盼
var chess = document.querySelectorAll('.chess')[0];
// 获取2d
var context = chess.getContext('2d');
context.strokStyle = '#ffff';


/* 绘画棋盘 */
function drawChessBoard() {
    for(var i = 0;i < 21;i++) {
        /**绘制横线 */
        // 设置起始点坐标
        context.moveTo(10,10+30*i);
        // 设置结束点坐标
        context.lineTo(610,10+30*i);
        context.strokeStyle = 'rgb(110, 110, 110)';
        // 链接两点
        context.stroke();

        /**绘制竖线 */
        context.moveTo(10+i*30,10);
        context.lineTo(10+i*30,610);
        context.stroke();
    }
}

drawChessBoard();

// 设置赢法数组
var wins = [];
for(var i = 0;i < 21;i++) {
    wins[i] = [];
    for(var j = 0;j < 21;j++) {
        wins[i][j] = [];
    }
}


// 赢法编号
var count = 0;

// 统计横线赢法
for(var i = 0;i < 21;i++) {
    for(var j =0;j < 17;j++) {
        // j,i
        for(var k = 0;k < 5;k++) {
            wins[j+k][i][count] = true;
        }
        count++;
    }
}

// 统计竖线赢法
for(var i = 0;i < 21;i++) {
    for(var j = 0;j < 17;j++) {
        for(var k = 0;k < 5;k++) {
            wins[i][j+k][count] = true;
        }
        count++;
    }
}

// 统计正斜线
for(var i = 0;i < 17;i++) {
    for(var j = 0;j < 17;j++) {
        for(var k = 0;k < 5;k++) {
            wins[i+k][j+k][count] = true;
        }
        count++;
    }
}

// 统计反斜线
for(var i = 0;i < 17;i++) {
    for(var j = 20;j > 3;j--) {
        for(var k = 0;k < 5;k++) {
            wins[i+k][j-k][count] = true;
        }
        count++;
    }
}

// 定义二维数组，标记棋盘上的每个坐标是否已经下了棋子
var chessboard = [];
for(var i = 0;i < 21;i++) {
    chessboard[i] = [];
    for(var j = 0;j < 21;j++) {
        chessboard[i][j] = 0;
    }
}

// 下棋
var me = true; //标记人是否可以下棋
var over = false; //标记游戏是否结束
var myWin = []; //记录用户在赢法上的分值
var computerWin = []; //计算机在赢法上的分值
for(var i = 0;i < count;i++) {
    myWin[i] = 0;
    computerWin[i] = 0;
}

chess.onclick = function(event){
    event = event || window.event;
    // 结束就不可以下棋了
    if(over) {
        return;
    }
    // 判断人是否可以下棋
    if(!me) {
        return;
    }

    //获取x坐标
    var x = event.offsetX;
    //获取y坐标
    var y = event.offsetY;

    x= Math.floor(x/30);
    y= Math.floor(y/30);

    // 判断点到的坐标能不能下棋
    if(chessboard[x][y] == 0) {
        // 可以下
        oneStep(x,y,me);
        chessboard[x][y] = 1;
        for(var k = 0;k < count;k++) {
            if(wins[x][y][k]) {
                myWin[k]++;
                if(myWin[k] == 5) {
                    alert('恭喜你获胜！');
                    over = true;
                }
            }
        }
    }
    
    if(!over) {
        me = !me;
        // 计算机落子
        computerAI();
    }
};

function computerAI() {
    // 空白子在用户所占用赢法上的分值
    var myScore = [];

    //空白子在计算机所占用赢法上的分值
    var computerScore = [];

    for(var i = 0;i < 21;i++) {
        myScore[i] = [];
        computerScore[i] = [];
        for(var j = 0;j < 21;j++) {
            myScore[i][j] = 0;
            computerScore[i][j] = 0;
        }
    }

    //空白子的最大分值
    var max = 0;
    //最大分值空白子所在的坐标
    var x = 0,y=0;
    for(var i = 0;i < 21;i++) {
        for(var j = 0;j < 21;j++) {
            // 判断是否是空白子
            if(chessboard[i][j] == 0) {
                for(var k = 0; k < count;k++) {
                    if(wins[i][j][k]) {
                        if(myWin[k] == 1){
                            myScore[i][j] += 200;
                        } else if(myWin[k] == 2) {
                            myScore[i][j] += 400;
                        } else if(myWin[k] == 3) {
                            myScore += 2000;
                        } else if(myWin[k] == 4) {
                            myScore += 10000;
                        }

                        if(computerWin[k] == 1) {
                            computerScore[i][j] += 220;
                        } else if(computerWin[k] == 2) {
                            computerScore[i][j] += 420;
                        } else if(computerWin[k] == 3) {
                            computerScore[i][j] += 2200;
                        } else if(computerWin[k] == 4) {
                            computerScore[i][j] += 12000;
                        }
                        console.log('myWin[k]：'+myWin[k]);
                        console.log('computerWin[k]：'+computerWin[k]);
                    }
                } 

                if(computerScore[i][j] > max) {
                    max = computerScore[i][j];
                    console.log(max);
                    x = i;
                    y = j; 
                } else if(computerScore[i][j] == max) {
                    if(myScore[i][j] > max) {
                        max = myScore[i][j];
                        x = i;
                        y = j;
                    }
                } 
                
                if(myScore[i][j] > max) {
                    max = myScore[i][j];
                    x = i;
                    y = j;
                } else if(myScore[i][j] == max) {
                    if(computerScore[i][j] > max) {
                        x = i;
                        y = j;
                    }
                }

            }
        }
    }
    oneStep(x,y,me);
    chessboard[x][y] = 1;

    for(var k = 0;k < count;k++) {
        if(wins[x][y][k]) {
            computerWin[k]++;
            if(computerWin[k] == 5) {
                alert('计算机赢了！');
                over = false;
            }
        }
    }
    if(!over) {
        me = !me;
    }
}

// 落子方法
function oneStep(x,y,me) {
    context.beginPath();
    context.arc(10+x*30,10+y*30,10,0,Math.PI*2);
    context.closePath();
    var color;
    if(me) {
        color = 'rgb(120,120,120)';
    } else {color = 'rgb(140,10,30)';}
    context.fillStyle = color;
    context.fill();
}