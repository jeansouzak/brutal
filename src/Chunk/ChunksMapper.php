<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Chunk;

use JeanSouzaK\Brutal\Combination\Combination;
use JeanSouzaK\Brutal\Combination\CombinationMapper;
use JeanSouzaK\Brutal\Combination\CombinationsFactory;


final class ChunksMapper {
    

    public static function convertParsedChunkArrayToChunks(array $parsedChunks) : Chunks
    {   
        $chunks = new Chunks();
        foreach ($parsedChunks as $key => $chunk) {             
            if (array_key_exists(0, $chunk) && is_string($chunk[0])) {
                $chunks->append(new Chunk((string) $key, CombinationsFactory::createCombinationsFromCharArray($chunk)));
            } else {
                $chunks->append(new Chunk((string) $key, CombinationsFactory::createCombinationsFromObjectArray($chunk)));
            }            
        }

        return $chunks;
    }

  
}