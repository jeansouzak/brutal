<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Combination;

use ArrayObject;
use JeanSouzaK\Brutal\Chunk\Chunk;
use JeanSouzaK\Brutal\Chunk\Chunks;
use JeanSouzaK\Brutal\Chunk\ChunksFactory;
use JeanSouzaK\Brutal\Combination\CombinationsFactory;

class Combinations extends ArrayObject
{

    public function __construct(...$combinations)
    {
        parent::__construct($combinations);
    }


    public function chunk(): Chunks
    {        
        return ChunksFactory::createChunksFromCombinationsArray($this->getArrayCopy());        
    }

    public function toJson()
    {
        $combinations = $this->getArrayCopy();
        return json_encode($combinations);
    }

    
}
