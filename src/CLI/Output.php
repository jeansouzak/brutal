<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\CLI;

use JeanSouzaK\Brutal\CLI\ClimateFactory;

class Output
{

    const OUTPUT_LOG_FILE = 'output_log';
    const REGULAR_MODE = 'regular';
    const VERBOSE_MODE = 'verbose';

    public static $TO = [self::OUTPUT_LOG_FILE];

    public static function setVerbose()
    {
        self::$TO = [self::OUTPUT_LOG_FILE, 'out'];
    }

    public static function verbose()
    {
        return ClimateFactory::getInstance()->to(self::$TO);
    }

    public static function display()
    {
        return ClimateFactory::getInstance()->to([self::OUTPUT_LOG_FILE, 'out']);
    }
}
