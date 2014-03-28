<?php

require_once 'inc.php';

class user{
    
    private $db;
    private $_user;
    
    public function __construct($id) {
        $this->db = new db;
        $this->_user = $this->db->fetchRow($this->db->setTable("clicker_users")->select()->where("id = $id"));
    }
    
}