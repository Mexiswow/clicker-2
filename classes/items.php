<?php

    require_once 'inc.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of items
 *
 * @author munsking
 */
class items {
    
    private $db;
    public $auto;
    public $upgr;
    
    public function __construct() {
        
        $this->db = new db;
        $this->auto = $this->db->fetchAll($this->db->setTable("clicker_items")->select()->where("type =1"));
        $this->upgr = $this->db->fetchAll($this->db->setTable("clicker_items")->select()->where("type =2"));
        
        return $this;
    }
}
