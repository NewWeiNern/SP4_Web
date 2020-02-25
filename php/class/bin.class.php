<?php
    require_once "DB.php";
    require_once "../php/lib/qrcode/qrlib.php";
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
            $stmt = $this->prepare("SELECT bin_name FROM $this->table WHERE bin_code=$code");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function exists($code){
            $stmt = $this->prepare("SELECT bin_id FROM $this->table WHERE bin_code=$code");
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }
        public function getInfo($code){
            $stmt = $this->prepare("SELECT is_scanned, bin_json, is_generated, is_opened FROM $this->table WHERE bin_code=$code");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function generateQR($data){
            ob_start();
            QRcode::png(http_build_query($data));
            $img = base64_encode(ob_get_clean());
            header("content-type: text/html");
            ob_end_clean();
            return $img;
        }
        public function update($json, $gen, $code){
            $stmt = $this->prepare("UPDATE $this->table SET is_generated = ?, bin_json = ? WHERE bin_code = ?");
            $stmt->execute([$gen, $json, $code]);
        }
        public function isOpened($bool, $code){
            $this->prepare("UPDATE $this->table SET is_opened = ? WHERE bin_code = ?")->execute([$bool, $code]);
        }
        public function isScanned($bool, $code){
            $this->prepare("UPDATE $this->table SET is_scanned = ? WHERE bin_code = ?")->execute([$bool, $code]);
        }
        public function isGenerated($bool, $code){
            $this->prepare("UPDATE $this->table SET is_generated = ? WHERE bin_code = ?")->execute([$bool, $code]);
        }
    }
?>

