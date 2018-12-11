<?php

namespace App\Model\Repository;

use App\Helper\Text;
use App\Model\Entity\Contributor;
use App\Model\Entity\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContributorRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contributor::class;
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = $this->model
            ->select($this->model->getTable() . '.*')
            ->addSelect(DB::raw("(
                    COALESCE((
                        SELECT sum(payment.hours) 
                        FROM payment
                        JOIN payment_status ON payment_status.id = payment.status_id
                        WHERE payment.contributor_id = contributor.id
                        AND payment_status.alias = '" . PaymentStatus::PAYED . "'
                    ), 0)
                    -
                    COALESCE((
                        SELECT sum(spent.hours) 
                        FROM spent
                        JOIN note ON note.id = spent.note_id
                        WHERE note.author_id = contributor.id
                    ), 0)
                ) as balance
            "))
        ;

        if ($id = Arr::get($parameters, 'id'))
        {
            $query->where('contributor.id', '=', $id);
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function update(array $attributes, $id)
    {
        $entity = parent::update($attributes, $id);

        $extra = [];
        foreach ($attributes as $name => $value) {
            if (substr($name, 0, 6) === 'extra_') {
                $extra[substr($name, 6)] = $value;
            }
        }

        if (!empty($extra)) {
            if ($entity->extra) {
                $entity->extra = $entity->extra->fill($extra);
                $entity->extra->save();
            }
            else {
                $parts = explode('\\', $this->model());
                $className = $parts[count($parts)-1];
                $pkFieldName = Text::camelCaseToUnderscore($className) . '_id';

                $modelExtraName = $this->model() . 'Extra';
                $entityExtra = new $modelExtraName();
                $entityExtra->fill($extra);
                $entityExtra->$pkFieldName = $entity->id;
                $entityExtra->created_by_id = Auth::id();
                $entityExtra->updated_by_id = Auth::id();

                $entity->extra = $entityExtra;
                $entity->extra->save();
            }
        }

        return $entity;
    }

}
