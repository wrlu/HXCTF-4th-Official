<?php
error_reporting(0);
define("IN_BLOG_PLATFORM", true);

require_once ('./libs/auth.php');

header('Content-Type: application/json');


if ( isset( $_GET['cmd']) && $_GET['cmd'] != "" ){
    switch( $_GET['cmd'] ){
        //根据blog名获取文章列表
        case 'get_article_list':
            list($state, $mysqli) = get_connect();
            !$state && die($mysqli->error);

            list($state, $retu) = get_article($mysqli, $_GET['blog_name']);
            !$state && die($retu);
            echo $retu;
            break;

        case 'logout':
            session_start();
            session_unset();
            session_destroy();
            header("Location: login.php");
            break;

        case 'get_state':
             //将state表中所有的内容返回

            list($state, $mysqli) = get_connect();
            !$state && die($mysqli->error);

            list($state, $retu) = get_state($mysqli);
            !$state && die($retu);

            echo $retu;
            break;

        case 'search':

            if ( isset($_GET['searchText']) && $_GET['searchText'] != "" ){

                list($state, $mysqli) = get_connect();
                !$state && die($mysqli->error);

                $article = article_search($mysqli, $_GET['searchText']);

                if ($article !== false){
                    echo $article;
                } else {
                    echo "";
                }
            }
            break;

    }
}
