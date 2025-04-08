<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\FoodCategory;
use App\Models\Package;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class PackageRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Package::class;
    }

    public function getPackageQuery($params)
    {
        return $this->model->sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($query) use ($params) {
            $query->where('branch_id', $params['branch_id']);
        });
    }

    public function getAllPackages($params)
    {

        $table = $this->model->getTable();
        return $this->getPackageQuery($params)->orderBy("$table.id")->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.name", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->select(
            "$table.id",
            "$table.branch_id",
            "$table.price",
            "$table.number_of_months",
            "$table.name",
            "$table.lang_name",
            "$table.created_at",
            "$table.status",
        )->get();
    }
}
