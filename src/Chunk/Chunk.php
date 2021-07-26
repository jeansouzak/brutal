<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Chunk;

use JeanSouzaK\Brutal\Combination\Combinations;

class Chunk
{
    const CHUNK_SIZE = 256;
    const CHUNK_MAP_NAME = 'chunk-mapper';

    private $key;
    private $combinations;
    
    public function __construct(string $key, Combinations $combinations)
    {
        $this->key = $key;
        $this->combinations = $combinations;        
    }

    public function getKey() : string
    {
        return $this->key;
    }

    public function getCombinations() : Combinations
    {
        return $this->combinations;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function setCombinations(Combinations $combinations)
    {
        $this->combinations = $combinations;
    }
    
}
