<?php

namespace App\Websocket;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class WebSocketPusher
 * @package App\Websocket
 */
class WebSocketPusher implements MessageComponentInterface
{
    /**
     * @var SplObjectStorage $companyConnections
     */
    private $companyConnections;

    /**
     * @var SplObjectStorage $usersConnections
     */
    private $usersConnections;

    /**
     * WebSocketPusher constructor.
     */
    public function __construct()
    {
        $this->companyConnections = new SplObjectStorage();
        $this->usersConnections = new SplObjectStorage();
    }

    /**
     * @param Collection $companies
     */
    public function onCompaniesUpdate(Collection $companies)
    {
        foreach ($this->companyConnections as $connection) {
            $connection->send('New info on topic \'companies\' : ' . $companies);
        }
    }

    /**
     * @param Collection $users
     */
    public function onUserRegistration(Collection $users)
    {
        foreach ($this->usersConnections as $connection) {
            $connection->send('New info on topic \'users\' : ' . $users);
        }
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
    }

    /**
     * @param ConnectionInterface $conn
     * @param MessageInterface $msg
     */
    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        $jsonMsg = json_decode($msg);
        $token = $jsonMsg->token;

        $tokenRequest = new Request([
            'token' => $token,
        ]);

        try {
            JWTAuth::setRequest($tokenRequest);
            if (!JWTAuth::parseToken()->check()) {
                $conn->send('You\'re unauthorized to subscribe');
                $conn->close();
                return;
            }
        } catch (JWTException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        $topics = $jsonMsg->topics;
        switch ($topics) {
            case ['companies']:
                $this->companyConnections->attach($conn);
                $conn->send('You\'re now subscribed to topic \'companies\'');
                break;
            case ['users']:
                $this->usersConnections->attach($conn);
                $conn->send('You\'re now subscribed to topic \'users\'');
                break;
            case ['companies', 'users']:
                $this->companyConnections->attach($conn);
                $this->usersConnections->attach($conn);
                $conn->send('You\'re now subscribed to topics \'companies\' and \'users\'');
                break;
            default:
                break;
        }
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
    }
}
