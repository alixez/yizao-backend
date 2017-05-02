<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-6
 * Time: 下午6:32
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateAndUpdateUser;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;

class UpdateController extends Controller
{
    private $repository = null;
    private $addressRepo = null;

    public function __construct(UserRepository $userRepository, UserAddressRepository $userAddressRepository)
    {
        $this->repository = $userRepository;
        $this->addressRepo = $userAddressRepository;
    }

    /**
     * @param CreateAndUpdateUser $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function simpleUpdate(CreateAndUpdateUser $req)
    {
        $data = $req->getBody();
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $roles = array_values($req->get('roles', []));
        $user = $this->repository->updateWithRolesSync($data, $roles, $req->get('id'));

        foreach ($req->get('addresses') as $address) {
            $address['user_id'] = $user->id;
            $this->addressRepo->updateOrCreate($address);
        }

        return response()->json([
            'msg' => '修改成功',
            'user' => $user,
        ]);
    }
}