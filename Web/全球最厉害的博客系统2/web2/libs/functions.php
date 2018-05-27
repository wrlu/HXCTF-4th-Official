<?php
if(!defined('IN_BLOG_PLATFORM')){
    exit('Access Denied');
}
require_once('sql.php');
require_once ("config.php");

//注意到很严重的问题：server里面的数据为什么都是utf编码的？？不应该是我的php编码环境吗？？
//从$_SERVER数组中拿到当前访问者的IP地址，更高级的反代查ip什么的之后再说吧
function getRealIP(){
    $ip = 'unknown';
    isset($_SERVER['REMOTE_ADDR']) && $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}


function generate_random($length = 32){

    $chars = "abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $random = "";

    for ($i=0; $i<$length; $i++){
        $random .= $chars[ mt_rand(0, strlen($chars)-1) ];
    }

    return $random;

}


function list_base64_encode($data) {
    if( is_array($data) ) {
        foreach ($data as $k => $v) {
            if ( is_array($v) ) {
                $data[$k] = list_base64_encode($v);
            } else {
                $data[$k] = base64_encode($data[$k]);
            }
        }
        return $data;
    } else {
        $data = base64_encode($data);
        return $data;
    }
}


function list_base64_decode($data){
    if( is_array($data) ) {
        foreach ($data as $k => $v) {
            if ( is_array($v) ) {
                $data[$k] = list_base64_decode($v);
            } else {
                $data[$k] = base64_decode($data[$k]);
            }
        }
        return $data;
    } else {
        $data = base64_decode($data);
        return $data;
    }
}



//还是需要做长度限制防止溢出攻击
function email_check($email){
    if (preg_match("/^[0-9A-Za-z]+@[0-9A-Za-z.]+$/", $email) && strlen($email)<40){
        return True;
    }
    else{
        return False;
    }
}


//还是需要做长度限制防止溢出攻击
function password_check($password){
    if (preg_match("/^[0-9A-Za-z_.]+$/", $password) && strlen($password)<40){
        return True;
    }
    else{
        return False;
    }
}


































