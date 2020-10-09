<?php
/**
 * Эмуляция получения от Веб-API событий и отправка их в очередь на исполнение
 * @author SergeChepikov
 */
require_once __DIR__ . '/vendor/autoload.php';

use App\AMQP\MyAMQPConnection;
use App\Event;
use App\Log;
use App\QueueManager;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = new MyAMQPConnection();
$channel = $connection->channel();
$queue = new QueueManager($channel);

/** @var $accountNum кол-во аккаунтов */
$accountNum = 1000;
$eventsProcessed = 0;

for ($accountId = 0; $accountId < $accountNum; $accountId++) {
    /** @var $eventsCount кол-во событий для данного аккаунта */
    $eventsCount = rand(1, 10);
    echo $eventsCount;

    for ($eventId = 0; $eventId < $eventsCount; $eventId++) {
        try {
            $eventData = [
                'accountId' => $accountId,
                'eventId' => $eventId
            ];
            $queue->add(new Event($eventData));

            echo "account=" . $accountId . " event=" . $eventId . " sent" . "\n";
            $eventsProcessed++;
        } catch (Throwable $t) {
            Log::add((string)$t);
        }
    }
}

echo "Sent " . $eventsProcessed . " events\n";
$channel->close();
$connection->close();
