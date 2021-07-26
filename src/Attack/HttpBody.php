<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Attack;

class HttpBody implements TermOverrideInterface {

    private $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function override(string $term) : Array
    {        
        $newBody = $this->body;
        foreach ($this->body as $key => $value) {            
            $newValue = $value;
            if ($value == '$term') {
                $newValue = $term;
                $newBody[$key] = $newValue;
            }
            if ($key == '$term') {
                $newBody[$term] = $newValue;
                unset($newBody[$key]);
            }
        }        
        return $newBody;
    }
}