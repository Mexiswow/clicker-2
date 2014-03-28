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
    private $msg;
    
    public function __construct() {
        
        $this->db = new db;
        $this->auto = $this->db->fetchAll($this->db->setTable("clicker_items")->select()->where("type =1"));
        $this->upgr = $this->db->fetchAll($this->db->setTable("clicker_items")->select()->where("type =2"));
        
        $this->msg = new message;
        
        return $this;
    }
    
    public function getAllItemCountsForUser($userId){
        $user = new user($userId);
        if($user){
            $sql = $this->db->setTable("clicker_user_items_mgt")->select()->where("userId = $userId");
            return $this->db->fetchAll($sql);
        }else{
            return false;
        }
    }
    
    public function getUserItemCount($userId,$itemId){
        $user = new user($userId);
        $item = $this->getById($itemId);
        if(!$user && !$item){
            return false;
        }else{
            return $this->db->fetchRow($this->db->select()->where("itemId = $itemId")->where("userId = $userId"));
        }
    }
    
    public function addUserItem($userId,$itemId){
        $user = new user($userId);
        $item = $this->getById($itemId);
        if(!$user && !$item){
            return false;
        }else{
            $mgt = $this->db->fetchRow(
                $this->db
                    ->setTable("clicker_user_items_mgt")
                    ->select()
                    ->where("userId = $userId")
                    ->where("itemId = $itemId")
            );
            if($mgt){
                $sql = $this->db->update("clicker_user_items_mgt", array(
                        "amount" => $mgt->amount + 1
                    ), array(
                        "userId" => $userId,
                        "itemId" => $itemId
                    ));
                $this->db->fetchRow($sql);
            }else{
                $sql = 
                    $this->db->insert(array(
                        "userId" => $userId,
                        "itemId" => $itemId,
                        "amount" => 1
                    ));
                $this->db->fetchRow($sql);
                $this->msg->setMsg($sql->queryToString());
            }
        }
    }
    
    public function getById($id){
        return $this->db->fetchRow($this->db->select()->where("id = $id"));
    }
}
