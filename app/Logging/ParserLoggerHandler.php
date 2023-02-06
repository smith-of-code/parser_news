<?php

namespace App\Logging;

use DB;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class ParserLoggerHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG, $bubble = true) {
        $this->table = 'parser_logs';
        parent::__construct($level, $bubble);
    }
    protected function write($record):void
    {
//         dd($record['context']['response']);
        if (isset($record['context']['response']) && !empty($record['context']['response'])){
            $data = array(
                'req_method'       => $record['context']['response']->transferStats->getRequest()->getMethod(),
                'req_url'       => $record['context']['response']->transferStats->getHandlerStats()['url'],
                'res_status'         => $record['context']['response']->transferStats->getHandlerStats()['http_code'],
                'res_body'    => $record['context']['response']->transferStats->getResponse()->getBody(),
                'duration'       => $record['context']['response']->transferStats->getHandlerStats()['total_time_us'],
                'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
            );
            DB::connection()->table($this->table)->insert($data);
        }


    }
}
