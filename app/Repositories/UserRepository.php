<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午12:58
 */

namespace App\Repositories;


use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{

    /**
     * @param array $attributes
     * @param array $roles
     * @return mixed
     */
    public function createWithRoles($attributes = [], array $roles);

    /**
     * @param array $attributes
     * @param array $roles
     * @param $id
     * @return mixed
     */
    public function updateWithRolesSync($attributes = [], array $roles, $id);

    /**
     * Locked or unlocked the user
     * @param $id
     * @param bool $locked
     * @return mixed
     */
    public function lockOrUnlockUser($id, $locked = true);

}