<?php
/*
create table user(
username varchar(30) not null primary key,
password varchar(32) not null,
email varchar(40) not null,
groups set('admin','user') not null
);

文章名  文章链接  文章大小
create table article(
name varchar(300) not null,
path varchar(400) not null,
size int unsigned not null,
blog_nick varchar(30) not null,
primary key(name,blog_nick)
);

博客名  博客链接  博客介绍   博客存储路径   博客收录文章
create table blog(
nick varchar(30) not null primary key,
url varchar(50) not null,
intro varchar(100) not null,
path varchar(50) not null,
number int unsigned not null
);

create table forbidden_ip(
ip varchar(15) not null primary key,
number int unsigned not null
);

create table crawler(
blog_nick varchar(30) not null primary key,
original_url varchar(50) not null,
page_reg varchar(100) not null,
article_reg varchar(100) not null,
title set('from_title','from_url') not null,
state bool not null
);

create table crawler_state(
blog_nick varchar(30) not null primary key,
page_total int unsigned not null,
article_total int unsigned not null,
article_current int unsigned not null,
article_new int unsigned not null,
state varchar(30) not null
);
state set('running...','success','crawler.ini error','path error','original_url error','not update','page_reg error')
 */

if(!defined('IN_BLOG_PLATFORM')){
    exit('Access Denied');
}

require_once ("config.php");
require_once ("functions.php");
require_once (dirname(__FILE__)."/../sha3/SHA3.php");

function get_connect(){

    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
    if (!$mysqli){
        return [False, $mysqli->connect_error];
    }

    $mysqli->set_charset('utf-8');
    return [True, $mysqli];
}


/**
 *进行数据库的插入操作，插入成功返回1，已经存在返回0，插入异常返回-1
 */
function insert(mysqli $mysqli, $sql){

    $result = $mysqli->query($sql);
    if ($result){
        return 1;
    }
    else{
        if (substr($mysqli->error, 0, 7) === "Duplica") {
            return 0;
        }
        else{
            return -1;
        }
    }

}


/**
 * 在这里使用可变参数将会产生很严重的问题
 * 里面的foreach将会循环遍历所有的变量，如果是数组变量则会递归再次遍历，可变参数的特性将使循环不会进入到作为可变参数之一的参数数组中从而一直递归下去
 */
function d_addslashes(array $array){

    foreach($array as $key=>$value){
        if(!is_array($value)){
            //查看php的魔术引号是否开启了，如果没有开启则使用addslashes函数自行改变所有的引号
            !get_magic_quotes_gpc() && $value=addslashes($value);
            $array[$key]=$value;
        }else{
            $array[$key] = d_addslashes($array[$key]);
        }
    }
    return $array;

}


//从数据库中载入封禁的ip列表
function ForbiddenIPload(mysqli $mysqli, $ip){

    list($ip) = d_addslashes([$ip]);
    $sql = "select number from forbidden_ip where ip='{$ip}'";

    $result = $mysqli->query($sql);
    //存在用户输入参数的地方可能出现sql报错
    if ($result){
        if ($row = mysqli_fetch_assoc($result)){
            return $row['number'];
        }
        else{
            //sql查询没有返回错误但是没有row，返回0
            return 0;
        }
    }
    else{
        //直接在$mysqli->query()的查询中报错，返回报错原因
        die("加载封禁列表时出错<br>".$mysqli->error);
    }

}

//在数据库中对封禁的IP增加1
function ForbiddenIPadd(mysqli $mysqli, $ip){

    list($ip) = d_addslashes([$ip]);

    $number = ForbiddenIPload($mysqli, $ip);
    if ($number == 0){
        $number = 1;
        $sql = "insert forbidden_ip values('{$ip}','{$number}')";
    }
    else {
        $number += 0;
        $sql = "update forbidden_ip set number=$number where ip='{$ip}'";
    }

    $result = $mysqli->query($sql);
    if (!$result) {
        die("更新封禁列表时出错<br>" . $mysqli->error);
    }

}


function ForbiddenIPclear(mysqli $mysqli, $ip){

    list($ip) = d_addslashes([$ip]);
    $sql = "delete from forbidden_ip where ip='{$ip}'";

    $result = $mysqli->query($sql);
    if (!$result){
        die("删除封禁列表时出错<br>" . $mysqli->error);
    }

}


function get_password(mysqli $mysqli, $username){

    list($username) = d_addslashes([$username]);
    $sql = "select password from user where username='{$username}'";

    $result = $mysqli->query($sql);
    //存在用户输入参数的地方可能出现sql报错
    if ($result){
        if ($row = mysqli_fetch_assoc($result)){
            return [1, $row['password']];
        }
        else{
            //sql查询没有返回错误但是没有row，返回NULL
            return [0, NULL];
        }
    }
    else{
        //直接在$mysqli->query()的查询中报错，返回报错原因
        return [-1, $mysqli->error];
    }
}


function register(mysqli $mysqli, $username, $password, $email){

    list($username, $password) = d_addslashes([$username, $password]);
    $shake128 = SHA3::init(SHA3::SHAKE128);
    $shake128->absorb(SALT.$password.SALT);
    $password = bin2hex( $shake128->squeeze(16) );

    $sql = "insert user(username,password,email,groups) values('{$username}','{$password}','{$email}','user')";

    $state = insert($mysqli, $sql);
    if ($state === -1){
        die("在user表中执行插入操作时出错<br>" . $mysqli->error);
    }
    return $state;

}


function register_admin(mysqli $mysqli, $username, $password, $email){

    list($username, $password) = d_addslashes([$username, $password]);
    $shake128 = SHA3::init(SHA3::SHAKE128);
    $shake128->absorb(SALT.$password.SALT);
    $password = bin2hex( $shake128->squeeze(16) );

    $sql = "insert user(username,password,email,groups) values('{$username}','{$password}','{$email}','admin')";

    $state = insert($mysqli, $sql);
    if ($state === -1){
        die("在user表中执行插入操作时出错<br>" . $mysqli->error);
    }
    return $state;

}


function get_blog(mysqli $mysqli){

    $blog = [];
    $sql = "select nick from blog";

    $result = $mysqli->query($sql);
    if ($result){
        while($row = mysqli_fetch_row($result)){
            array_push($blog, $row[0]);
        }
        return [1, $blog];
    }
    else{
        return [0, $mysqli->error];
    }

}


function get_whole_blog_info(mysqli $mysqli){

    $blog = [];
    $sql = "select * from blog";

    $result = $mysqli->query($sql);
    if ($result){
        while($row = mysqli_fetch_row($result)){
            array_push($blog, $row);
        }
        return [1, $blog];
    }
    else{
        return [0, $mysqli->error];
    }

}


function checkPassword(mysqli $mysqli, $pass_input, $username){
    //从数据库中提取密码
    list($state, $password) = get_password($mysqli, $username);

    if ($state === -1){
        die('密码提取时产生错误<br>'.$password); //此时返回的password是错误信息
    }//另外两种情况下，password被置为NULL，与对应的取值

    if ($state === 0){ //从数据里没有拿到密码而返回错误
        return False;
    }
    else{

        //成功的读取到对应用户的密码
        $shake128 = SHA3::init(SHA3::SHAKE128);
        $shake128->absorb(SALT.$pass_input.SALT);

        if (bin2hex( $shake128->squeeze(16) ) === $password){
            return True;
        }
        else{ //因为没有通过密码的验证而返回错误
            return False;
        }
    }

}


function checkAdmin(mysqli $mysqli, $username){

    list($username) = d_addslashes([$username]);
    $sql = "select * from user where username='{$username}' and groups='admin'";

    $request = $mysqli->query($sql);
    if ($request){
        if (mysqli_fetch_assoc($request)){
            return True;
        }else{
            return False;
        }
    }
    else{
        return False;
    }
}


function get_article(mysqli $mysqli, $blog){

    $article = array();
    list($blog) = d_addslashes([$blog]);

    $sql = "select name,path,size from article where blog_nick='{$blog}'";

    $result = $mysqli->query($sql);
    if($result){

        while($row = mysqli_fetch_row($result)){
            array_push($article, array_values($row));
        }

        return [1, json_encode($article)];
    }
    else{
        return [0, $mysqli->error];
    }

}


function get_article_number(mysqli $mysqli, $blog){

    list($blog) = d_addslashes([$blog]);

    $sql = "select number from blog where nick='{$blog}'";

    $result = $mysqli->query($sql);
    if($result){

        $row = mysqli_fetch_assoc($result);
        return $row['number'];
    }
    else{
        return 0;
    }

}

/**
 * return 1 用户名可以使用且合法
 * return 0 用户名格式不正确
 * return -1 用户名已存在
 * return -2 sql查询出错
 */
function username_check(mysqli $mysqli, $username){

    if (preg_match("/^[0-9A-Za-z_.]+$/", $username) && strlen($username)<25){

        list($username) = d_addslashes([$username]);
        $sql = "select username from user where username='{$username}'";

        $result = $mysqli->query($sql);
        if ($result){

            if($row = mysqli_fetch_assoc($result)){
                return -1;
            }
            else{
                return 1;
            }
        }
        return -2;

    }
    else{
        return 0;
    }

}


function add_crawler(mysqli $mysqli, $blog_nick, $original_url, $page_reg, $article_reg, $title){

    if ($title != "from_title" and $title != "from_url"){
        die("title值非法");
    }

    list($blog_nick, $original_url, $page_reg, $article_reg) = d_addslashes([$blog_nick, $original_url, $page_reg, $article_reg]);

    $sql = "insert crawler values('{$blog_nick}', '{$original_url}', '{$page_reg}', '{$article_reg}', '{$title}', 0)";

    $state = insert($mysqli, $sql);
    return $state;
}

/**
 * 之后会去修改一批函数的返回值设计
 * 如果需要返回值下，返回对应的返回值，错误时返回bool类型的false
 * 如果不需要返回值下，成功返回true，失败返回false
 * 多种情况下，返回值使用-2，-1，0，1，来表示不同的处理结果
 */
function update_crawler(mysqli $mysqli, $blog_nick){

    list($blog_nick) = d_addslashes([$blog_nick]);
    $sql = "update crawler set state=1 where blog_nick='{$blog_nick}'";

    $request = $mysqli->query($sql);
    if ($request){

        return True;

    }
    else{
        return False;
    }

}


function get_crawler_info(mysqli $mysqli, $blog_nick){

    list($blog_nick) = d_addslashes([$blog_nick]);
    $sql = "select * from crawler where blog_nick='{$blog_nick}'";

    $request = $mysqli->query($sql);
    if ($request){
        if ($row = mysqli_fetch_assoc($request)){
            return $row;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}


function get_crawler_state_zero(mysqli $mysqli){

    $blog = [];
    $sql = "select blog_nick from crawler";

    $request = $mysqli->query($sql);
    if ($request){

        while($row = mysqli_fetch_assoc($request)){
            array_push($blog, $row['blog_nick']);
        }
        return $blog;
    }
    else{
        return false;
    }

}


function get_state(mysqli $mysqli){

    $list = [];

    $sql = "select * from crawler_state";
    $result = $mysqli->query($sql);

    if ($result){
        //因为是轮询的模式，所以以列表而不是字典的形式取出，可以节省好几倍的空间
        while($row = mysqli_fetch_row($result)){
            array_push($list, $row);
        }

        return [1, json_encode($list)];

    } else {
        return [0, $mysqli->error];
    }
}


function get_state_number(mysqli $mysqli){

    $sql = "select count(*) from crawler_state";

    $result = $mysqli->query($sql);
    if ($result){
        if ($row = mysqli_fetch_row($result)){
            return $row[0];
        }else{
            return 0;
        }
    }else{
        return 0;
    }
}


function article_search(mysqli $mysqli, $searchText){

    //维护一个搜索到的文章结果列表
    $article_list = [];

    $sql = "select name,path,size from article where name like '%{$searchText}%'";
    $result = $mysqli->query($sql);

    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($article_list, $row);
        }
    } else{
        return false;
    }

    return json_encode($article_list);
}
/**
 * 操作过程：
 * admin点击添加按钮，发起一个对api的访问请求，之后api对访问者的session做出判断+判断里面的token是否与session是否匹配，然后执行操作
 * 首先从crawler中提取信息，之后可以把http链接关掉了，接下来的在后台进行，后台操作：
 * 首先使用eval？调用crawler然后执行，返回情况基本上是没有问题的，在操作完成之后在blog表中添加上新的blog，包括有blog以及存储位置
 *
 * 然后呢？算了，不用结果了，什么时候有什么时候出结果吧
 *
 * 这种操作模式最不好的问题就是后台运行的api在中途返回结果，但是最后什么时候结果，出了什么情况都是未知的，先实验下这种操作吧
 *
 * php中配置的路经作为爬取时的存放路径以及收录入表中（blog与article两个）的路经，所以这样说来，是支持不同文章存储在不同的路径的
 */








































