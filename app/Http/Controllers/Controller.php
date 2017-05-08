<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array|string|null $roles
     * @param array|string|null $permission
     * @param boolean $requireAll
     * @return bool
     */
    public function authorizeBetter($permission = null, $roles = null, $requireAll = false)
    {
        $user = \Auth::user();

        if (!$user) {
            abort(401, '您的会话已经过期');
        }

        //\Log::info($user->email . ' 请求授权 ' . \Request::route()->getActionName());

        $isRoot = $user->hasRole('root');

        $hasPermission = true;
        $hasRoles = true;

        if ($roles !== null) {
            $hasRoles = $user->hasRole($roles, $requireAll);
        }

        if ($permission !== null) {
            $hasPermission = $user->can($permission, $requireAll);
        }

        if (($hasRoles && $hasPermission) or $isRoot) {
            return true;
        } else {
            abort(403, '您没有此权限');
        }
    }
}
