<?php

include_once 'db.php';

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
    
    public function run($data = array()){
        if(method_exists($this, $data['submit'])){
            if($this->$data['submit']($data['uname'],$data['passwd'])){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function logIn($user, $pass){
        $db = $this->db;
        $newPass=$this->hash($user,$pass);
        $sql = $db->select(array("id"))
                  ->where("uname = '$user' AND pword =  '$newPass'");
        
//        echo $sql->queryToString();
        $loggedIn = $db->fetchAll($sql);
        if(!$loggedIn){
            return false;
        }
        echo $db->update(
            "clicker_users",
            array(
                "lastLogin" => NULL
            ),
            array(
                "uname" => $user
            )
        );
        return $loggedIn;
    }
    
    private function register($user, $pass){
        $db = $this->db;
        $sql = $db->select()
                  ->where("uname = '$user'");
        if($db->fetchAll($sql)){
            return false;
        }else{
            $newPass = $this->hash($user,$pass);
            $sql = $db->insert(array(
                "uname" => $user,
                "pword" => $newPass
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
