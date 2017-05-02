<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午12:56
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateAndUpdateUser;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CreateController extends Controller
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
    public function simpleCreate(CreateAndUpdateUser $req)
    {
        $data = $req->getBody();

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {

            $data['password'] = bcrypt('123456');
        }

        $user = $this->repository->createWithRoles($data, $req->get('roles'));

        foreach ($req->get('addresses') as $address) {
            $address['user_id'] = $user->id;
            $this->addressRepo->create($address);
        }

        return response()->json([
            'msg' => '创建成功',
            'user' => $user,
        ]);
    }

    /**
     * @param Request $req
     * @param integer $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAddress(Request $req, $userId)
    {
        $data = $req->only([
            'address_name',
            'address_phone',
            'address_details',
        ]);

        $data['user_id'] = $userId;

        $userAddress = $this->addressRepo->create($data);

        return response()->json([
            'msg' => 'ok',
            'address' => $userAddress,
        ]);

    }

}