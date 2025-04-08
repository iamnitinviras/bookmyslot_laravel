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
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // Key type is string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    public function getLocalLangNameAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->name;
        } else {
            return $this->lang_name[app()->getLocale()] ?? $this->name;
        }
    }
}
