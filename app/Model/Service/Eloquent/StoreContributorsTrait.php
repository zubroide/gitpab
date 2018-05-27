<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

trait StoreContributorsTrait
{
    /**
     * @param Collection $list
     * @param array $contributorFields
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeContributors(Collection $list, array $contributorFields)
    {
        $contributors = new Collection();
        foreach ($list as $item) {
            foreach ($contributorFields as $fieldName) {
                if (!empty($item[$fieldName]['id'])) {
                    $contributors->put($item[$fieldName]['id'], $item[$fieldName]);
                }
            }
        }

        /** @var EloquentContributorService $contributorService */
        $contributorService = app(AppServiceProvider::ELOQUENT_CONTRIBUTOR_SERVICE);
        $contributorService->storeList($contributors);
    }
}