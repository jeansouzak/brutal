<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Attack\HttpOptions;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Combination\Combination;
use JeanSouzaK\Brutal\Report\Report;

class CLIReportRepository implements ReportRepositoryInterface
{
    private $httpOptions;

    public function __construct(HttpOptions $httpOptions)
    {
        $this->httpOptions = $httpOptions;
    }

    public function report(array $attackResult): void
    {        
        $report = new Report('', '<red>FALSE<red>', $this->httpOptions->getTarget(), $this->httpOptions->getMethod());
        foreach ($attackResult as $attackResult) {            
            if ($attackResult instanceof Combination) {
                $report->term = $attackResult->getTerm();
                $report->result = '<green>TRUE<green>';
            }
        }
        $reportScheme = [
            $report
        ];
        Output::display()->table($reportScheme);
        Output::display()->animation('brutal')->speed('2000')->scroll('right');
    }
}
