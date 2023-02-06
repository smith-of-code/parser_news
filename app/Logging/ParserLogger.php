<?php

namespace App\Logging;

use Monolog\Logger;

class ParserLogger
{
    /**
     * Create a custom Monolog instance.
     *
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config){
        $logger = new Logger("ParserLoggerHandler");
        return $logger->pushHandler(new ParserLoggerHandler());
    }
}
