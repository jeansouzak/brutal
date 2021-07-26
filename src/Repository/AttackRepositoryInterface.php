<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Chunk\Chunks;

interface AttackRepositoryInterface
{    
   
    public function attack(Chunks $chunks, bool $stopOnFirstFound = false);
    
}
