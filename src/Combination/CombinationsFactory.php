<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Combination;

use ArrayObject;

final class CombinationsFactory {


    public static function createCombinationsFromCharArray(array $chars) : Combinations
    {
        $combinations = new Combinations();

        foreach ($chars as $char) {
            $combinations->append(new Combination($char));
        }

        return $combinations;
    }

    public static function createCombinationsFromObjectArray(array $terms) : Combinations
    {
        $combinations = new Combinations();
        foreach ($terms as $term) {
            $combination = $term instanceof Combination ? $term : new Combination($term->term);
            $combinations->append($combination);
        }

        return $combinations;
    }
}