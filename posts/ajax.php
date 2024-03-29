<?php

    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
    require_once '../classes/inc.php';
    
    
    $msgMod = new message;
    $db = new db;
    $lmi = new logMeIn;
    
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
    if($_POST["ajax"]=="save" && isset($_POST["clicks"]) && isset($_POST["cps"])){
        $clicks = $_POST["clicks"];
        $cps = $_POST["cps"];
        $saved = $lmi->save($clicks, $cps);
        if($saved){
            echo "Game saved.";
        }else{
            echo "Saving error: $clicks, $cps";
        }
    }
    if($_POST["ajax"]=="ses"){
        var_dump($_SESSION);
    }
    if($_POST["ajax"]=="items" && isset($_POST["aMethod"])){
        $items = new items;
        if($_POST["aMethod"]=="get"){
            if(isset($_POST["id"])){
                echo json_encode($items->getById($_POST["id"]));
                exit;
            }
            echo json_encode($items);
            exit;
        }
    }
    if($_POST["ajax"]=="test"){
        $itemMod = new items;
        echo json_encode($itemMod->addUserItem($_POST["userId"],$_POST["itemId"]));
    }