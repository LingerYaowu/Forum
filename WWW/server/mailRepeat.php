<?php
if($_GET['email']) {
    # 判断是否格式完整
    if(strpos($_GET['email'],'@') && strpos($_GET['email'],'.')) {
        require '../library/phpLibrary.php';
        $informations = dbSelect('dragon_users');
        $flag = true;
        for($i=0;$i<count($informations);$i++) {
            if($_GET['email'] == $informations[$i]['email']) {
                $flag = false;
                break;
            }
        }
        if(!$flag) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
}
?>