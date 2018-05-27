<?php
if(!defined('IN_BLOG_PLATFORM')){
    exit('Access Denied');
}

//BLOG主文件夹存放的位置
define("BLOG_PATH", "./blog/");
//数据库登陆的用户名与密码
define("DB_HOST", "localhost");
define("DB_USER", "yiruma");
define("DB_PASS", "kaoyanyaojin");
define("DB_DATABASE", "blog");
//是否启用管理员IP认证，启用后当平台发现IP变化，会要求重新登陆,对防止xss攻击是很有效的
define("ADMIN_IP_CHECK_ENABLE", "true");
//密码存储时的salt
define("SALT", "");
//指定输出页面的编码方式
define("CHARSET", "utf-8");
//指定admin页面的初始展示blog
define("INIT_BLOG", "Ben师傅");
