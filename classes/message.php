<?php

/**
 * Description of message
 *
 * @author munsking
 */
class message {
    
    public function __construct() {
        
        if(session_id() == ''){
            session_start();
        }
        
        return $this;
    }
    
    public function setMsg($msg,$type = null,$disp = 1){
        if(!isset($_SESSION["msg"])){
            $_SESSION["msg"] = array();
        }
        $_SESSION["msg"][] = array(
            "id" => count($_SESSION["msg"]),
            "msg" => $msg,
            "type" => ($type?$type:"info"),
            "disp" => $disp
        );
    }
    
    public function getMsgs($type = null){
        $arr = array();
        if($type){
            foreach($_SESSION["msg"] as $msg){
                if($msg["type"] == $type){
                    $arr[] = $msg;
                }
            }
        }else{
            if(isset($_SESSION["msg"])){
                $arr = $_SESSION["msg"];
            }
        }
        $ret = array();
        foreach($arr as $msg){
            if($msg["disp"] == 1){
                $ret[]=$msg;
            }
        }
        return $ret;
    }
    
    public function delMsg($id = null){
        $msgs = array();
        foreach($_SESSION["msg"] as $k => $v){
            if($msg["id"] == $id){
                $msgs[]=$msg['msg'];
                unset($_SESSION["msg"][$k]);
            }
        }
        return $msgs;
    }
    
}

?>
