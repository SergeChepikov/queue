<?php

namespace App;

use DateTime;

/**
 * Class Log
 * @author SergeChepikov
 */
class Log
{
    /**
     * @param string $message
     * @param string $file
     */
    public static function add(string $message, string $file = "error.log")
    {
        if (!is_dir('./logs')) {
            mkdir('./logs');
        }
        error_log((new DateTime())->format("y:m:d h:i:s") . " " . $message . "\n", 3, './logs/' . $path);
    }
}
