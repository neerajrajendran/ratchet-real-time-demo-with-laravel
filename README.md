# ratchet-real-time-demo-with-laravel

Laravel project demonstrating the usage of Ratchet library 
Server socket to server  socket and server socket to web socket communication

Initial Setup

1. Install ZMQ and php-zmq extension

   Refer : https://eole-io.github.io/sandstone-doc/install-zmq-php-linux
   
2. Run composer install

3. Edit your Laravel env file:
   Add following lines:
   
   SERVER_SOCKET_ADDRESS = tcp://127.0.0.1:5555
   
   CLIENT_SOCKET_ADDRESS = 127.0.0.1:8080
   
   SUBSCRIBED = admin
   
   (you can change the port accordingly)
   
4. Run: 'php artisan' command and check for socket:server-start

5. Run: 'php artisan socket:server-start'

6. In another terminal run 'php artisan serve'

7. Run your project and start sending messages

Notes : Socket server file is under /app/Console/Commands/Socket_start.php , this file is configured with php artisan command

Refer : http://socketo.me/ for more information
