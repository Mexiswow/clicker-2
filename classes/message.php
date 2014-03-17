<?php

/**
 * Description of message
 *
 * @author munsking
 */
class message {
    
    public function __construct() {
        
        session_start();
        
        return $this;
    }
    
    public function setMsg($msg,$type = null,$disp = 1){
        $_SESSION["msg"][] = array(
            "msg" => $msg,
            "type" => $type,
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
            $arr = $_SESSION["msg"];
        }
        $ret = array();
        foreach($arr as $msg){
            if($msg["disp"] == 1){
                $ret[]=$msg;
            }
        }
        return $ret;
    }
    
}

?>
