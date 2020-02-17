<?php
define( "DB_host", "localhost" );
define( "DB_user", "root" ); // leave as "root"
define( "DB_pass", "" ); // not password
define( "DB_name", "sp4_grp5" ); // scheme name


class DB{
    public $conn = null;

    public function __construct(){
        $this->conn = new mysqli(DB_host, DB_user, DB_pass, DB_name) or die("TEST");
    }
    public function __destruct(){
        $this->conn = null;
    }
}

?>