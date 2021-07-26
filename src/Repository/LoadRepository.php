<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Repository;

use Amp\File\Driver\BlockingDriver;
use Amp\File\Filesystem;
use JeanSouzaK\Brutal\Chunk\Chunk;
use JeanSouzaK\Brutal\Chunk\Chunks;
use JeanSouzaK\Brutal\Chunk\ChunksFactory;
use JeanSouzaK\Brutal\Chunk\ChunksMapper;
use JeanSouzaK\Brutal\CLI\Output;
use JeanSouzaK\Brutal\Exception\InvalidTermsPathException;
use JeanSouzaK\Brutal\Exception\MapperFileNotFoundException;

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;

class LoadRepository implements LoadRepositoryInterface
{

    private $path;    

    public function __construct(string $path)
    {
        $this->fileSystem = new Filesystem(new BlockingDriver);
        $this->path = $path;        
    }   

    public function loadChunks(): Chunks
    {        
        if (!wait($this->fileSystem->isDirectory($this->path))) {            
            Output::verbose()->out('Loading from single combination file');
            $content = wait($this->fileSystem->read($this->path));
            $combinations = json_decode($content);
            $combinations = $combinations ? explode("\n", $content) : [];
            return ChunksFactory::createChunksFromCombinationsArray($combinations);
        }
        if ($this->fileSystem->isDirectory($this->path)) {
            Output::verbose()->out('Loading from chunks combination directory');
            $chunkMapPath = $this->path . '/' . Chunk::CHUNK_MAP_NAME;
            if (!wait($this->fileSystem->isFile($chunkMapPath))) {
                throw new MapperFileNotFoundException("Mapper file $chunkMapPath not found");
            }
            
            $chunkMap = wait($this->fileSystem->read($chunkMapPath));            
            $chunkNames = explode("\n", $chunkMap);            
            $termsPath = $this->path;
            Output::verbose()->out('Starting parallel loading files');
            $decodedContent[] = wait((parallelMap(array_filter($chunkNames), function ($chunk) use ($termsPath) {
                $chunkContent = file_get_contents($termsPath . '/' . $chunk);
                return $this->isJsonFormat($chunkContent) ? json_decode($chunkContent) : explode("\n", $chunkContent);                
            })));
            Output::verbose()->out('Parsing chunks');
            $chunks = array_key_exists(0, $decodedContent) ? ChunksMapper::convertParsedChunkArrayToChunks($decodedContent[0]) : new Chunks([]);
            
            return $chunks;
            
        }
        throw new InvalidTermsPathException("Invalid path $termsPath");
    }


    private function isJsonFormat(string $content) : bool
    {
        return substr( $content, 0, 2 ) === "[{";
    }
}
