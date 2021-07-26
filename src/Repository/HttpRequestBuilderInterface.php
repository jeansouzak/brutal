<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use Amp\Http\Client\Request;
use JeanSouzaK\Brutal\Attack\HttpFormat;
use JeanSouzaK\Brutal\Attack\HttpOptions;

interface HttpRequestBuilderInterface
{

    public function setBody();

    public function setHeaders();

    public function getRequest();

    
    

   
}
