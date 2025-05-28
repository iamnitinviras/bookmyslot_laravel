<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Blogs extends Model
{

    use HasFactory, Sortable;
    protected $guarded = [];
    const APPROVAL_STATUS = ['pending', 'approved', 'rejected'];

    protected $casts = [
        'slug' => "string",
        'lang_title' => "array",
        'lang_description' => "array",
    ];

    public $sortable = [
        'id',
        'title',
        'created_at',
        'status',
        'total_views',
    ];

    public function setImageAttribute($value)
    {
        if ($value != null) {
            if (gettype($value) == 'string') {
                $this->attributes['image'] = $value;
            } else {
                $this->attributes['image'] = uploadFile($value, 'blogs');
            }
        }
    }
    public function getImageUrlAttribute()
    {
        return getFileUrl($this->attributes['image']);
    }


    public function setLangTitleAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_title'] = json_encode($value);
        }
    }

    public function setLangDescriptionAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_description'] = json_encode($value);
        }
    }

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

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->select('id', 'first_name', 'last_name', 'email', 'profile_image');
    }
}
