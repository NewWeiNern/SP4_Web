<?php
require_once "../php/class/bin.class.php";

@$code = $_GET["code"];
$bin = new Bin();
$data = "";

if($code){
    // Get the location data
    $data = $bin->getLocationData($code)['bin_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/SP4_Web/"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($data) ? "Compost Bin Not Found!" : "Compost Bin @".$data; ?></title>
    <script src="js/vendor/jquery-3.4.1.min.js"></script>
</head>
<body>
    <?php if(!empty($code) && !empty($data)): ?>
    <input type="button" onclick="process()" value="Simulate Item in Collection Bin"/>
    <input type="hidden" value="<?= $code;?>" name="code_loc"/>
    <img id="qrCode" name="qrCode" style="height:150px; width:150px;"/>
    <script>
        let socket = new WebSocket("ws://localhost:8080/");
        socket.onopen = e=>{
            console.log(e);
        }
        socket.onmessage = e=>{
            console.log(e);
        }
    </script>
    <?php else:?>
        Bin not found!
    <?php endif;?>
</body>
</html>
