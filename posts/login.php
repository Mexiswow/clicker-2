<?php

session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once '../classes/db.php';
include_once '../classes/logMeIn.php';

if($_POST){
    foreach($_POST as $k => $v){
        if($k != "submit" && $k != "uname" && $k != "passwd"){
            return false;
        }
    }
    
    $loginHandler = new logMeIn();
    $user = htmlentities($_POST['uname']);
    $pass = htmlentities($_POST['passwd']);
    $loggedIn = $loginHandler->login($user,$pass);
    if($loggedIn){
        die(var_dump($loggedIn));
    }else{
        die("not logged in");
    }
    header("location: ..");
    
}else{
    return false;
}