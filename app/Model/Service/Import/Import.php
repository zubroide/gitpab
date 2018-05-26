<?php

namespace App\Model\Service\Import;

use App\Model\Service\Eloquent\EloquentServiceAbstract;
use App\Model\Service\Gitlab\GitlabServiceAbstract;
use Illuminate\Support\Collection;

class Import
{

    /**
     * @var GitlabServiceAbstract
     */
    protected $gitlabService;

    /**
     * @var EloquentServiceAbstract
     */
    protected $eloquentService;

    public function __construct(EloquentServiceAbstract $eloquentService, GitlabServiceAbstract $gitlabService)
    {
        $this->eloquentService = $eloquentService;
        $this->gitlabService = $gitlabService;
    }

    /**
     * @param array $urlParameters
     * @param array $requestParameters
     * @return Collection
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function import(array $urlParameters = [], array $requestParameters = []): Collection
    {
        $list = $this->gitlabService->getList($urlParameters, $requestParameters);
        $this->eloquentService->storeList($list);
        return $list;
    }
}
