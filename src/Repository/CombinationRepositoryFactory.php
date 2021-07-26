<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Combination\Combinations;

final class CombinationRepositoryFactory {


    public static function createRepository(Combinations $combinations, string $from, int $format = CombinationRepository::FORMAT_SERIALIZER) : CombinationRepositoryInterface
    {
        return new CombinationRepository($combinations, $from, $format);
    }
}