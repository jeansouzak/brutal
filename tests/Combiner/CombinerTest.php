<?php declare(strict_types=1);

use JeanSouzaK\Brutal\Combiner\Combiner;
use JeanSouzaK\Brutal\Exception\TooLongCombinationsException;
use PHPUnit\Framework\TestCase;

final class CombinerTest extends TestCase
{
    public function testSingleCombinations(): void
    {
        $combinations = Combiner::combine(['a', 'b', 'c'], 2);
        
        $this->assertEquals($combinations, [
            'aa',
            'ab',
            'ac',
            'ba',
            'bb',
            'bc',
            'ca',
            'cb',
            'cc'
        ]);
        
    }

    public function testTooLongCombinations(): void
    {
        $this->expectException(TooLongCombinationsException::class);
        Combiner::combine(['a', 'b', 'c', 'd', 'e'], 10);        
    }

   
}