<?php

namespace App\Repositories;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class BranchRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Branch::class;
    }

    public function getGymBranchQuery($params)
    {
        $data = $this->model->with('users')->when(isset($params['user_id']), function ($query) use ($params) {
            $query->whereHas('users', function ($q) use ($params) {
                $q->where('user_id', $params['user_id']);
            });
        })->when(isset($params['assigned_branch']), function ($query) use ($params) {
            if (count($params['assigned_branch'])>0){
                $query->whereIn('id',$params['assigned_branch']);
            }
        })->admin($params);
        return $data;
    }

    public function getBranches($params)
    {
        $table = $this->model->getTable();

        return $this->getGymBranchQuery($params)->sortable(['id' => 'desc'])->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.title", 'like', '%' . $params['filter'] . '%');
            });
        })->select('*')->paginate($params['par_page']);
    }

    public function getBranchDetails($params)
    {
        $table = $this->model->getTable();
        $products = $this->getGymBranchQuery($params)->when(isset($params['except_branch_id']), function ($q) use ($params) {
            $q->where('id', '!=', $params['except_branch_id']);
        })->select('*');
        if (isset($params['latest'])) {
            $products = $products->orderBy('id', 'desc');
        }
        if (isset($params['recodes'])) {
            $products = $products->limit($params['recodes'])->get();
        } else {
            $products = $products->get();
        }
        return $products;
    }

    public function getCountBranch($params = [])
    {
        $table = $this->model->getTable();

        $products = $this->getGymBranchQuery($params)->when(isset($params['branch_id']), function ($query) use ($params) {
            $query->orderByRaw("FIELD(id," . $params['branch_id'] . " ) asc");
        });

        return $products->count('id');
    }

    public function getVendorsList($params = [])
    {
        $vendors=User::where('user_type',User::USER_TYPE_VENDOR)->select(DB::raw('CONCAT(first_name," ",last_name) AS full_name'),'id')->where('status',1)->orderBy('first_name','asc')->pluck('full_name','id');
        return $vendors->toArray();
    }
}
