<?php

require 'vendor/autoload.php';

use React\Socket\ConnectionInterface;
use React\Socket\Server;

$loop = React\EventLoop\Factory::create();

$server = new Server('127.0.0.1:8080', $loop);

$server->on('connection', function (ConnectionInterface $connection) use ($loop) {
    echo "New connection from {$connection->getRemoteAddress()}\n";

    $connection->on('data', function ($data) use ($connection) {
        echo "Received: {$data}\n";
        //$connection->write("Server: You sent: {$data}");
    });

    $connection->on('close', function () use ($connection) {
        echo "Connection closed: {$connection->getRemoteAddress()}\n";
    });

    // Send a message to the client every 2 seconds
    $loop->addPeriodicTimer(1, function () use ($connection) {
        $message = file_get_contents('server.txt');
        if (!empty($message)) {
            echo "Sending: {$message}\n";
            // Clear the contents of the 'message.txt' file
            file_put_contents('server.txt', '');
            $connection->write($message);
        }
    });
});

echo "Server listening on 127.0.0.1:8080\n";

$loop->run();
