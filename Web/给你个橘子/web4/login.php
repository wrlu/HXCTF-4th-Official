<?php
include_once("config.php");
include_once('session.php');
header("Content-type: text/html; charset=utf-8");

$session = new session($mysqli);


if(isset($_POST['username']) && $_POST['username'] != '' &&
    isset($_POST['password']) && $_POST['password'] != ''){

    $username = addslashes($_POST['username']);
    $password = md5($_POST['password']);

    $sql = "select * from user where username='{$username}' and password='{$password}'";
    $result = $mysqli->query($sql);

    if($result){
        if(mysqli_fetch_assoc($result)){

            $_SESSION['isLogin'] = True;
            $_SESSION['username'] = $username;
            $session->update_session();
            header("Location: index.php");
        }else{
            echo "µÇÂ¼Ê§°Ü";
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
<div class="container">
    <form name="formLogin" method="post" action="login.php">
        <label for="username">Username</label>
        <input name="username" type="text" id="username" tabindex="1" value="" size="30"/>
        <label for="password">Password</label>
        <input name="password" type="password" size="30" />
        <input class="btn btn-primary" name="submit" type="submit"/>
    </form>
    <a class="btn btn-primary" href="register.php">Sign in Now!</a>
</div>
</body>

</html>


