<?php

namespace App\Http\Requests;

class StorePaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'hours' => 'required|numeric',
            'user_id' => 'required|int',
            'status_id' => 'required|int',
            'payment_date' => 'required|date',
        ];
    }
}
