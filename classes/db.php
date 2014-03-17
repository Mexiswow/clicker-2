<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db
 *
 * @author munsking
 */
class db {
    
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_tabl;
    
    private $db;
    
    private $_query;
    
    /**
     * 
     * <p>Creates the db class.
     * <br />
     * <b>!!IMPORTANT!!</b><br />
     * make sure you at least use the setTable() method, otherwise nothing works.</p>
     * 
     * @return self
     */
    
    public function __construct() {
        require_once '../includes/0_dbInfo.php';
        $this->db_host = DB_HOST;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        $this->db_name = DB_NAME;
        
        $this->db = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8", $this->db_user, $this->db_pass);
        return $this;
//        $con = mysql_connect($this->db_host,$this->db_user,$this->db_pass);
//        if(!$con){
//            die("couldn't connect to db:\n".mysql_error());
//            return false;
//        }else{
//            $db = mysql_select_db($this->db_name);
//            if(!$db){
//                die("coudn't select db:\n".mysql_error());
//                return false;
//            }else{
//                return $this;
//            }
//        }
    }
    
    /**
     * 
     * Set the table you want to use.
     * 
     * @param string $tabl
     * @return self
     */
    
    public function setTable($tabl){
        $this->db_tabl = $tabl;
        return $this;
    }
    
    /**
     * 
     * Return the query so far.
     * 
     * @return string
     */
    
    public function queryToString(){
        return $this->_query;
    }

    /**
     * 
     * Start the query, $cols is optional, can be an array with the desired collumn names as strings.
     * 
     * @param array $cols
     * @return self
     */
    
    public function select($cols = array()){
        if(!$this->db_tabl){
            return false;
        }
        if(!$cols){
            $this->_query = "select * from $this->db_tabl";
        }else{
            $qCols = "";
            foreach($cols as $c){
                $qCols .= "`$c`,";
            }
            $qCols = substr($qCols,0,-1);
            $this->_query = "select $qCols from $this->db_tabl";
        }
        return $this;
    }
    
    public function insert($values = array()){
        if(!$this->db_tabl){
            return false;
        }
        $cols = "";
        $vals = "";
        $where = "";
        foreach($values as $k => $v){
            $cols .= "`$k`, ";
            $vals .= "'$v', ";
            $where .= "`$k` = '$v' and ";
        }
        $this->_query = "insert into $this->db_tabl ( " . substr($cols,0,-2) . " ) values ( " . substr($vals,0,-2) . " )";
        return $this;
    }
    
    /**
     * 
     * Define the where parameters for the query.
     * 
     * @param string $data
     * @return self
     */
    
    public function where($data){
        if(!$this->db_tabl){
            return false;
        }
        if(!$this->_query || !$data){
            return false;
        }else{
            $this->_query .= " where $data";
            return $this;
        }
    }
    
    /**
     * 
     * If a query has been created it will use that, otherwise you can give one as a parameter or leave it empty to fetch everything.
     * 
     * @param string $query
     * @return array
     */
    
    public function fetchAll($query = NULL){
        if(!$this->db_tabl){
            return false;
        }
        try {
            if($query){
                if(is_a($query, "db")){
                    $query = $query->queryToString();
                }
                $res = $this->db->prepare($query);
                $res->execute();
            }else{
                if($this->_query == ""){
                    $this->select();
                }
                $res = $this->db->prepare($this->_query);
                $res->execute();
            }
        } catch(PDOException $ex) {
            return $ex->getMessage();
        }
        return $res->fetchAll();
    }
    
    /**
     * 
     * @param string $table
     * @param array $colVal
     * @param array $where
     * @return boolean
     * 
     * $colval = array(
     *      "column" => value,
     *      "column2" => value2
     * )
     * 
     * $where = array(
     *      "column3" => value3
     * )
     * 
     * update $table set column = value, column2 = value2 where column3 = value3;
     * 
     */
    
    public function update($table = "", $colVal = Array(), $where = Array()){
        if(!$table || !$colVal || !$where){
            return false;
        }
        $set = "";
        $wh = "";
        foreach($colVal as $c => $v){
            $set .= "$c=".($v === null?"null":"'$v'").",";
        }
        foreach($where as $c => $v){
            $wh .= "where $c like '$v' and";
        }
        $set = substr($set, 0,-1);
        $wh = substr($wh,0,-4);
        $sql = "update $table set $set $wh";
        return $sql;
    }
    
}
