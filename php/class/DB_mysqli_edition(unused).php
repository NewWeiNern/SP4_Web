<?php

define( "DB_host", "localhost" );
define( "DB_user", "jhzqschool" ); // leave as "root"
define( "DB_pass", "jhzqschool" ); // not password
define( "DB_name", "sp4_grp5" ); // scheme name


class DB{
    protected $conn = null;
    protected $_prepare = null;
    private $query = "";
    public function __construct(){
        $this->conn = new mysqli(DB_host, DB_user, DB_pass, DB_name) or die("TEST");
    }
    public function __destruct(){
        $this->close();
    }
    /**
     * Prepare statement for CRUD process
     * 
     * @param $sql Sql code here
     * @return DB
     */
    public function prepare($sql){
        $this->query = $sql;
        $this->_prepare = $this->conn->prepare($sql);
        return $this;
    }
    /**
     * Binds parameter except it is called bind
     * 
     * @param $type Declare type
     * @return DB
     */
    public function bind($type, ...$arr){
        if($this->_prepare)
            $this->_prepare->bind_param($type, ...$arr);
        else
            throw new Exception("No prepare statement found");

        return $this;
    }
    /**
     * Execute prepare
     * 
     * @return DB
     */
    public function run(){
        if($this->_prepare)
            $this->_prepare->execute();
        else
            throw new Exception("No prepare statement found");
            
        return $this;
    }
    /**
     * Gets everything. Only use for SELECT!
     * 
     * @return Array
     */
    public function get(){
        $this->run();
        $arr = [];
        $metadata = $this->_prepare->result_metadata();
        while($meta = $metadata->fetch_field()){
            echo var_dump($meta);
            $arr[] = $meta;
        }
        // $result = $this->_prepare->get_result();
        // return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function close_prepare(){
        $this->_prepare->close();
    }
    public function close(){
        $this->conn->close();
    }
}

?>
