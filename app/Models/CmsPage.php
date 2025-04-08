<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;

class CmsPage extends Model
{
    use HasFactory, Sortable;

    public $table = 'cms_pages';
    public $primaryKey = 'id';

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
        'id',
        'slug',
        'title',
        'description',
        'lang_title',
        'lang_description'

    ];

    public $sortable = [
        'id',
        'slug',
        'title',
        'description',
    ];

    protected $casts = [
        'lang_title' => "array",
        'lang_description' => "array",
    ];

    public function getLocalTitleAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->title;
        } else {
            return $this->lang_title[app()->getLocale()] ?? $this->title;
        }
    }

    public function getLocalDescriptionAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->description;
        } else {
            return $this->lang_description[app()->getLocale()] ?? $this->description;
        }
    }
}
