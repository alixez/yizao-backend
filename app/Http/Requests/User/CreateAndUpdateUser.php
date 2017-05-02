<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午3:49
 */

namespace App\Http\Requests\User;


use App\Foundations\RequestAuthRootTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateAndUpdateUser extends FormRequest
{
    use RequestAuthRootTrait;

    public function rules()
    {
        return [
            //
        ];
    }

    public function getBody()
    {
        $data = $this->only([
            'name',
            'email',
            'password',
        ]);

        return $data;
    }
}