<?php

    require_once '../classes/message.php';
    
    $msgMod = new message;
    
    if(session_id() == ''){
        session_start();
    }

    $incFiles = glob("../includes/*.php");
    $classFiles = glob("../classes/*.php");
    foreach($incFiles as $inc){
        include_once($inc);
    }
    foreach($classFiles as $class){
        require_once($class);
    }

    if($_POST["ajax"]=="delmsg"){
        $msgMod = new message;
        if($_POST["data"]["id"]){
            $msgMod->delMsg($_POST["data"]["id"]);
        }else{
            $msgMod->delMsg();
        }
    }
    if($_POST["ajax"]=="logout"){
        foreach($_SESSION as $k => $v){
            $_SESSION[$k] = "";
            unset($_SESSION[$k]);
        }
        session_destroy();
        session_start();
        $msgMod->setMsg("successfully logged out","success");
        echo "logged out";
    }