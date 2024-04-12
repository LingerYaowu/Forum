<?php
include '../library/phpLibrary.php';
# 判断GET传没传邮箱信息
// if($_GET['email']) {
    $arr = dbSelect('dragon_users');
// }
for($i = 0;$i < count($arr);$i++) {
    echo $arr[$i]['email'];
    echo '<br/>';
}

?>