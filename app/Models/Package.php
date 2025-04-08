<?php

namespace App\Models;

use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;

class Package extends Model implements Searchable
{
    use HasFactory, Sortable;

    public $table = 'packages';

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
        'name',
        'lang_name',
        'lang_description',
        'description',
        'status',
        'price',
        'number_of_months',
    ];

    protected $casts = [
        'branch_id' => "integer",
        'name' => "string",
        'lang_name' => "array",
        'lang_description' => "array",
    ];
    public $sortable = [
        'id',
        'name',
        'created_at',
        'price',
        'number_of_months',
    ];

    public function setLangNameAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_name'] = json_encode($value);
        }
    }
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


    public function getSearchResult(): SearchResult
    {
        $url = route('admin.packages.edit', $this->id);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
