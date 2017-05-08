<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-5-7
 * Time: 下午1:14
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }

    /**
     * Get all permissions
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPerms(Request $req)
    {
        $this->authorizeBetter(['permission.show', 'access.manager']);

        $allPerms = $this->repository->all();
        return response()->json([
            'perms' => $allPerms,
        ]);
    }
}