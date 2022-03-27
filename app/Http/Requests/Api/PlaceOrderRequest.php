<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseApiRequest;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceOrderRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'table'     => 'required|integer|between:1,20',
            'status'    => ['nullable', Rule::in([Order::EATING, Order::DONE])],
            'total'     => ['required', 'integer'],
            'payment'   => Rule::requiredIf(request('status') === Order::DONE)
        ];
    }
}
