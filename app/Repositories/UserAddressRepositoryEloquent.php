<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-7
 * Time: 下午3:10
 */

namespace App\Repositories;


use App\Models\User;
use App\Models\UserAddress;
use Prettus\Repository\Eloquent\BaseRepository;

class UserAddressRepositoryEloquent extends BaseRepository implements UserAddressRepository
{
    public function model()
    {
        return UserAddress::class;
    }

}