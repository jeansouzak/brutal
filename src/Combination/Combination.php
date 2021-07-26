<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Combination;

use JsonSerializable;

class Combination implements JsonSerializable {

    private $term;


    public function __construct(string $term)
    {
        $this->term = $term;
    }


    public function __toString() : string
    {
        return $this->term;
    }

    public function getTerm() : string 
    {
        return $this->term;
    }

    public function setTerm(string $term)
    {
        $this->term = $term;
    }

    public function jsonSerialize() {
        return [
            'term' => $this->term            
        ];
    }

}