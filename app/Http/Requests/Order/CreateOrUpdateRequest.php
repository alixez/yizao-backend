<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function getBody()
    {
        return $this->only([
            'order_no',
            'order_address',
            'user_id',
            'order_status',
            'remark',
            'shipping_time',
            'shipping_money',
            'shipping_address',
            'shipping_person',
        ]);
    }


}
