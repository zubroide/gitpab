<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

trait StoreNamespacesTrait
{
    /**
     * @param Collection $list
     * @param array $contributorFields
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeNamespaces(Collection $list, array $contributorFields)
    {
        $contributors = new Collection();
        foreach ($list as $item) {
            foreach ($contributorFields as $fieldName) {
                if (!empty($item[$fieldName]['id'])) {
                    $contributors->put($item[$fieldName]['id'], $item[$fieldName]);
                }
            }
        }

        /** @var EloquentNamespacesService $contributorService */
        $contributorService = app(AppServiceProvider::ELOQUENT_NAMESPACES_SERVICE);
        $contributorService->storeList($contributors);
    }
}