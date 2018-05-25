<?php

namespace App\Model\Service\Gitlab;

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
        $url = $this->getListUrl();
        foreach ($urlParameters as $key => $value) {
            $url = str_replace($key, $value, $url);
        }

        $requestParameters['private_token'] = $requestParameters['private_token'] ?? $this->token;
        $parts = [];
        foreach ($requestParameters as $key => $value) {
            $parts[] = $key . '=' . $value;
        }
        $url .= '?' . implode('&', $parts);

        $response = $this->client->get($url);
        $content = $response->getBody()->getContents();

        return collect(json_decode($content, true));
    }

    public function getItem(array $urlParameters = [], array $parameters = [])
    {

    }

}