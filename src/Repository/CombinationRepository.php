<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use Amp\File\Driver\BlockingDriver;
use Amp\File\Filesystem;
use Amp\MultiReasonException;
use ArrayObject;
use JeanSouzaK\Brutal\Chunk\Chunk;
use JeanSouzaK\Brutal\Chunk\Chunks;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Combination\Combinations;
use JeanSouzaK\Brutal\Log\Log;

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;

class CombinationRepository implements CombinationRepositoryInterface
{
    const FORMAT_SERIALIZER = 1;
    const FORMAT_TEXT = 2;
    const COMBIATION_SINGLE_FILE_NAME = 'combinations.txt';

    private $combinations;
    private $from;
    private $fileSystem;
    private $format;

    public function __construct(Combinations $combinations, string $from, int $format = self::FORMAT_SERIALIZER)
    {
        $this->combinations = $combinations;
        $this->from = $from;
        $this->fileSystem = new Filesystem(new BlockingDriver);
        $this->format = $format;
        $this->createTargetFolderIfNotExists();
    }

    public function saveInChunks()
    {
        Output::verbose()->out('Generating chunks');
        $chunks = $this->combinations->chunk(Chunk::CHUNK_SIZE);
        Output::verbose()->out("{$chunks->count()} files to generate.");        
        $this->cleanExistingChunkMapperFile();
        $this->generateNewChunkMapper($chunks);
        $format = $this->format;
        try {
            Output::verbose()->out('Parallel saving chunks combinations files');
            wait((parallelMap($chunks->getArrayCopy(), function ($chunk) use ($format) {
                $chunkCombinations = $chunk->getCombinations();
                Output::verbose()->out("Generating {$chunk->getKey()}.txt chunk file");
                if ($format == CombinationRepository::FORMAT_SERIALIZER) {
                    file_put_contents($this->from . '/' . $chunk->getKey() . '.txt', $chunkCombinations->toJson());                    
                } else {
                    file_put_contents($this->from . '/' . $chunk->getKey() . '.txt', implode("\n", $chunkCombinations->getArrayCopy()));
                }                
            })));
        } catch (MultiReasonException $ex) {
            Log::error()->red('Error on parallel generating chunk files ' . $ex->getMessage());
            Log::error()->dump($ex->getReasons());
        }
    }


    public function saveInSingleFile()
    {
        Output::verbose()->out('Saving single combination file');
        file_put_contents($this->from . self::COMBIATION_SINGLE_FILE_NAME, $this->combinations->serialize());
    }

    private function createTargetFolderIfNotExists()
    {
        Output::verbose()->out('Creating folder if not exists');
        if (!file_exists($this->from)) {
            wait($this->fileSystem->createDirectory($this->from));
        }
    }

    private function cleanExistingChunkMapperFile()
    {
        Output::verbose()->out('Cleaning current chunk mapper file');
        $file = $this->from . '/' . Chunk::CHUNK_MAP_NAME;
        if (file_exists($file)) {
            $this->fileSystem->deleteFile($file);
        }
    }

    private function generateNewChunkMapper(Chunks $chunks): void
    {        
        Output::verbose()->out('Generating new chunk mapper file');
        foreach ($chunks as $chunk) {
            file_put_contents($this->from . '/' . Chunk::CHUNK_MAP_NAME, $chunk->getKey() . '.txt' . PHP_EOL, FILE_APPEND);
        }
    }
}
