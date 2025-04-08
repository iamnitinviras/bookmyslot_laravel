<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class ExpenseRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Expense::class;
    }

    public function getExpenseQuery($params)
    {
        return $this->model->with(['user','user'])->sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($query) use ($params) {
            $query->where('branch_id', $params['branch_id']);
        });
    }

    public function getAllExpenses($params)
    {
        $table = $this->model->getTable();
        return $this->getExpenseQuery($params)->orderBy("$table.id")->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.name", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->get();
    }

    public function getCategoryQuery($params)
    {
        return ExpenseCategory::sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($query) use ($params) {
            $query->where('branch_id', $params['branch_id']);
        });
    }
    public function getAllExpensCategories($params){
        $categories= $this->getCategoryQuery($params)->orderBy("id")->when(isset($params['filter']), function ($q) use ($params) {
            $q->where(function ($query) use ($params) {
                $query->where("name", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("id", '=',  $params['filter']);
            });
        })->get();
        return $categories;
    }
}
