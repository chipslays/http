<?php 

namespace Chipslays\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

class Request 
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $options = [];

    public function __construct($options = [])
    {
        $this->client = new Client;
        $this->options = $options;
    }

    public function request(string $method, string $url, array $options = []) 
    {
        return new Response($this->client->request($method, $url, array_merge($this->options, $options)));
    }

    public function get(string $url, array $query = [], array $headers = []) 
    {
        return new Response($this->client->request('GET', $url, array_merge($this->options, [
            'query' => $query, 
            'headers' => $headers,
        ])));
    }

    public function post(string $url, array $query = [], array $headers = []) 
    {
        return new Response($this->client->request('POST', $url, array_merge($this->options, [
            'query' => $query, 
            'headers' => $headers,
        ])));
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setOptions(array $options): Request
    {
        $this->options = $options;

        return $this;
    }

    public function addOptions(array $options): Request
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function clearOptions(): Request
    {
        $this->setOptions([]);

        return $this;
    }

    public function cookie(string $file): Request
    {
        $this->options['cookies'] = new FileCookieJar($file, true);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return Request
     */
    public function json(array $data): Request
    {
        $this->options['json'] = $data;

        return $this;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html#uploading-data
     * 
     * @param array $data
     * @return Request
     */
    public function body(array $data): Request
    {
        $this->options['body'] = $data;

        return $this;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html#sending-form-fields
     * 
     * @param array $data
     * @return Request
     */
    public function field(array $data): Request
    {
        $this->options['form_params'] = $data;

        return $this;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html#sending-form-files
     * 
     * @param array $data
     * @return Request
     */
    public function file(array $data): Request
    {
        $this->options['multipart'] = $data;

        return $this;
    }

    public function query(array $data): Request
    {
        $this->options['query'] = $data;

        return $this;
    }

    public function headers(array $data): Request
    {
        $this->options['headers'] = $data;

        return $this;
    }

    /**
     * @see authhttps://docs.guzzlephp.org/en/stable/request-options.html#auth
     *
     * @param array $data
     * @return Request
     */
    public function auth(array $data): Request
    {
        $this->options['auth'] = $data;

        return $this;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/request-options.html#proxy
     *
     * @param array $data
     * @return Request
     */
    public function proxy(array $data): Request
    {
        $this->options['proxy'] = $data;

        return $this;
    }
}