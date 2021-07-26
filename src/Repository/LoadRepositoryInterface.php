<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Chunk\Chunks;

interface LoadRepositoryInterface
{    
   
    public function loadChunks() : Chunks;

    
}
