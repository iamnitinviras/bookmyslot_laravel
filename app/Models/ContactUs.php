<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;

class ContactUs extends Model
{
    use HasFactory, Sortable;

    public $table = 'contact_us';
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
        'name',
        'email',
        'message',
    ];

    public $sortable = [
        'id',
        'name',
        'email',
        'message',
    ];
}
