<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;


interface ReportRepositoryInterface
{

    public function report(array $attackResult): void;
}
