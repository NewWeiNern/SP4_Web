<?php
require_once "../php/class/bin.class.php";

$bin = new Bin();
$data = $bin->getInfo($_POST["code"]);

$data["bin_json"] = json_decode($data["bin_json"], JSON_NUMERIC_CHECK);
echo json_encode($data, JSON_NUMERIC_CHECK);
header("Content-Type:application/json");

?>