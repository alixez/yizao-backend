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
        $roles = $this->repository->all();
        if ($req->user() && $req->user()->hasRole('root')) {
            return response()->json([
                'roles' => $roles
            ]);
        }

        return response()->json([]);
    }
}