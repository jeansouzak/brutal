<?php

use JeanSouzaK\Brutal\Attack\HttpFormat;
use JeanSouzaK\Brutal\Attack\HttpOptions;
use JeanSouzaK\Brutal\BrutalService;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Combination\SimpleCombination;
use JeanSouzaK\Brutal\Repository\CLIReportRepositoryFactory;
use JeanSouzaK\Brutal\Repository\CombinationRepository;
use JeanSouzaK\Brutal\Repository\CombinationRepositoryFactory;
use JeanSouzaK\Brutal\Repository\HttpAttackRepositoryFactory;
use JeanSouzaK\Brutal\Repository\LoadRepositoryFactory;
use JeanSouzaK\Brutal\Repository\ReportRepositoryFactory;

require __DIR__ . '/vendor/autoload.php';
ini_set('memory_limit', '-1');

Output::display()->animation('brutal')->speed('2000')->scroll('left');


$from = '/tmp/brutal';
$brutalService = new BrutalService();
$MODE_SINGLE = 0;
$MODE_CHUNK = 1;

$combinations = $brutalService->generate(new SimpleCombination(), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], 3);
$combinationRepository = CombinationRepositoryFactory::createRepository($combinations, $from, CombinationRepository::FORMAT_TEXT);
$brutalService->save($combinationRepository, $MODE_CHUNK);
$loadRepository = LoadRepositoryFactory::createRepository($from);
$chunks = $brutalService->load($loadRepository);
$httpOptions = new HttpOptions('http://localhost:3000/test_server.php', 'POST', HttpFormat::JSON, ['test' => '$term']);
$httpAttackRepository = HttpAttackRepositoryFactory::createRepository($httpOptions);
$attackResult = $brutalService->attack($httpAttackRepository, $chunks);
$reportRepository = CLIReportRepositoryFactory::createRepository($httpOptions);
$brutalService->report($reportRepository, $attackResult);
