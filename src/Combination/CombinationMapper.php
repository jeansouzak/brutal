<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Combination;

use JeanSouzaK\Brutal\Combination\Combination;
use JeanSouzaK\Brutal\Combination\Combinations;

use JeanSouzaK\Brutal\Tool\Hydrator;

final class CombinationMapper {
    

    public static function convertCombinationsArrayToCombinations(array $combinationsArray) : Combinations
    {        
        $combinations = new Combinations();
        foreach ($combinationsArray as $combinationArray) {            
            $combinations->append(Hydrator::toObject($combinationArray, new Combination('')));
        }

        return $combinations;
    }

  
}