<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Chunk;

use ArrayObject;

class Chunks extends ArrayObject
{

    public function __construct(...$chunks)
    {
        parent::__construct($chunks);
    }



}