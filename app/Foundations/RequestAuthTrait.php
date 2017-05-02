<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午2:49
 */

namespace App\Foundations;


trait RequestAuthTrait
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->hasRole(['root', 'admin'])) {
            return true;
        }
        return false;
    }
}