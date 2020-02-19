<?php
define( "DB_host", "localhost" );
define( "DB_user", "jhzqschool" ); // leave as "root"
define( "DB_pass", "jhzqschool" ); // not password
define( "DB_name", "sp4_grp5" ); // scheme name

class DB{
    protected $conn = null;
    
    public function __construct()
    {  
       $this->conn = new PDO("mysql:host=".DB_host.";dbname=".DB_name, DB_user, DB_pass);
       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }

    public function __destruct(){
        $this->conn = null;
    }

    public function prepare($sql){
        return $this->conn->prepare($sql);
    }
    
    public function lastInsertId(){
        return $this->conn->lastInsertId();
    }
}
?>