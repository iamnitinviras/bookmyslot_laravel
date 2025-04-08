<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function getOwnersQuery($params)
    {
        return $this->model->where('user_type', User::USER_TYPE_VENDOR);
    }

    public function getVendorStaffQuery($params)
    {
        return $this->model->where('user_type', User::USER_TYPE_STAFF);
    }


    public function getMyStaff($params)
    {
        return $this->model->where('created_by', $params['id'])->count();
    }

    public function getRestaurantUser($params)
    {
        $user = $this->getOwnersQuery($params)->where('id', $params['id'])->first();
        return $user;
    }

    public function getOwners($params)
    {
        $table = $this->model->getTable();
        $users = $this->getOwnersQuery($params)->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($q) use ($params, $table) {
                $q->where(DB::raw('CONCAT(' . $table . '.first_name, \' \', ' . $table . '.last_name)'), 'like', '%' . $params['filter'] . '%')->orWhere($table . '.email', 'like', '%' . $params['filter'] . '%')->orWhere($table . '.phone_number', 'like', $params['filter'] . '%')->orWhere($table . '.id', '=', $params['filter']);
            });
        })->select("$table.first_name", "$table.last_name", "$table.email", "$table.phone_number", "$table.profile_image", "$table.id", "$table.created_at", "$table.email_verified_at", "$table.free_forever",);

        $users = $users->paginate($params['par_page']);
        return $users;
    }

    public function getOwnersCount($params)
    {
        $table = $this->model->getTable();
        $users = $this->getOwnersQuery($params)->count('id');
        return $users;
    }

    public function getOwnersRecodes($params)
    {
        $table = $this->model->getTable();
        $users = $this->getOwnersQuery($params)->orderBy('id', 'desc')->select(

            "$table.first_name", "$table.last_name", "$table.email", "$table.profile_image", "$table.phone_number", "$table.id", "$table.created_at", "$table.free_forever",);
        if (isset($params['recodes'])) {
            $users = $users->limit($params['recodes']);
        }
        $users = $users->get();
        return $users;
    }

    public function getVendorStaff($params)
    {
        $table = $this->model->getTable();
        $users = $this->getVendorStaffQuery($params)->orderBy('id', 'desc')->select("$table.first_name", "$table.last_name", "$table.email", "$table.profile_image", "$table.phone_number", "$table.id", "$table.created_at", "$table.free_forever",);
        if (isset($params['recodes'])) {
            $users = $users->limit($params['recodes']);
        }
        $users = $users->get();
        return $users;
    }
}
