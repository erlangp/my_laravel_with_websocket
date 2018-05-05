<?php

// Erlang Parasu <erlangparasu@gmail.com> 2018-05-05

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketController extends Controller implements MessageComponentInterface
{
    private $cs = [];

    /**
    * When a new connection is opened it will be passed to this method
    * @param  ConnectionInterface $conn The socket/connection that just connected to your application
    * @throws \Exception
    */
    public function onOpen(ConnectionInterface $conn)
    {
        echo 'onOpen: conn.resourceId = ' . $conn->resourceId;
        echo "\n";

        $this->cs[$conn->resourceId] = $conn;
        foreach ($this->cs as $c) {
            if ($c->resourceId === $conn->resourceId) {
                // Skip.
            } else {
                $c->send("Resource ID {$c->resourceId} is connected.");
            }
        }
    }

    /**
    * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
    * @param  ConnectionInterface $conn The socket/connection that is closing/closed
    * @throws \Exception
    */
    public function onClose(ConnectionInterface $conn)
    {
        echo 'onClose: conn.resourceId = ' . $conn->resourceId;
        echo "\n";

        unset($this->cs[$conn->resourceId]);
        foreach ($this->cs as $c) {
            $c->send("Resource ID {$conn->resourceId} is disconnected.");
        }
    }

    /**
    * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
    * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
    * @param  ConnectionInterface $conn
    * @param  \Exception $e
    * @throws \Exception
    */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo 'onError: conn.resourceId = ' . $conn->resourceId;
        echo ". Exception: ";
        echo $e->getMessage();
        echo "\n";

        unset($this->cs[$conn->resourceId]);
        $conn->close();
    }

    /**
    * Triggered when a client sends data through the socket
    * @param  \Ratchet\ConnectionInterface $conn The socket/connection that sent the message to your application
    * @param  string $msg The message received
    * @throws \Exception
    */
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        echo 'onMessage: conn.resourceId = ' . $conn->resourceId;
        echo "\n";

        foreach ($this->cs as $c) {
            if ($c->resourceId === $conn->resourceId) {
                // Skip.
            } else {
                $c->send($msg);
            }
        }
    }
}
