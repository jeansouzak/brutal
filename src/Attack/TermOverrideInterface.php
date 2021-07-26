<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Attack;

interface TermOverrideInterface {
    
    public function override(string $term) : Array;
}