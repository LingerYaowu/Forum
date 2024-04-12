<?php
/*
 * javascript 语句执行函数
 * jssent(语句)
 */
    function jssent($sentence){
        echo "<script>
            $sentence
        </script>";
    }
    
/*
 * 发送邮件
 * sendEmail(接收人,标题,内容)
 */
    function sendEmail($to,$title,$content) {
        require_once $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailerAutoload.php';
        $email = new PHPMailer;
        $email->isSMTP();
        $email->SMTPAuth = true;
        $email->Host = 'smtp.qq.com';
        $email->Username = '2148515600@qq.com';
        $email->Password = 'jtrcfdtmkhiyebfa';
        $email->setFrom('2148515600@qq.com','Dragon BBS');
        if(is_array($to)) {
            for($i = 0;$i < count($to);$i++) {
                $email->addAddress($to[$i]);
            }
        } else { 
            $email->addAddress($to);
        }
        $email->Subject = $title;
        $email->Body = $content;
        if(!$email->send()) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

/*
 * 随机生成ID
 * randId(英文数量,数字数量)
 */
    function randId($s,$n) {
        $randEngId = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $result = null;
        for($j = 0;$j < $s;$j++) {
            $result .= $randEngId[rand(0,25)];
        }
        for($i = 0;$i < $n;$i++) {
            $result .= rand(0,9);
        }
        return $result;
    }

/*
 * 操作数据库函数
 * 
 */
    /* 数据库 '增' 操作 */
    function dbAdd($sentence) {
        # 连接数据库
        $dtb = mysqli_connect('localhost','root','0215song','dragon_bbs') or die('MySQL server connect error!');
        $query = mysqli_query($dtb,$sentence);
        $flag = ($query ? true : false);
        mysqli_close($dtb);
        return $flag;
    }

    /* 数据库 '查' 操作 */
    function dbSelect($tab) {
        $info = [];
        # 连接数据库
        $dtb = mysqli_connect('localhost','root','0215song','dragon_bbs') or die('MySQL server connect error!');
        $query = mysqli_query($dtb,"select * from $tab") or die ('请查看表是否存在或完好');
        while($row = mysqli_fetch_array($query)) {
            $info[] = $row;
        }
        mysqli_close($dtb);
        return $info;
    }

    /* 数据库 '查' 操作 */
    function dbSelSent($sentence) {
        $info = [];
        # 连接数据库
        $dtb = mysqli_connect('localhost','root','0215song','dragon_bbs') or die('MySQL server connect error!');
        $query = mysqli_query($dtb,$sentence) or die ('请查看表是否存在或完好');
        while($row = mysqli_fetch_array($query)) {
            $info[] = $row;
        }
        mysqli_close($dtb);
        return $info;
    }

    /* 数据库 '改' 操作 */
    function dbUpdate($sentence) {
        # 连接数据库
        $dtb = mysqli_connect('localhost','root','0215song','dragon_bbs') or die('MySQL server connect error!');
        $query = mysqli_query($dtb,$sentence);
        $flag = ($query ? true : false);
        mysqli_close($dtb);
        return $flag;
    }

/*
 * 判断用户的AJAX请求函数
 */
    if($_GET['sendEmail'] && $_GET['sendEmail'] == 'true') {
        // 判断用户是否请求 发送邮件(sendEmail()) 函数
        sendEmail($_GET['to'],$_GET['title'],$_GET['content']);
    } else if($_GET['db'] && $_GET['db'] == 'true') {
        // 执行用户传进来的数据
        var_dump(dbUpdate($_GET['dbsent']));
    }

?>