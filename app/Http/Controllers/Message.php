<?php

namespace App\Http\Controllers;
use ZMQContext;
use ZMQ;
use Illuminate\Http\Request;
use React\ZMQ\Context;
use React\EventLoop\Factory;

class Message extends Controller
{

    public function notify_clients(){
        $category = $_POST["category"];;
        $text = $_POST["message"];
        $response["message"] = $text;
        $response["category"] = $category;
        
        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect(env("SERVER_SOCKET_ADDRESS"));
        $socket->send(json_encode($response));

        echo "Posted successfully!";
    }
}
