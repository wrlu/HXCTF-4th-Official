<?php
include_once ("config.php");
include_once ("session.php");

header("Content-type: text/html; charset=utf-8");

$session = new session($mysqli);

if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] === False){
    echo "你还没有登陆";
    header("Location: login.php");
    exit();
}



if(isset($_SESSION['username'])){

    if($_SESSION['username'] === 'admin'){

        //检查admin的访问ip
        if($_SERVER['HTTP_HOST'] === "127.0.0.1"){
            echo "厉害啦，佩服佩服，flag这就给你";
            echo "<!-- HXCTF{BlackHat2017-SSRF-Orange} -->";
        }
        else{
            echo "admin不是本地访问，所以不能给你看flag。但看在你都是管理员了，那就送你个橘子吧( •̀ ω •́ )y  ";
            echo "<a class='btn btn-primary' href='Orange-Tsai-A-New-Era-Of-SSRF-Exploiting-URL-Parse.pdf'>Orange</a><br><br><br>";
        }

    }else{
        //非管理员账户
        echo "普通用户怎么可能给你看flag┑(￣Д ￣)┍，但我听说admin那里有些好东西...<br><br><br>";
    }
}

//处理反馈的bug
if(isset($_POST['bug']) && $_POST['bug'] !== ""){

    $bug = escapeshellcmd($_POST['bug']);
    $parse_retu = parse_url($bug);

    if(isset($parse_retu['host']) && strstr($parse_retu['host'],"127") === false){
        if(isset($parse_retu['scheme']) && $parse_retu['scheme'] === "http"){

            $feed = shell_exec("curl " . $bug);
        }else{
            $feed = '禁止使用除http外的其他协议<br>';
        }
    }else{
        $feed =  '禁止滥用本功能访问本地<br>';
    }



}

?>

<html>
<head>
    <link href="./lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/dashboard.css" rel="stylesheet">
    <script src="./lib/jquery/jquery-3.3.1.min.js"></script>
    <script src="./lib/popper/popper.min.js"></script>
    <script src="./lib/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
    <p>如果你发现本网站有任何问题，欢迎向我反馈</p>
    <form name="report_bug" method="post" action="index.php">
        <input name="bug" type="text" id="bug" value="" size="100"/>
        <input name="submit" class="btn btn btn-primary" type="submit" />
    </form>
    <script>
        var bug_input = document.getElementById("bug");
        bug_input.value = "http://" + location.host + "/report_bug.php?bug="
    </script>
</div>

<?php
if(isset($feed))
    echo $feed;
?>
</body>
</html>

