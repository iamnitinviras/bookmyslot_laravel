<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class VendorSetting extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'analytics_code',
        'default_item_image',
        'default_category_image',
        'default_currency',
        'default_currency_symbol',
        'default_currency_position'
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('user_type', 3);
    }
}
