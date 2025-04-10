<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

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
    public function getLocalLangDescriptionAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->description;
        } else {
            return $this->lang_description[app()->getLocale()] ?? $this->description;
        }
    }

    protected $casts = [
        'lang_name' => "array",
        'lang_description' => "array",
    ];
}

