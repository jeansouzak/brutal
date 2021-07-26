<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Combination;



interface Combinable
{

    public function combine(array $inputChars, int $size, Combinations $combinations = null): Combinations;
   
}
