<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;


final class LoadRepositoryFactory {


    public static function createRepository(string $path) : LoadRepository
    {
        return new LoadRepository($path);
    }
}