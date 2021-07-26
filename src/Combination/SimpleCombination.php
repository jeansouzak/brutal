<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Combination;

use JeanSouzaK\Brutal\Exception\TooLongCombinationsException;

class SimpleCombination implements Combinable
{


    public function combine(array $inputChars, int $size, Combinations $combinations = null): Combinations
    {        
        if (pow(count($inputChars), $size) > 100000) {
            throw new TooLongCombinationsException("Number of characters or size too long");
        }

        $combinations = $combinations != null ? $combinations : CombinationsFactory::createCombinationsFromCharArray($inputChars);

        if ($size == 1) {
            return $combinations;
        }

        $newCombinations = new Combinations();

        foreach ($combinations as $combination) {
            foreach ($inputChars as $char) {
                $newCombinations->append(new Combination($combination . $char));
            }
        }

        return self::combine($inputChars, $size - 1, $newCombinations);
    }
}
