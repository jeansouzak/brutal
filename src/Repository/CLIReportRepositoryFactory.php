<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Attack\HttpOptions;

final class CLIReportRepositoryFactory {


    public static function createRepository(HttpOptions $httpOptions) : CLIReportRepository
    {
        return new CLIReportRepository($httpOptions);
    }
}