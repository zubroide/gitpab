<?php

namespace App\Http\Requests;

class StorePaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'hours' => 'required|numeric',
            'contributor_id' => 'required|int|exists:contributor,id',
            'status_id' => 'required|int|exists:payment_status,id',
            'payment_date' => 'required|date',
        ];
    }
}
