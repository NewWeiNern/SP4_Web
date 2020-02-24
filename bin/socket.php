<?php
// exec("C:\\xampp\php\php.exe socket.php");
set_time_limit(0);

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require_once "../php/lib/Ratchet/autoload.php";

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
        $from_id = $from->resourceId;
        $data = json_decode($msg);
        $type = $data->type;

        switch($type){
            case "chat" :
                $user_id = $data->user_id;
                $chat_msg = $data->chat_msg;
                $response_from = "<span style='color:#999'><b>".$user_id.":</b> ".$chat_msg."</span><br><br>";
                $response_to = "<b>".$user_id."</b>: ".$chat_msg."<br><br>";
                $from->send(json_encode(array("type"=>$type, "msg"=>$response_from)));

                foreach($this->clients as $client){
                    if($from != $client){
                        $client->send(json_encode(array("type"=>$type, "msg"=>$response_to)));
                    }
                }
            break;
            case "phone" : 
                $from->send(json_encode(array("msg"=>"Hello Phone user")));
                foreach($this->clients as $client){
                    if($from != $client){
                        $client->send(json_encode(array("type"=>$type, "msg"=>"Sent from phone")));
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