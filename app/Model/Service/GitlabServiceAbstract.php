<?php

namespace App\Model\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;

abstract class GitlabServiceAbstract
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    public function __construct(ClientInterface $client, string $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    abstract protected function getListUrl(): string;

    abstract protected function getItemUrl(): string;

    /**
     * @param string[] $urlParameters Key-value
     * @param string[] $requestParameters Key-value
     * @return Collection
     */
    public function getList(array $urlParameters = [], array $requestParameters = []): Collection
    {
        $urlParameters[':token'] = $urlParameters[':token'] ?? $this->token;
        $url = $this->getListUrl();
        foreach ($urlParameters as $key => $value) {
            $url = str_replace($key, $value, $url);
        }
        $response = $this->client->get($url);
        return collect(json_decode($response->getBody()->getContents()));
    }

    public function getItem(array $urlParameters = [], array $parameters = [])
    {

    }
}