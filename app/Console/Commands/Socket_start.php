<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use React\ZMQ\Context;
use React\EventLoop\Factory;
use App\Http\Controllers\Pusher;
use React\Socket\Server;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Wamp\WampServer;
use ZMQ;

class Socket_start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:server-start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the socket server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Socket server initiated!");

        $server_socket_address = env('SERVER_SOCKET_ADDRESS');
        $client_socket_address = env('CLIENT_SOCKET_ADDRESS');

        $loop   = Factory::create();
        $pusher = new Pusher;

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $context = new Context($loop);
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind($server_socket_address); // Binding to 127.0.0.1 means the only client that can connect is itself
        $pull->on('message', array($pusher, 'on_message_submit'));

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new Server($client_socket_address, $loop); // Binding to 0.0.0.0 means remotes can connect
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WampServer(
                        $pusher
                    )
                )
            ),
            $webSock
        );

        $loop->run();
    }
}
