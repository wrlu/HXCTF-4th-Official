<?php

if(!defined('IN_BLOG_PLATFORM')){
    exit('Access Denied');
}

//引入基本的php文件
require_once ("config.php");
require_once ("functions.php");

//注明输出页面的编码方式
header("Content-type: text/html; charset=".CHARSET);

//设置httponly并开启session会话
ini_set("session.cookie_httponly", 1);
session_start();

//判断登陆_1
if (!( isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === true &&
    isset($_SESSION['user_agent']) && $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'] )){

    $_SESSION['isLogin'] = false;
    $_SESSION['user_IP'] = "";
    $_SESSION['user_agent'] = "";
    //清空session会话，清除session变量，结束session会话
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

//判断登陆_2
if(ADMIN_IP_CHECK_ENABLE && !(isset($_SESSION['user_IP']) &&
        $_SESSION['user_IP'] != "" && $_SESSION['user_IP'] === getRealIP())){

    $_SESSION['isLogin'] = false;
    $_SESSION['user_IP'] = "";
    $_SESSION['user_agent'] = "";
    //清空session会话，清除session变量，结束session会话
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

//开启CSP
//require_once("waf.php");
