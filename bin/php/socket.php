<?php
/**
 * Due to iPhone not allowing user to access to Camera without https
 * Socket will be unused!
 * 
 */

// exec("C:\\xampp\php\php.exe socket.php");
set_time_limit(0);

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require_once "../php/lib/Ratchet/autoload.php";
require_once "../php/class/bin.class.php";

class Chat implements MessageComponentInterface{
    protected $clients;
    protected $users;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(\Ratchet\ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onClose(\Ratchet\ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onMessage(\Ratchet\ConnectionInterface $from, $msg)
    {
        print(var_dump($from->httpRequest->getUri()->getPath()));
        $bin = new Bin();
        $from_id = $from->resourceId;
        $data = json_decode($msg);
        $type = $data->type;
        $qr = $data->QR;
        switch($type){
            case "bin" : 

            break;
            case "app" : 
                $from->send(json_encode(array("read"=>"Scanned Location: ".$bin->getLocationData($qr->code)["bin_name"])));
                foreach($this->clients as $client){
                    print($client->httpRequest->getUri()->getPath());
                    if($from != $client){
                        $client->send(json_encode(array("read"=>"Scanned From: $data->user")));
                    }
                }
            break;
        }
    }

    public function onError(\Ratchet\ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}

$server = IoServer::factory(new HttpServer(new WsServer(new Chat())), 8080);
$server->run();
?>