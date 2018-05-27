<?php
if(!defined('ROUTING')){
    header("Location: router.php?action=login");
}

define("IN_BLOG_PLATFORM", true);

require_once("./libs/functions.php");

require_once("./libs/config.php");
//开启CSP


//注明输出页面的编码方式
header("Content-type: text/html; charset=".CHARSET);

//设置httponly,使用ini_set修改ini配置文件
ini_set("session.cookie_httponly", 1);
session_start();


//建立数据库连接提取匹配数据
list($statu, $mysqli) = get_connect();
!$statu && die("数据库连接失败");


//进行登陆界面的验证
$is_pass_wrong      = False;  //设置此状态值为了之后弹窗提示用
$is_forbidden  = False;  //描述是否ip被禁用了
$ip                 = getRealIP();
$forbiddenCount     = ForbiddenIPload($mysqli, $ip);

//是否传递过来了参数，相应的则会将$is_empty置为True
if (isset($_POST['password']) && $_POST['password']!="" &&
    isset($_POST['username']) && $_POST['username']!=""){

    //密码是否成功匹配，相应的会将$is_pass_wrong置为True
    if (checkPassword($mysqli, $_POST['password'], $_POST['username'])){

        //确认登陆后的操作流程
        //1、为其设置各种session值
        $_SESSION['isLogin']     = True;
        $_SESSION['username']    = $_POST['username'];
        $_SESSION['user_IP']     = $ip;
        $_SESSION['user_agent']  = $_SERVER['HTTP_USER_AGENT'];
        //2、结束处理并重定想到管理界面
        header("Location: router.php?action=index");
        exit();
    }
    else{
        //将记录登陆状态的session值置为false
        $is_pass_wrong = True;
    }
}


?>



<html>
<head>
    <title>Blog Site login</title>
    <link rel="stylesheet" type="text/css" href="./static/css/login.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/buttons.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/site.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/frameworks.css"/>
    <script type="text/javascript" src="static/js/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="./static/images/head.jpg"/>
</head>

<?php
//如果处于流程二，将会对密码匹配结果进行反馈
if($is_pass_wrong){
    echo "<script>alert('用户名与密码不匹配')</script>";
}
?>

<body>

<div role="main" style="height: 768px; background-color: rgb(43, 49, 55);">
    <div class="jumbotron jumbotron-codelines" style="height: 768px">
        <div class="container-lg p-responsive position-relative">

            <div class="d-md-flex flex-items-center gut-lg">

                <div class="col-md-7 text-md-left">
                    <h1 class="alt-h0 text-white lh-condensed-ultra mb-3">Built for<br>white cap</h1>
                    <p class="alt-lead mb-4">
                        Blog site is a collection of blog sites, you can crawl your favourite blog and stored in here conveniently.
                        Click <a>here</a> to dump it from github
                    </p>
                </div>

                <div class="mx-auto col-sm-8 col-md-5 hide-sm rounded-1 bg-gray-light pt-4 pb-5">

                    <form accept-charset="GB2312" action="./router.php?action=login" class="home-hero-signup" autocomplete="off" method="post">

                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="user[login]">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg input-block" placeholder="Pick a username" id="user[login]" required="required">

                            </dd>
                        </dl>

                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="user[password]">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg input-block" placeholder="Pick a password" id="user[password]" required="required">
                                <p class="form-control-note">Use only 0-9,A-z,a-z._</p>

                            </dd>
                        </dl>

                        <input id="firesunCheck" type="hidden" name="loginCheck" value=<?php
                        $random = generate_random(32);
                        $_SESSION['loginCheck'] = $random;
                        echo $random;
                        ?>>

                        <button class="btn btn-primary btn-large f4 btn-block" type="submit">Sign in for Blog-Site</button>
                        <label class="form-label text-gray f5" style="margin-top: 15px;">No account? <a href="./router.php?action=register">Sign in now!</a></label>

                    </form>


                </div>

            </div>

        </div>
    </div>
</div>








</body>
</html>
