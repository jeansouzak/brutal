<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use Amp\Http\Client\Request;
use JeanSouzaK\Brutal\CLI\Output;

class RequestDirector
{

    public function build(HttpRequestBuilderInterface $builder)
    {
        Output::verbose()->out('Building HTTP request');
        $builder->setHeaders();
        $builder->setBody();
        return $builder->getRequest();                
    }


    
}
