<?php

namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Менеджер очереди
 *
 * @author SergeChepikov
 */
class QueueManager
{
    private AMQPChannel $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Добавление события в очередь исполнения
     * @param Event $event
     */
    public function add(Event $event) {
        $eventInfo = $event->info;
        $msg = new AMQPMessage(json_encode($eventInfo));

        // Определяем нужную очередь по идентификатору аккаунта
        $process = ($eventInfo['accountId'] % $_ENV['PARALLEL_PROCESSES_COUNT']);

        $this->channel->basic_publish($msg, '', 'events_' . $process);
    }
}
