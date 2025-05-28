<?php

namespace App\Repositories;

use App\Models\BlogCategory;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class FoodCategoryRepository.
 */
class BlogCategoryRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return BlogCategory::class;
    }

    public function getCategoriesQuery($params)
    {
        return $this->model;
    }

    public function getCategories($params)
    {

        $table = $this->model->getTable();
        return $this->getCategoriesQuery($params)->sortable(['id' => 'desc'])->when(isset($params['filter']), function ($q) use ($params, $table)
        {
            $q->where(function ($query) use ($params, $table)
            {
                $query->where("$table.category_name", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=', $params['filter']);
            });
        })->select(
                "$table.id",
                "$table.category_name",
                "$table.category_image",
                "$table.lang_category_name",
                "$table.sort_order",
                "$table.created_at",
                "$table.status",
            )->get();
    }
}
