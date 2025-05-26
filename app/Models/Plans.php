<?php

namespace App\Models;

use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;

class Plans extends Model implements Searchable
{

    use HasFactory, Sortable;

    public $table = 'plans';
    public $primaryKey = 'plan_id';


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
        'plan_id',
        'title',
        'amount',
        'type',
        'branch_limit',
        'staff_limit',
        'member_limit',
        'status',
        'staff_unlimited',
        'unlimited_branch',
        'unlimited_member',
        'paypal_plan_id',
        'paypal_branch_id',
        'stripe_branch_id',
        'lang_plan_title',
        'user_id'
    ];

    public $sortable = [
        'plan_id',
        'title',
        'amount',
        'type'
    ];

    protected $casts = [
        'lang_plan_title' => "array",
    ];

    public function getLocalTitleAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->title;
        } else {
            return $this->lang_plan_title[app()->getLocale()] ?? $this->title;
        }
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('admin.plan.edit', $this->plan_id);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
