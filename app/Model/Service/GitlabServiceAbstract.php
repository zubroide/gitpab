<?php

namespace App\Model\Service;

use App\Model\Repository\RepositoryAbstractEloquent;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Database\QueryException;
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

    /**
     * @var RepositoryAbstractEloquent
     */
    protected $repository;

    public function __construct(RepositoryAbstractEloquent $repository, ClientInterface $client, string $token)
    {
        $this->client = $client;
        $this->token = $token;
        $this->repository = $repository;
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
        $content = $response->getBody()->getContents();

        return collect(json_decode($content, true));
    }

    public function getItem(array $urlParameters = [], array $parameters = [])
    {

    }

    /**
     * @param Collection $list
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeList(Collection $list)
    {
        foreach ($list as $item) {
            $this->store((array)$item);
        }
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(array $attributes)
    {
        try {
            $result = $this->repository->create($attributes);
        }
        catch (QueryException  $e) {
            // Record exists
            if ($e->getCode() == 23505) {
                $result = $this->repository->update($attributes, $attributes['id']);
            }
            else {
                throw $e;
            }
        }
        return $result;
    }
}