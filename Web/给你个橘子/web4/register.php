<?php
include_once("config.php");
header("Content-type: text/html; charset=utf-8");

$isSameNameExist = False;
if(isset($_POST['username']) && $_POST['username'] != "" &&
   isset($_POST['password']) && $_POST['password'] != ""){

    //过滤参数
    $username = addslashes($_POST['username']);
    $password = md5($_POST['password']);

    //检查是否有相同用户名的存在
    $sql = "select * from user where username='{$username}'";
    $result = $mysqli->query($sql);
    if($result){
        if(mysqli_fetch_assoc($result)){
            $isSameNameExist = True;
        }else{
            //没有相同用户明用户存在，插入用户
            $sql = "insert into user values('{$username}','{$password}')";
            $result = $mysqli->query($sql);
            if($result){
                header("Location: login.php");
            }else{
                die($mysqli->error);
            }
        }
    }else{
        die($mysqli->error);
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

<?php
if($isSameNameExist){
    echo "<script>alert('相同用户名存在')</script>";
}
?>


<div class="container">
    <form name="formRegister" method="post" action="register.php">
        <label for="username">Username</label>
        <input name="username" type="text" id="username" tabindex="1" value="" size="30"/>
        <label for="password">Password</label>
        <input name="password" type="password" size="30" />
        <input class="btn btn-primary" name="submit" type="submit"/>
    </form>
</div>



</body>

