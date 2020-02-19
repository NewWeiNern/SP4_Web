<?php
include_once "../php/lib/qrcode/qrlib.php";

QRcode::png(http_build_query($_POST));

header("Content-Type:image/png");
?>