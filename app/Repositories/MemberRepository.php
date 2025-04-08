<?php

namespace App\Repositories;

use App\Models\CustomerTrial;
use App\Models\MemberEnquiry;
use App\Models\Members;
use App\Models\MemberTrial;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class UserRepository.
 */
class MemberRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function getStaffQuery($params)
    {
        return $this->model->When(isset($params['user_id']), function ($q) use ($params) {
            $q->where('id', '!=', $params['user_id'])
                ->where('created_by',$params['created_by']);
        });
    }

    public function getRestaurantUser($params)
    {
        $user = $this->getStaffQuery($params)->where('id', $params['id'])->first();
        return $user;
    }

    public function getStaff($params)
    {
        $table = $this->model->getTable();
        $users = $this->getStaffQuery($params)->sortable()->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($q) use ($params, $table) {
                $q->where(DB::raw('CONCAT(' . $table . '.first_name, \' \', ' . $table . '.last_name)'), 'like', '%' . $params['filter'] . '%')
                    ->orWhere($table . '.email', 'like', '%' . $params['filter'] . '%')
                    ->orWhere($table . '.phone_number', 'like', $params['filter'] . '%')
                    ->orWhere($table . '.id', '=', $params['filter']);
            });
        })->where('user_type',2)
        ->select(
            "$table.first_name",
            "$table.last_name",
            "$table.email",
            "$table.phone_number",
            "$table.profile_image",
            "$table.id",
            "$table.created_at",
        );

        $users = $users->paginate($params['par_page']);
        return $users;
    }

    public function getStaffCount($params)
    {
        $table = $this->model->getTable();
        $users = $this->getStaffQuery($params)->count('id');
        return $users;
    }

    public function getStaffRecodes($params)
    {
        $table = $this->model->getTable();
        $users = $this->getStaffQuery($params)->orderBy('id', 'desc')->select(

            "$table.first_name",
            "$table.last_name",
            "$table.email",
            "$table.profile_image",
            "$table.phone_number",
            "$table.id",
            "$table.created_at",
        );
        if (isset($params['recodes'])) {
            $users = $users->limit($params['recodes']);
        }
        $users = $users->get();
        return $users;
    }

    //Member Trial Page
    public function getAllMember($params)
    {
        return Members::with('package')->sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($q) use ($params) {
            $q->where('branch_id',$params['branch_id']);
        })->sortable()->when(isset($params['filter']), function ($q) use ($params) {
            $q->where(function ($q) use ($params) {
                $q->where('email', 'like', '%' . $params['filter'] . '%')
                    ->orWhere('phone_number', 'like', $params['filter'] . '%')
                    ->orWhere('id', '=', $params['filter']);
            });
        })->paginate($params['par_page']);
    }

    public function getAllMemberEnquiry($params)
    {
        return MemberEnquiry::sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($q) use ($params) {
            $q->where('branch_id',$params['branch_id']);
        })->sortable()->when(isset($params['filter']), function ($q) use ($params) {
            $q->where(function ($q) use ($params) {
                $q->where('email', 'like', '%' . $params['filter'] . '%')
                    ->orWhere('phone_number', 'like', $params['filter'] . '%')
                    ->orWhere('id', '=', $params['filter']);
            });
        })->paginate($params['par_page']);
    }

    public function getAllTrialMember($params)
    {
        return MemberTrial::sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($q) use ($params) {
            $q->where('branch_id',$params['branch_id']);
        })->sortable()->when(isset($params['filter']), function ($q) use ($params) {
            $q->where(function ($q) use ($params) {
                $q->where('email', 'like', '%' . $params['filter'] . '%')
                    ->orWhere('phone_number', 'like', $params['filter'] . '%')
                    ->orWhere('id', '=', $params['filter']);
            });
        })->paginate($params['par_page']);
    }

    public function getAllActivePackage($branch){
        $packages= Package::when(isset($branch), function ($q) use ($branch) {
            $q->where('branch_id',$branch);
        })->where('status','active')->orderBy('price','asc')->get();

        if ($packages != null) {
            $food_categories = $packages->mapWithKeys(function ($package, $key) {
                return [$package->id => $package->local_lang_name." (".$package->number_of_months." ".trans('system.fields.month').")"];
            });
            return ['' => __('system.packages.select_package')] + $food_categories->toarray();
        }

        return ['' => __('system.packages.select_package')];
    }
}
