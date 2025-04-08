<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ExpenseCategory extends Model
{
    use HasFactory,Sortable;
    protected $table = 'expense_categories';
    protected $fillable = [
        'branch_id',
        'name',
        'lang_name',
        'description',
        'lang_description',
        'status',
    ];
    public function getLocalLangNameAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->name;
        } else {
            return $this->lang_name[app()->getLocale()] ?? $this->name;
        }
    }
}
