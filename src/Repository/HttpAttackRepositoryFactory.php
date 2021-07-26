<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use JeanSouzaK\Brutal\Attack\HttpOptions;

final class HttpAttackRepositoryFactory {


    public static function createRepository(HttpOptions $httpOptions) : HttpAttackRepository
    {
        return new HttpAttackRepository($httpOptions);
    }
}