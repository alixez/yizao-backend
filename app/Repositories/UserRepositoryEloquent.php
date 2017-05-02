<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午12:59
 */

namespace App\Repositories;


use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    public function createWithRoles($attributes = [], array $roles)
    {
        $user = $this->create($attributes);

        if ($user) {
            foreach ($roles as $roleId) {
                $user->roles()->attach($roleId);
            }
        }

        return $user;
    }

    public function updateWithRolesSync($attributes = [], array $roles, $id)
    {
        $user = $this->update($attributes, $id);
        $user->roles()->sync($roles);

        return $user;
    }
}