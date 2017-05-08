<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-8
 * Time: 上午11:20
 */

namespace App\Repositories;


use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderRepository extends RepositoryInterface
{

    /**
     * @param $status
     * @param int $limit
     * @return mixed
     */
    public function getTableDataByStatus($status, $limit = 25);

    /**
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    public function updateStatus($id, $status);

    public function updateDeliver($id, $userID);
}