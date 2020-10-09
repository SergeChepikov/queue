<?php

namespace App;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class Event
 * @author SergeChepikov
 */
class Event
{
    public array $info;

    public function __construct(array $info)
    {
        $this->info = $info;
    }

    public static function convertFromText(AMQPMessage $text): Event
    {
        return new Event(json_decode($text->body, true));
    }

    /**
     * Обработка события
     */
    public function process(): void
    {
        Log::add(
            "Received: account=" . $this->info['accountId'] . " event=" . $this->info['eventId'],
            'result.log'
        );
        sleep(1);
        Log::add(
            "Processed: account=" . $this->info['accountId'] . " event=" . $this->info['eventId'],
            'result.log'
        );
    }
}
