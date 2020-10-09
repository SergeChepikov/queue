<?php
/**
 * Consumer очереди
 * @author SergeChepikov
 */
require_once __DIR__ . '/vendor/autoload.php';

use App\AMQP\MyAMQPConnection;
use App\Event;
use App\Log;
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $options = getopt("", ["process:"]);
    $numOfProcess = $options['process'] ?? 0;

    Log::add("Start consumer for queue events_" . $numOfProcess, 'result.log');

    $connection = new MyAMQPConnection();
    $channel = $connection->channel();
    $channel->queue_declare('events_' . $numOfProcess, false, false, false, false);

    $callback = function ($msg) {
        $event = Event::convertFromText($msg);
        $event->process();
    };

    $channel->basic_consume('events_' . $numOfProcess, '', false, true, false, false, $callback);

    while ($channel->is_consuming()) {
        $channel->wait();
    }
} catch (Throwable $t) {
    Log::add((string)$t);
}
