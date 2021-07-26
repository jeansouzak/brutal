<?php
declare(strict_types=1);

namespace JeanSouzaK\Brutal\Report;



class Report {    

    public $term;

    public $result;

    public $target;

    public $method;

    public function __construct(string $term, string $result, string $target, string $method)
    {
        $this->term = $term;
        $this->result = $result;
        $this->target = $target;
        $this->method = $method;
    }
   


}