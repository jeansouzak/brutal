<?php

declare(strict_types=1);

namespace JeanSouzaK\Brutal\Attack;

class HttpOptions
{
    private $target;    

    private $method;

    private $format;

    private $body;

    private $headers;

    public function __construct(string $target, string $method, string $format, array $body, array $headers = [])
    {
        $this->target = $target;        
        $this->method = $method;
        $this->format = $format;
        $this->body = new HttpBody($body);
        $this->headers = new HttpHeader($headers);
    }


    public function getTarget() : string
    {
        return $this->target;
    }

    public function setTarget(string $target)
    {
        $this->target = $target;
    }


    public function getMethod() : string
    {
        return $this->method;
    }

    public function setMethod(string $method)
    {
        return $this->method = $method;
    }

    public function getFormat() : string
    {
        return $this->format;
    }

    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    public function getBody() : HttpBody
    {
        return $this->body;
    }

    public function setBody(HttpBody $body)
    {
        $this->body = $body;
    }

    public function getHeaders() : HttpHeader
    {
        return $this->headers;
    }

    public function setHeaders(HttpHeader $headers)
    {
        $this->headers = $headers;
    }


}
