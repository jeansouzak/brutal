<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use Amp\CancellationTokenSource;
use Amp\Http\Client\HttpClientBuilder;
use Exception;
use JeanSouzaK\Brutal\Attack\HttpOptions;
use JeanSouzaK\Brutal\Chunk\Chunks;

use Amp\MultiReasonException;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Exception\InvalidMethodException;
use JeanSouzaK\Brutal\Exception\InvalidURLException;
use JeanSouzaK\Brutal\Log\Log;

use function Amp\call;
use function Amp\Promise\some;
use function Amp\Promise\wait;


class HttpAttackRepository implements AttackRepositoryInterface
{
    private $httpOptions;

    public function __construct(HttpOptions $httpOptions)
    {
        $this->httpOptions = $httpOptions;
    }


    public function attack(Chunks $chunks, bool $stopOnFirstFound = false)
    {
        $attackResult = [];
        try {
            $this->isValidMethod();
            $this->isValidTarget();
        } catch (InvalidURLException $iue) {
            Log::error()->red('Check target URL: ' . $iue->getMessage());
        } catch (InvalidMethodException $ime) {
            Log::error()->red('Check method [POST, PUT, PATCH, GET]: ' . $ime->getMessage());
        }

        $client = HttpClientBuilder::buildDefault();
        $tokenSource = new CancellationTokenSource;
        $token = $tokenSource->getToken();

        $promises = [];
        $httpOptions = $this->httpOptions;
        $requestDirector = new RequestDirector();

        foreach ($chunks as $chunk) {
            $promises[] = call(static function () use ($chunk, $client, $httpOptions, $token, $tokenSource, $requestDirector) {
                foreach ($chunk->getCombinations() as $combination) {
                    $ampBuilder = new AmpRequestBuilder($combination->getTerm(), $httpOptions);
                    $preparedRequest = $requestDirector->build($ampBuilder);
                    Output::verbose()->out('Sending builded request');               
                    $response = yield $client->request($preparedRequest, $token);
                    $status = $response->getStatus();
                    if ($status != 200) {                        
                        Output::display()->red("Result of request term $combination = FALSE");
                        continue;
                    }
                    $tokenSource->cancel();                    
                    Output::display()->green("Result of request term $combination = TRUE");
                    return $combination;
                }
                return false;
            });
        }

        try {
            Output::verbose()->out('Waiting some HTTP status 200');
            $attackResult = wait(some($promises, 1));
        } catch (MultiReasonException $ex) {
            Log::error()->red('Error on parallel attack target: ' . $ex->getMessage());
            Log::error()->dump($ex->getReasons());            
        }
        return $attackResult;
    }

    private function isValidTarget()
    {
        if (filter_var($this->httpOptions->getTarget(), FILTER_VALIDATE_URL) === FALSE) {
            throw new InvalidURLException('Target is not a valid URI format');
        }
    }

    private function isValidMethod()
    {
        if (!in_array($this->httpOptions->getMethod(), ['POST', 'PUT', 'PATCH', 'GET'])) {
            throw new InvalidMethodException('Method not acceptable');
        }
    }
}
