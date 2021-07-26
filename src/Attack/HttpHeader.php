<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Attack;

class HttpHeader implements TermOverrideInterface
{

    private $headers;

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function override(string $term): array
    {
        $newHeaders = $this->headers;
        foreach ($this->headers as $key => $value) {            
            $newValue = $value;
            if ($value == '$term') {
                $newValue = $term;
                $newHeaders[$key] = $newValue;
            }
            if ($key == '$term') {
                $newHeaders[$term] = $newValue;
                unset($newHeaders[$key]);
            }
        }        
        return $newHeaders;
    }
}
