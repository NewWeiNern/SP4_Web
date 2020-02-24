<?php
    require_once "DB.php";

    class User extends DB{
        private $table = "tb_user";
        public function __construct()
        {
            parent::__construct();
        }
        public function __destruct()
        {
            parent::__destruct();
        }
        public function exists($user){
            $stmt = $this->prepare("SELECT user_name from $this->table WHERE user_name=?");
            $stmt->execute([$user]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>