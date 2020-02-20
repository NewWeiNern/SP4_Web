<?php
include_once "../php/lib/qrcode/qrlib.php";
$arr = $_POST;
$arr["timestamp"] = time();
QRcode::png(http_build_query($arr));
header("Content-Type:image/png");
?>