<?php

namespace App\Models;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name', 'display_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
