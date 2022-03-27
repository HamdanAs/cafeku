<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseApiRequest;

class UpdateProductRequest extends BaseApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required|unique:products,name',
            'price' => 'required',
            'picture' => 'nullable',
            'stock' => 'nullable|numeric'
        ];
    }
}
