<?php
/**
 * Запуск необходимого кол-ва consumer-ов
 * @author SergeChepikov
 */
use App\AMQP\MyAMQPConnection;
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = new MyAMQPConnection();
$channel = $connection->channel();

for ($processId = 0; $processId < $_ENV['PARALLEL_PROCESSES_COUNT']; $processId++) {
    // запускаем consumer-ы в фоне
    exec("php consumer.php --process=" . $processId . " >> /dev/null &");
}
