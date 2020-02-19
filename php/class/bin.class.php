<?php
    require_once "DB.php";

    class Bin extends DB{
        private $table = "tb_bin";
        public function __construct()
        {
            parent::__construct();
        }
        public function __destruct()
        {
            parent::__destruct();
        }
        public function getLocationData($code){
            $stmt = $this->prepare("SELECT * FROM $this->table WHERE bin_code=$code");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function exists($code){
            $stmt = $this->prepare("SELECT * FROM $this->table WHERE bin_code=$code");
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }
    }
?>

