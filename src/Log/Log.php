<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Log;

use JeanSouzaK\Brutal\CLI\ClimateFactory;

class Log
{

    const ERROR = 'error_log';

    public static function error()
    {
        return ClimateFactory::getInstance()->to([self::ERROR, 'out']);
    }


}