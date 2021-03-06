<?php
require_once "../php/class/bin.class.php";
require_once "../php/lib/qrcode/qrlib.php";

@$code = $_GET["code"]; // code for location
$bin = new Bin();
$name = "";

$cgc = md5(uniqid(rand())); // content generated code - used for unique identification of QR
if($code){ // prevent any code from being inserted
    settype($code, "integer");
    $name = $bin->getLocationData($code)['bin_name']; // Get the location data
    $info = $bin->getInfo($code); // Get info to verify if it's scanned.

    if(!$info["is_generated"]){ // Generates new QR Code
        $data = ["time"=>time(), "cgc"=>$cgc, "code"=>$code];
        $bin->update(json_encode($data), 1, $code);
    }
    else{
        $data = json_decode($info["bin_json"]);
    }
    
    $base64 = BIN::generateQR([$data]); // Generate QR must be here due to output buffer
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/SP4_Web/"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($name) ? "Compost Bin Not Found!" : "Compost Bin @".$name; ?></title>
    <script src="js/vendor/jquery-3.4.1.min.js"></script>
    <script>const code=<?= empty($code) ? 0 : $code;?>;</script>
</head>
<body>
    <?php if(!empty($code) && !empty($name)): ?>
    <img id="qrCode" name="qrCode" src="data:image/png;base64,<?= $base64;?>" style="height:150px; width:150px;"/>
    <script src="/SP4_Web/bin/js/bin.js"></script>
    <script>
        const bin = new JSBind();
    </script>
    <?php else:?>
        Bin not found!
    <?php endif;?>
</body>
</html>
