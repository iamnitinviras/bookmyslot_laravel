<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class Expense extends Model
{
    use HasFactory,Sortable;
    protected $table = 'expenses';
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
    protected $fillable = [
        'branch_id',
        'title',
        'category_id',
        'description',
        'amount',
        'expense_date',
        'payment_method',
        'created_by',
        'receipt_path',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select('id','first_name','last_name','email');
    }
    public function category()
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'category_id')->select('id','name','lang_name');
    }
}
