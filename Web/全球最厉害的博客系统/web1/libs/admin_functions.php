<?php
if(!defined('IN_BLOG_PLATFORM')){
    exit('Access Denied');
}

//有些辅助函数是只允许管理员调用的，这样做会更安全
if(!defined('IS_ADMIN')){
    exit('Access Denied');
}
require_once ('config.php');
require_once ('sql.php');


function update(mysqli $mysqli, $blog_name, $blog_path){

    $article_list = scandir($blog_path);
    var_dump($article_list);
    //遍历PATH+blogName下的所有.html文件作为article名字，并录入到article表中
    foreach ($article_list as $article) {

        if (substr($article, -5) === ".html" || substr($article, -4) === '.htm') {
            var_dump($article);
            $article_path = $blog_path . $article;
            $article = substr($article, 0, strlen($article) - 5);//截取掉最后的.html字符作为article名字
            $filesize = (int)(filesize($article_path) / 1024);

            //参数过滤
            list($article, $article_path, $blog_name) = d_addslashes([$article, $article_path, $blog_name]);
            $sql = "insert article values('{$article}','{$article_path}',{$filesize},'{$blog_name}')";
            var_dump($sql);

            if (insert($mysqli, $sql) == -1) {
                echo $mysqli->error . "<br>";
            }
        }

    }

    //获取此blog录入的文章数量
    $sql = "select count(*) from article where blog_nick='{$blog_name}'";
    $result = $mysqli->query($sql);
    //存在用户输入参数的地方可能出现sql报错
    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $count = $row['count(*)'];
        }
    }
    else{
        die($mysqli->error);
    }

    //将此blog的article数量放到表中
    $sql = "insert blog values('{$blog_name}','待补充','待补充','{$blog_path}',$count)";
    echo $sql . "<br>";
    if (insert($mysqli, $sql) == -1) {
        die($mysqli->error);
    }

}






























/**
 * 从数据库中拿到所有的blog以及其对应的存放位置
 * 首先要判断这个文件夹是否存在，如果存在的话，就进入文件夹去扫描所有的文件，然后正常流程就好
 */
function update_for_xiemengfei(){
    list($state, $mysqli) = get_connect();
    !$state && die("数据库连接失败");

    //首先通过blog中的位置指定所有blog所存放的地点
    $sql = "select nick,path from blog";



    $path = BLOG_PATH;
    $blog_list = scandir($path);
    $blog_list = array_slice($blog_list,2,NULL);

    //遍历PATH下的所有文件夹名字作为blog列表
    foreach ($blog_list as $blog_name) {

        $blog_path = $path . $blog_name . "/";
        echo $blog_path . "<br>";
        if (is_dir($blog_path)) {

            //参数过滤
            list($blog_name, $blog_path) = d_addslashes([$blog_name, $blog_path]);

            $article_list = scandir($blog_path);
            //遍历PATH+blogName下的所有.html文件作为article名字
            foreach ($article_list as $article) {

                if (substr($article, -5) === ".html" || substr($article, -4) === '.htm') {

                    $article_path = $blog_path . $article;
                    $article = substr($article, 0, strlen($article) - 5);//截取掉最后的.html字符作为article名字
                    $filesize = (int)(filesize($article_path) / 1024);

                    //参数过滤
                    list($article, $article_path, $blog_name) = d_addslashes([$article, $article_path, $blog_name]);
                    $sql = "insert article values('{$article}','{$article_path}',{$filesize},'{$blog_name}')";


                    if (insert($mysqli, $sql) == -1) {
                        echo $mysqli->error . "<br>";
                    }
                }

            }

            //获取此blog录入的文章数量
            $sql = "select count(*) from article where blog_nick='{$blog_name}'";
            $result = $mysqli->query($sql);
            //存在用户输入参数的地方可能出现sql报错
            if ($result) {
                if ($row = mysqli_fetch_assoc($result)) {
                    $count = $row['count(*)'];
                }
            }
            else{
                die($mysqli->error);
            }

            //将此blog录入到blog表中
            $sql = "insert blog values('{$blog_name}','待补充','待补充','{$blog_path}',$count)";
            echo $sql . "<br>";
            if (insert($mysqli, $sql) == -1) {
                echo $mysqli->error . "<br>";
            }

        }
    }

}






?>