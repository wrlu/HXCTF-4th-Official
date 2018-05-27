<?php

if(!defined('ROUTING')){
    header("Location: router.php?action=register");
}

define("IN_BLOG_PLATFORM", true);

require_once("./libs/functions.php");

require_once("./libs/config.php");

//注明输出页面的编码方式
header("Content-type: text/html; charset=".CHARSET);

//设置httponly,使用ini_set修改ini配置文件
ini_set("session.cookie_httponly", 1);
session_start();

//建立数据库连接提取匹配数据
list($state, $mysqli) = get_connect();
!$state && die("数据库连接失败");


//进入注册验证界面
$Username_state = 1;
$Email_state    = True;
$Password_state = True;

//判断是否传过来了相应的信息
if(isset($_POST['username']) && $_POST['username'] != "" &&
   isset($_POST['email']) && $_POST['email'] != "" &&
   isset($_POST['password']) && $_POST['password'] != ""){

    //信息都具备的话，开始检查格式
    $Username_state = username_check($mysqli, $_POST['username']);
    $Email_state    = email_check($_POST['email']);
    $Password_state = password_check($_POST['password']);


    //如果信息检查无误的话，开始信息的录入
    if($Username_state === 1 && $Email_state === True && $Password_state === True){

        register($mysqli, $_POST['username'], $_POST['password'], $_POST['email']);
        header("Location: router.php?action=login");
    }

}


?>



<html>
<head>
<title>Blog Site register</title>
<link rel="stylesheet" type="text/css" href="./static/css/login.css"/>
<link rel="stylesheet" type="text/css" href="./static/css/buttons.css" />
<link rel="stylesheet" type="text/css" href="./static/css/site.css"/>
<link rel="stylesheet" type="text/css" href="./static/css/frameworks.css"/>
<script type="text/javascript" src="static/js/jquery.min.js"></script>
<link rel="icon" type="image/x-icon" href="./static/images/head.jpg"/>
</head>


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

                    <form accept-charset="GB2312" action="./router.php?action=register" class="home-hero-signup" autocomplete="off" method="post">

                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="user[login]">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg input-block" placeholder="Pick a username" id="user[login]" required="required">
                                <?php
                                    if ($Username_state == 0){
                                        echo '<p class="form-control-note" style="color: #ff0000">The Username format error</p>';
                                    }
                                    else if($Username_state == -1){
                                        echo '<p class="form-control-note" style="color: #ff0000">The Username already exists</p>';
                                    }
                                ?>
                            </dd>
                        </dl>

                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="email">Email</label>
                                <input type="text" name="email" class="form-control form-control-lg input-block" placeholder="Your email address" id="user[email]" required="required">
                                <?php
                                if ($Email_state == False){
                                    echo '<p class="form-control-note" style="color: #ff0000">The Email format error</p>';
                                }
                                ?>
                            </dd>
                        </dl>

                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="password">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg input-block" placeholder="Create a password" id="user[password]" required="required">
                                <p class="form-control-note">Use only 0-9,A-z,a-z._</p>
                                <?php
                                if ($Password_state == False){
                                    echo '<p class="form-control-note" style="color: #ff0000">The Username format error</p>';
                                }
                                ?>
                            </dd>
                        </dl>

                        <input id="firesunCheck" type="hidden" name="registerCheck" value="<?php
                            $random = generate_random(32);
                            $_SESSION['registerCheck'] = $random;
                            echo $random
                        ?>">

                        <button class="btn btn-primary btn-large f4 btn-block" type="submit">Sign up for Blog-Site</button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>








</body>
</html>
