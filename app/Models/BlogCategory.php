<?php

namespace App\Models;

use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model implements Searchable
{
    use HasFactory, Sortable;
    public $table = 'blog_categories';
    protected $fillable = [
        'category_name',
        'category_icon',
        'category_image',
        'lang_category_name',
        'lang_description',
        'sort_order',
        'description',
        'slug',
        'status',
    ];

    protected $casts = [
        'sort_order' => "integer",
        'slug' => "string",
        'category_icon' => "string",
        'category_name' => "string",
        'category_image' => "string",
        'lang_category_name' => "array",
        'lang_description' => "array",
    ];
    public $sortable = [
        'id',
        'category_name',
        'created_at',
        'status',
        'sort_order',
    ];

    public function getCategoryImageNameAttribute()
    {
        return ucfirst(substr($this->category_name, 0, 1));
    }

    public function getCategoryImageUrlAttribute()
    {
        return getFileUrl($this->attributes['category_image']);
    }

    public function setCategoryImageAttribute($value)
    {
        if ($value != null) {
            if (gettype($value) == 'string') {
                $this->attributes['category_image'] = $value;
            } else {
                $this->attributes['category_image'] = uploadFile($value, 'category_image');
            }
        }
    }
    public function setLangCategoryNameAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_category_name'] = json_encode($value);
        }
    }

    public function getLangNameAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->category_name;
        } else {
            return $this->lang_category_name[app()->getLocale()] ?? $this->category_name;
        }
    }
    public function getLangDescriptionAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->description;
        } else {
            return $this->lang_description[app()->getLocale()] ?? $this->description;
        }
    }
    public function getNameAttribute()
    {
        return $this->category_name;
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('admin.categories.edit',  $this->id);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }
    public function blogs(){
        return $this->hasMany(Blogs::class,'category_id','id');
    }
}
