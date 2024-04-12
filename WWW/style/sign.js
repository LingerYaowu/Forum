/* 
 * 切换表单 
 */
    /* 获取[去登录] [去注册]按钮 */
    var goLogon = getElement('.goLogon')[0];
    var goSign = getElement('.goSign')[0];
    /* 获取登录/注册表单 */
    var logonForm = getElement('form')[0];
    var signForm = getElement('form')[1];

    /* 给按钮绑定表单隐藏事件 */
    goSign.addEventListener('click',function(){
        so_hd(logonForm,'hide');
        so_hd(signForm,'show');
    });

    goLogon.addEventListener('click',function(){
        so_hd(signForm,'hide');
        so_hd(logonForm,'show');
    });

/* 
 * 判断邮箱是否可用
 */
    var repeat = false;
    // 获取提示信息元素
    var email_repeat = getElement('.email_repeat')[0];
    // 给[邮箱填写框]添加[鼠标失去焦点]事件
    var sign_email = getElement('input[name=sign_email]')[0];
    sign_email.onblur = function(){
        var url = '../server/mailRepeat.php?email='+this.value;
        ajaxRequest('get',url,function(data){
            if(data == 'true') {
                getElement('.email_repeat')[0].innerHTML = '邮箱未被注册，可以注册';
                repeat = true;
            } else if(data == 'false') {
                getElement('.email_repeat')[0].innerHTML = '邮箱已被注册，可直接登录';
            }
        });
    };

/*
 * 发送验证码AJAX请求
 */
    // 定义[验证码]全局变量
    var code = null;
    // 获取[发送]按钮
    var sendCode = getElement('.sendCode')[0];
    // 全局变量一次只能发一次邮件
    var oneEmail = true;
    // 为发送按钮绑定点击事件
    sendCode.onclick = function(){
        if(!oneEmail) {
            return;
        } else {
            oneEmail = false;
        }
        // 检查邮箱、密码框是否为空
        var mail = sign_email.value;
        var pw = getElement('input[name=sign_password]')[0].value;
        if(!code) {
            // 判断 1：邮箱是否重复 2：邮箱是否填写 3：密码是否填写
            if(mail && pw && repeat) {
                // 接收人,标题,验证码
                var to = mail;
                var title = 'Dragon BBS';
                var co = randId(4,2);
                // 定义一个定时器，1分钟后销毁验证码
                var countdown = null;
                var flag = 60;
                ajaxRequest('get','library/phpLibrary.php?sendEmail=true&to='+ to +'&title='+title+'&content='+co,function(data) {
                    if(data == 'true') {
                        alert('发送成功!');
                        oneEmail = true;
                        code = co;
                        // 将表单解封
                        getElement('input[name=sign_code]')[0].disabled = false;
                        // 倒计时开启
                        if(!countdown) {
                            countdown = setInterval(function(){
                                if(flag < 0) {
                                    getElement('.sendCode > .countdown')[0].innerHTML = '';
                                    // 清空框
                                    getElement('input[name=sign_code]')[0].value = '';
                                    getElement('input[name=sign_code]')[0].disabled = true;
                                    flag = 60;
                                    clearInterval(countdown);
                                    countdown = null;
                                    code = null;
                                    // 提示用户验证码已销毁
                                    alert('验证码已销毁，请重新发送');
                                } else {
                                    getElement('.sendCode > .countdown')[0].innerHTML = '( ' + flag-- + ' )';
                                }
                            },1000);
                        }
                    } else {
                        oneEmail = true;
                        alert('发送失败！请检查邮箱');
                    }
                });
            } else {
                    oneEmail = true;
                    alert('邮箱可能重复或信息填写不完整');
            }
        } else {
            oneEmail = true;
            alert('验证码已发送');
        }
    };

/*
 * 用户提交了注册表单
 */
    signForm.onsubmit = function(){
        var signcode = getElement('input[name=sign_code]')[0].value;
        // 判断验证码是否填写正确
        if(signcode == code) {
            // 获取表单
            var sign_email = getElement('input[name=sign_email]')[0];
            var sign_password = getElement('input[name=sign_password]')[0];
            // 请求 url
            var url = 'server/sign.php?sign_email='+sign_email.value+'&sign_password='+sign_password.value;
            ajaxRequest('get',url,function(data){
                // 判断是否注册成功
                if(!data) {
                    alert('注册失败！');
                } else {
                    alert('注册成功！请前往登录。');
                    window.location.reload();
                }
            });
        } else {
            alert('验证码错误，请重新填写！');
        }
        return false;
    };

/*
 * 获取验证码
 */
    // 定义登录验证码全局变量
    var logonCode = null;
    function getCodeimg() {
        var codetext = randId(2,2);
        var codediv = getElement('.logonCode div')[0];
        codediv.innerHTML = '<img src="../server/code.php?num='+codetext+'" >';
        logonCode = codetext;
    }
    // 调用函数，使图像显示
    getCodeimg();
    // 点击验证码图片 则切换
    getElement('.logonCode div')[0].onclick = function(){
        getCodeimg();
    };

/* 
 * 用户提交登录表单 (logonForm)
 */
    logonForm.onsubmit = function(){
        // 获取表单内的数据
        var logon_email = getElement('input[name=logon_email]')[0];
        var logon_password = getElement('input[name=logon_password]')[0];
        var logon_code = getElement('input[name=logon_code]')[0];
        // 检查验证码是否填写正确
        if(logon_code.value == logonCode) {
            // 验证码正确，验证表单
            var url = 'server/logon.php?logon_email=' + logon_email.value + '&logon_password=' + logon_password.value;
            ajaxRequest('get',url,function(data){
                if(data == 'false') {
                    // 密码错误
                    alert('密码错误，请重新输入');
                    logon_password.value = '';
                } else if(data == '用户未注册') {
                    // 用户未注册
                    alert(data);
                    getCodeimg();
                    logon_code.value = '';
                } else {
                    var userinformation = JSON.parse(data);
                    // 设置SESSION
                    var url = ['../server/session.php?type=setSession&k=email&v='+userinformation[0],'../server/session.php?type=setSession&k=password&v='+userinformation[1],'../server/session.php?type=setSession&k=nickname&v='+userinformation[2],'../server/session.php?type=setSession&k=headimg&v='+userinformation[3],'../server/session.php?type=setSession&k=birthday&v='+userinformation[4],'../server/session.php?type=setSession&k=member&v='+userinformation[5]];
                    var flag = true;
                    for($i=0;$i<url.length;$i++) {
                        ajaxRequest('get',url[$i],function(data){
                            if(data) {
                                flag = false;
                            }
                        });
                    }
                    if(flag) {
                        // 登录成功
                        alert('欢迎登录，' + userinformation[2]);
                        location.reload();
                    }
                }
            });
        } else {
            alert('验证码输入错误，请重新输入');
            // 刷新验证码
            getCodeimg();
            logon_code.value = '';
        }
        return false;
    };
