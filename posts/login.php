<?php

    if(session_id() == ''){
        session_start();
    }

error_reporting(E_ALL);
ini_set("display_errors", 1);


include_once '../classes/db.php';
include_once '../classes/logMeIn.php';
require_once '../classes/message.php';

$msgMod = new message;

if($_POST){
    foreach($_POST as $k => $v){
        if($k != "submit" && $k != "uname" && $k != "passwd"){
            return false;
        }
    }
//    var_dump($_POST);
    $loginHandler = new logMeIn();
    $func = htmlentities($_POST["submit"]);
    $user = htmlentities($_POST['uname']);
    $pass = htmlentities($_POST['passwd']);
    $loggedIn = $loginHandler->run($func,$user,$pass);
    if($loggedIn){
        $_SESSION["user"]=array(
            "id" => $loggedIn->id,
            "uname" => $user
        );
        $msgMod->setMsg("successfully logged in ".date("Y-m-d H:i:s"),"success");
    }else{
        $msgMod->setMsg("wrong user/pass combo","danger");
    }
    header("location: ..");
    
}else{
    return false;
}