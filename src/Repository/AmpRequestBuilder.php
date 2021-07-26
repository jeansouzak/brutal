<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use Amp\Http\Client\Body\FormBody;
use Amp\Http\Client\Body\JsonBody;
use Amp\Http\Client\Request;
use JeanSouzaK\Brutal\Attack\HttpFormat;
use JeanSouzaK\Brutal\Attack\HttpOptions;
use JeanSouzaK\Brutal\CLI\Output;

class AmpRequestBuilder implements HttpRequestBuilderInterface
{

    private $request;
    private $httpOptions;
    private $term;

    public function __construct(string $term, HttpOptions $httpOptions)
    {
        $this->request = new Request($httpOptions->getTarget(), $httpOptions->getMethod());
        $this->httpOptions = $httpOptions;
        $this->term = $term;
    }

    public function setBody()
    {        
        $requestBody = $this->httpOptions->getBody();
        Output::verbose()->out("Trying overriting {$this->term} inside body");
        $bodyTerms = $requestBody->override($this->term);

        if (count($bodyTerms) < 1) {
            return null;
        }
        $body = null;
        if ($this->httpOptions->getFormat() == HttpFormat::JSON) {
            Output::verbose()->out('Setting JSON body');
            $body = new JsonBody($bodyTerms);
        }
        if ($this->httpOptions->getFormat() == HttpFormat::FORM_PARAMS) {
            Output::verbose()->out('Setting FORM_PARAMS body');
            $body = new FormBody();
            $body->addFields($bodyTerms);
        }
        if ($body) {
            $this->request->setBody($body);
        }
    }

    public function setHeaders()
    {
        Output::verbose()->out("Trying overriting {$this->term} inside headers");
        $headerTerms = $this->httpOptions->getHeaders()->override($this->term);
        if (count($headerTerms) > 0) {
            Output::verbose()->out('Setting HEADERs');
            $this->request->setHeaders($headerTerms);
        }
    }

    public function getRequest()
    {
        return $this->request;
    }
}
