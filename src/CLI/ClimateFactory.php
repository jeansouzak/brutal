<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\CLI;

use JeanSouzaK\Brutal\Log\Log;
use League\CLImate\CLImate;
use League\CLImate\Util\Writer\File;

final class ClimateFactory
{

    private static $climate;



    public static function getInstance(): CLImate
    {
        if (!self::$climate) {
            self::$climate = new CLImate();
            touch('output.log');
            touch('errors.log');            
            $outputWriter = new File('output.log');
            $errorWriter = new File('errors.log');
            self::$climate->output->add(Output::OUTPUT_LOG_FILE, $outputWriter);
            self::$climate->output->add(Log::ERROR, $errorWriter);
            self::$climate->addArt('art');
        }
        return self::$climate;
    }
}
