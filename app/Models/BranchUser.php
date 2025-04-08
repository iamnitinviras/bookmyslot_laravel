<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class BranchUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'user_id',
        'role',
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
    const ROLE_ADMIN = 1;
    const ROLE_VENDOR = 3;
    const ROLE_STAFF = 2;

    protected $casts = [
        'role' => "integer",
        'user_id' => "integer",
        'branch_id' => "integer",
    ];
}
