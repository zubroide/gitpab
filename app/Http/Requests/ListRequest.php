<?php

namespace App\Http\Requests;

class ListRequest extends FormRequest
{
    protected $orderFields = ['id', 'name'];
    protected $defaultOrder = 'id';
    protected $defaultOrderDirection = 'desc';
    protected $defaultLimit = 100;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit' => 'integer|max:100',
            'order' => 'in:' . join(',', $this->orderFields),
            'orderDirection' => 'in:asc,desc'];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * @return null
     */
    public function getOrder()
    {
        return $this->get('order', $this->defaultOrder);
    }

    /**
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->get('orderDirection', $this->defaultOrderDirection);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->get('limit', $this->defaultLimit);
    }
}
