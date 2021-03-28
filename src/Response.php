<?php 

namespace Http;

class Response 
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;        
    }

    public function getBody() 
    {
        return (string) $this->response->getBody();
    }

    public function toObject(): object
    {
        $body = $this->getBody();

        return json_decode($body) ?? (object) [];
    }

    public function toArray(): array
    {
        $body = (string) $this->getBody();

        return json_decode($body, true) ?? [];
    }

    public function toResponse()
    {
        return $this->response;
    }

    public function __toString(): string
    {
        return $this->getBody();
    }

    public function getCode(): int
    {
        return (int) $this->response->getStatusCode();
    }

    public function isOk(): bool
    {
        return $this->getCode() >= 200 && $this->getCode() < 300;
    }

    public function isClientError(): bool
    {
        return $this->getCode() >= 400 && $this->getCode() < 500;
    }

    public function isServerError(): bool
    {
        return $this->getCode() >= 500;
    }

    public function errorOccurred(): bool
    {
        return $this->isServerError() || $this->isClientError();
    }

    public function getContentType(): ?string
    {
        $header = $this->response->getHeaderLine('Content-Type');

        return $header === '' ? null : $header;
    }
}