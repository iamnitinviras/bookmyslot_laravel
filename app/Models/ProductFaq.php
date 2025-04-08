<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class ProductFaq extends Model
{
    use HasFactory,Sortable;
    protected $fillable = [
        'branch_id',
        'title',
        'description',
        'lang_title',
        'lang_description',
        'status'
    ];

    protected $casts = [
        'branch_id' => "integer",
        'lang_title' => "array",
        'lang_description' => "array",
    ];
    public $sortable = [
        'id',
        'title',
        'created_at'
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
    public function getLocalLangTitleAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->title;
        } else {
            return $this->lang_title[app()->getLocale()] ?? $this->title;
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
}
