<?php

namespace App\Repositories;

use App\Models\Changelog;
use App\Models\Feedback;
use App\Models\Items;
use App\Models\TicketPriority;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;



/**
 * Class itemRepository.
 */
class ProrityRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return TicketPriority::class;
    }

    public function table()
    {
        return $this->model->getTable();
    }

    public function getItemsQuery($params)
    {
        $table = $this->table();

        return $this->model->sortable(['id' => 'desc'])->when(isset($params['branch_id']), function ($query) use ($params, $table) {
            $query->where("$table.branch_id", $params['branch_id']);
        })->select('*');
    }

    public function getPrority($params)
    {
        DB::enableQueryLog();
        $items = $this->getItemsQuery($params)->paginate($params['par_page']);;
        return $items;
    }

    public function getBusinessItems($params)
    {
        return $this->getItemsQuery($params)->where('id', $params['id'])->first();
    }
}
