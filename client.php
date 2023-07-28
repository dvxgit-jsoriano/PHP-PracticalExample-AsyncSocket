<?php

use React\EventLoop\Factory;
use React\Socket\Connector;

require 'vendor/autoload.php';

$loop = Factory::create();
$connector = new Connector($loop);

$connector->connect('tcp://127.0.0.1:8080')->then(function (\React\Socket\ConnectionInterface $connection) use ($loop) {
    echo "Connected to the server\n";

    $connection->on('data', function ($data) {
        echo "Received: {$data}\n";
        //echo "Received from server: {$data}\n";
    });

    // Send a message to the server every 1 seconds
    $loop->addPeriodicTimer(1, function () use ($connection) {
        $message = file_get_contents('client.txt');
        if (!empty($message)) {
            echo "Sending: {$message}\n";
            // Clear the contents of the 'message.txt' file
            file_put_contents('client.txt', '');
            $connection->write($message);
        }
    });
});

$loop->run();
