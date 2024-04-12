<?php
header('Content-type:image/png;');
# 设置画布的宽高
$width = 50;
$height = 25;
# 创建画布
$img = imagecreate($width,$height);
# 定义颜色
$black = imagecolorallocate($img,0,0,0);
$white = imagecolorallocate($img,255,255,255);
$gray = imagecolorallocate($img,200,200,200);
# 填充画布
imagefill($img,0,0,$white);
# 绘制字
for($i=0;$i<strlen($_GET['num']);$i++) {
    $y = rand(2,$height-14);
    $authnum = substr($_GET['num'],$i,1);
    imagestring($img,5,(3+$width/strlen($_GET['num'])*$i),$y,$authnum,imagecolorallocate($img,rand(0,130),rand(0,130),rand(0,130)));
}
# 绘制一些点
for($i=0;$i<200;$i++) {
    $randcolor = imagecolorallocate($img,rand(0,130),rand(0,130),rand(0,130));
    imagesetpixel($img,rand()%100,rand()%55,$randcolor);
}
# 绘制线段
for($i = 0;$i < 3;$i++) {
    imageline($img,rand(0,70),rand(0,30),rand(0,70),rand(0,30),imagecolorallocate($img,rand(0,130),rand(0,130),rand(0,130)));
}
# 输出图像
imagepng($img);
# 销毁资源
imagedestroy($img);
?>