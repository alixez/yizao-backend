<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午4:52
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $repository = null;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }

    public function showAll(Request $req)
    {
        $this->authorizeBetter(['roles.show', 'user.update', 'access.manager']);

        $roles = $this->repository->all();
        return response()->json([
            'roles' => $roles
        ]);
    }

    public function getRolesWithPermission()
    {
        $this->authorizeBetter(['access.manager']);

        $roles = $this->repository
            ->with(['perms'])
            ->all();

        return response()->json([
            'roles' => $roles,
        ]);
    }

    /**
     * Sync the permission
     * @param Request $req
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncRolePerms(Request $req, $id) {

        $this->authorizeBetter(['access.update']);

        $perms = $req->get('perms');

        $roles = $this->repository->find($id);
        $roles->perms()->sync($perms);

        $resRoles = $roles->toArray();
        $resRoles['perms'] = $roles->perms;

        return response()->json([
            'roles' => $resRoles
        ]);
    }

    /**
     * Create new role
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function createRole(Request $req) {
        $this->authorizeBetter(['roles.create']);

        $role = $req->only(['name', 'display_name']);

        $createdRole = $this->repository->create($role);
        $createdRole->perms = [];
        return response()->json([
            'role' => $createdRole,
        ]);
    }
}