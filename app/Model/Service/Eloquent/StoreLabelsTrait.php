<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

trait StoreLabelsTrait
{
    /**
     * @param Collection $list
     * @param string $labelsAttr
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeLabels(Collection $list, string $labelsAttr)
    {
        $labels = new Collection();
        $labelsApiArr = [];
        foreach ($list as $item) {
            $labelsApiArr = array_merge($labelsApiArr, $item[$labelsAttr]);
            $labelsApiArr = array_unique($labelsApiArr);
        }

        /** @var EloquentLabelService $labelService */
        $labelService = app(AppServiceProvider::ELOQUENT_LABEL_SERVICE);
        $labelsDbArr = $labelService->getAllLabels();
        foreach ($labelsApiArr as $label)
        {
            if (!in_array($label, $labelsDbArr))
            {
                $labels->push([
                    'name' => $label,
                ]);
            }
        }
        $labelService->storeList($labels);
    }
}