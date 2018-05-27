<?php

define("IN_BLOG_PLATFORM", true);
define("IS_ADMIN", true);

require_once ("./libs/auth.php");
require_once ("./libs/sql.php");
require_once ("./libs/admin_functions.php");

//建立数据库连接提取匹配数据
list($state, $mysqli) = get_connect();
!$state && die("数据库连接失败");

//需要进行admin的身份验证
if(isset($_SESSION['username']) && $_SESSION['username'] != ""){

    if(!checkAdmin($mysqli, $_SESSION['username'])){
        exit('Access Denied');
    }
}



if ( isset( $_GET['cmd']) && $_GET['cmd'] != "" ){
    switch( $_GET['cmd'] ){
        //根据blog名获取文章列表
        case 'deleteblog':
            if(isset($_GET['blog']) && $_GET['blog'] != ""){

                list($blog) = d_addslashes([$_GET['blog']]);

                //删除article表中的所有对应文章
                $sql = "delete from article where blog_nick='{$blog}'";
                $result = $mysqli->query($sql);

                //删除blog表中的对应信息
                $sql = "delete from blog where nick='{$blog}'";
                $result = $mysqli->query($sql);


            }
            break;

        case 'deletecrawlerstate':

            if(isset($_GET['blog']) && $_GET['blog'] != "") {

                list($blog) = d_addslashes([$_GET['blog']]);

                $sql = "delete from crawler_state where blog_nick='{$blog}'";
                $result = $mysqli->query($sql);
            }
            break;

        case 'deletecrawler':

            if(isset($_GET['blog']) && $_GET['blog'] != "") {

                list($blog) = d_addslashes([$_GET['blog']]);
                echo $blog;

                $sql = "delete from crawler where blog_nick='{$blog}'";
                $result = $mysqli->query($sql);
            }
            break;

    }
}

