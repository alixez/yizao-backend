<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午12:57
 */

namespace App\Http\Controllers\User;


use App\Criteria\User\WithAddressCriteria;
use App\Criteria\User\WithRolesCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    private $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function getList(Request $req)
    {
        $limit = $req->get('limit', 25);

        $list = $this->repository->paginate($limit);

        return response()->json($list);
    }

    public function getAllDeliver(Request $req)
    {
        $list = $this->repository->whereHas('roles', function($query) {
            $query->where('name', 'deliver');
        })->all();

        return response()->json([
            'delivers' => $list,
        ]);
    }

    public function getAll(Request $req)
    {
        $allUsers = $this->repository->all();
        return response()->json([
            $allUsers
        ]);
    }

    /**
     * Get user profile
     * @param Request $req
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOne(Request $req, $id)
    {
        $this->repository->pushCriteria(WithRolesCriteria::class);
        $this->repository->pushCriteria(WithAddressCriteria::class);
        $userProfile = $this->repository->find($id);

        return response()->json([
            "msg" => "OK",
            "user" => $userProfile,
        ]);
    }

    public function getUserAddress($id)
    {
        $user = $this->repository->find($id);

        return response()->json($user->addresses);
    }

}