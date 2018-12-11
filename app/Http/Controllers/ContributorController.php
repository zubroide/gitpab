<?php

namespace App\Http\Controllers;

use App\Model\Entity\Contributor;
use App\Model\Service\Eloquent\EloquentContributorService;
use App\Providers\AppServiceProvider;

class ContributorController extends CrudController
{
    /**
     * @return EloquentContributorService
     */
    protected function getService()
    {
        return app(AppServiceProvider::ELOQUENT_CONTRIBUTOR_SERVICE);
    }

    public function rate(int $id)
    {
        /** @var Contributor $contributor */
        $contributor = $this->getService()->getObjectForEdit($id);
        return $this->jsonSuccess([
            'hour_rate' => $contributor->extra ? $contributor->extra->hour_rate : null,
        ]);
    }

}
