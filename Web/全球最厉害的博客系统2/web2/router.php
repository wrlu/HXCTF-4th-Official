<?php
//test
define("ROUTING", true);

if(isset($_GET['action'])){

    $_GET['action'] = waf($_GET['action']);
    include($_GET['action'].".php");
}


function waf($action){

    return $action;
}
