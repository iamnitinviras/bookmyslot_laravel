<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class Gym extends Model
{
    use HasFactory, Sortable;

    protected $table = 'gyms';
    protected $fillable = [
        'user_id',
        'title',
        'email',
        'contact_person_name',
        'contact_person_phone',
        'phone',
        'website',
        'slug',
        'slug',
        'logo',
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
}
