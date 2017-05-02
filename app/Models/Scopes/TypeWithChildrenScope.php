<?php

/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午11:32
 */

namespace App\Models\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class TypeWithChildrenScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->with(['children']);
    }
}