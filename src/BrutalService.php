<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal;

use Exception;
use JeanSouzaK\Brutal\Chunk\Chunks;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Combination\Combinable;
use JeanSouzaK\Brutal\Combination\Combination;
use JeanSouzaK\Brutal\Combination\Combinations;
use JeanSouzaK\Brutal\Exception\InvalidTermsPathException;
use JeanSouzaK\Brutal\Exception\MapperFileNotFoundException;
use JeanSouzaK\Brutal\Exception\TooLongCombinationsException;
use JeanSouzaK\Brutal\Log\Log;
use JeanSouzaK\Brutal\Repository\AttackRepositoryInterface;
use JeanSouzaK\Brutal\Repository\CombinationRepositoryInterface;
use JeanSouzaK\Brutal\Repository\LoadRepositoryInterface;
use JeanSouzaK\Brutal\Repository\ReportRepositoryInterface;

class BrutalService implements Brutable
{

    public function generate(Combinable $combinable, array $inputChars, int $size): Combinations
    {
        $combinations = new Combinations();
        try {
            Output::display()->bold('Generating combinations');
            $combinations = $combinable->combine($inputChars, $size);
        } catch (TooLongCombinationsException $toE) {
            Log::error()->red('Consider increase memory usage: ' . $toE->getMessage());
        } catch (Exception $e) {
            Log::error()->red('Error on generate combinations: ' . $e->getMessage());
        }
        Output::display()->geen()->underline("{$combinations->count()} combinations generated.");
        return $combinations;
    }

    public function save(CombinationRepositoryInterface $combinationRepository, $chunk = true): void
    {
        Output::display()->bold('Saving combinations');
        try {
            $chunk ? $combinationRepository->saveInChunks() : $combinationRepository->saveInSingleFile();
        } catch (Exception $e) {
            Log::error()->red('Error on save combinations: ' . $e->getMessage());
        }
        Output::display()->green()->underline("Combinations saved.");
    }

    public function load(LoadRepositoryInterface $loadRepository): Chunks
    {
        Output::display()->bold('Loading combinations');
        $chunks = new Chunks([]);
        try {
            $chunks = $loadRepository->loadChunks();
        } catch (InvalidTermsPathException $itpE) {
            Log::error()->red('Invalid Path: ' . $itpE->getMessage());
        } catch (MapperFileNotFoundException $mfE) {
            Log::error()->red('Invalid Mapper File: ' . $mfE->getMessage());
        } catch (Exception $e) {
            Log::error()->red('Error on load combinations: ' . $e->getMessage());
        }
        Output::display()->geen()->underline("{$chunks->count()} chunks loaded.");
        return $chunks;
    }

    public function attack(AttackRepositoryInterface $attackRepository, Chunks $chunks): array
    {
        Output::display()->bold('Attacking target');
        $attackResult = [];
        try {
            $attackResult = $attackRepository->attack($chunks);
            Output::display()->geen()->underline("Attack finished.");
        } catch (Exception $e) {
            Log::error()->red('Error on attack: ' . $e->getMessage());
        }
        return $attackResult;
    }

    public function report(ReportRepositoryInterface $reportRepository, array $attackResult): void
    {
        Output::display()->bold('Brutal Result:');
        $reportRepository->report($attackResult);
    }
}
