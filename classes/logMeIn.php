<?php

include_once 'db.php';
require_once 'message.php';

/**
 * Description of logMeIn
 *
 * @author munsking
 */
class logMeIn {
    
    private $db;
    private $salt;
    
    private $user;
    private $pass;
    public $msg;
    
    /**
     * 
     * sets salt, establishes db link, sets db table
     * 
     * @return \logMeIn
     */
    
    public function __construct() {
        $this->db = new db();
        $this->salt = "munsking";
        $this->db->setTable("clicker_users");
        $this->msg = new message;
        return $this;
    }
    
    /**
     * 
     * $data['submit'] = function name <br />
     * $data['uname'] = var 1<br />
     * $data['passwd'] = var 2
     * 
     * @param array $data
     * @return function
     */
    
    public function run($func,$u,$p){
        if(method_exists($this, $func)){
            if($ret = $this->$func($u,$p)){
                return $ret;
            }else{
                return false;
            }
        }
    }
    
    private function logIn($user, $pass){
        $db = $this->db;
        $newPass=$this->hash($user,$pass);
        $sql = $db->select(array("id"))
                  ->where("uname = '$user' AND pword =  '$newPass'");
        
//        echo $sql->queryToString();
        $loggedIn = $db->fetchAll($sql);
        if(!$loggedIn){
            return false;
        }
        $res = $db->fetchAll($db->update(
            "clicker_users",
            array(
                "lastLogin" => NULL
            ),
            array(
                "uname" => $user
            )
        ));
        return $loggedIn;
    }
    
    private function register($user, $pass){
        if(count($user) <= 8 || count($user) >= 255){
            $this->msg->setMsg("username should be 8-255 characters");
        }
        if(count($pass)<= 8 || count($pass) >= 255){
            $this->msg->setMsg("password should be 8-255 characters");
        }
        $db = $this->db;
        $sql = $db->select()
                  ->where("uname = '$user'");
        if($db->fetchAll($sql)){
            return false;
        }else{
            $newPass = $this->hash($user,$pass);
            $sql = $db->insert(array(
                "uname" => $user,
                "pword" => $newPass,
                "createdAt" => date("Y-m-d H:i:s")
            ));
            $res = $db->fetchAll($sql);
//            echo $sql->queryToString();
            return $res;
        }
    }
    
    private function hash($user = NULL, $pass = NULL){
        if(!$user){
            if(!$this->user){
                return false;
            }else{
                $user = $this->user;
            }
        }
        if(!$pass){
            if(!$this->pass){
                return false;
            }else{
                $pass = $this->pass;
            }
        }
        $newpass = md5("$this->salt [-] $user".md5($pass));
//        echo "pass ".$newpass;
        return $newpass;
    }
    
    
}
