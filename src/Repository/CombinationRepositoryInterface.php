<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Chunk\Chunks;

interface CombinationRepositoryInterface
{    
    public function saveInChunks();

    public function saveInSingleFile();

    
    
}
