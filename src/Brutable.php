<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal;

use JeanSouzaK\Brutal\Chunk\Chunks;
use JeanSouzaK\Brutal\Combination\Combinable;
use JeanSouzaK\Brutal\Combination\Combinations;
use JeanSouzaK\Brutal\Repository\AttackRepositoryInterface;
use JeanSouzaK\Brutal\Repository\CombinationRepositoryInterface;
use JeanSouzaK\Brutal\Repository\LoadRepositoryInterface;
use JeanSouzaK\Brutal\Repository\ReportRepositoryInterface;

interface Brutable
{
    public function generate(Combinable $combinable, array $inputChars, int $size): Combinations;

    public function save(CombinationRepositoryInterface $combinationRepository, $chunk = true): void;

    public function load(LoadRepositoryInterface $loadRepository): Chunks;

    public function attack(AttackRepositoryInterface $attackRepository, Chunks $chunks): array;

    public function report(ReportRepositoryInterface $reportRepository, array $attackResult) : void;
}
