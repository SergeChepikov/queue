<?php

namespace App\AMQP;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class MyAMQPConnection
 * @author SergeChepikov
 */
class MyAMQPConnection extends AMQPStreamConnection
{
     public function __construct()
     {
         parent::__construct(
             $_ENV["RABBITMQ_HOST"],
             $_ENV["RABBITMQ_PORT"],
             $_ENV["RABBITMQ_DEFAULT_USER"],
             $_ENV["RABBITMQ_DEFAULT_PASS"]
         );
     }
}
