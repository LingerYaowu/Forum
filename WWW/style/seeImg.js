/**
 * 参数: 可以查看的图片(可以是数组)
 */
function seeImg(imgtrue) {
    // 获取 查看图片 的板块
    var seeimg = getElement('.seeImg')[0];
    // 获取 查看图片 板块的图片
    var seeImgimg = getElement('.seeImg > img')[0];
    for(var i = 0;i < imgtrue.length;i++) {
        imgtrue[i].onclick = function(){
            // 显示板块
            so_hd(seeimg,'show');
            // 获取图片路径
            var imgUrl = this.src;
            // 显示图片
            seeImgimg.src = imgUrl;
        };
    }
    
    // 获取关闭按钮
    var closeSeeimg = getElement('.seeImg > p > span')[0];
    // 关闭板块
    closeSeeimg.onclick = function(){
        so_hd(seeimg,'hide');
    };

}