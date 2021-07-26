<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Chunk;

use ArrayObject;
use JeanSouzaK\Brutal\Combination\CombinationsFactory;

final class ChunksFactory {
    

    public static function createChunksFromCombinationsArray(array $combinations) : Chunks
    {
        $rawChunks = array_chunk($combinations, Chunk::CHUNK_SIZE);
        $rawKeys = array_keys($rawChunks);
        
        $chunks = new Chunks();
        foreach ($rawKeys as $rawKey) {            
            $chunks->append(new Chunk((string) $rawKey, CombinationsFactory::createCombinationsFromObjectArray($rawChunks[$rawKey])));
        }

        return $chunks;
    }

  
}