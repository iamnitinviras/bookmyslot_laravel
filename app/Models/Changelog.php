<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Changelog extends Model
{
    use HasFactory, Sortable;
    public $table = 'changelogs';

    protected $fillable = [
        'branch_id',
        'version',
        'title',
        'description',
        'lang_title',
        'lang_description',
        'status',
        'created_by',
        'updated_by',
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
