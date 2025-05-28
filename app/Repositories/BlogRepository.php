<?php

namespace App\Repositories;

use App\Models\Blogs;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\News;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class FoodCategoryRepository.
 */
class BlogRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Blogs::class;
    }

    public function getNewsQuery($params)
    {
        return $this->model;
    }

    public function getBlogs($params)
    {

        $table = $this->model->getTable();
        $restaurants = $this->getNewsQuery($params)->with('category')->sortable(['id' => 'desc'])->when(isset($params['filter']), function ($q) use ($params, $table) {
            $q->where(function ($query) use ($params, $table) {
                $query->where("$table.title", 'like', '%' . $params['filter'] . '%');
                $query->orWhere("$table.id", '=',  $params['filter']);
            });
        })->select('*')->get();

        return $restaurants;
    }
}
