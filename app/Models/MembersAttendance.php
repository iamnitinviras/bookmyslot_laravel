<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class MembersAttendance extends Model
{
    use HasFactory, Sortable;

    protected $table = 'members_attendances';
    protected $fillable = [
        'branch_id',
        'member_pk_id',
        'attendance_date',
        'check_in_time'
    ];
    public $sortable = [
        'id',
        'branch_id',
        'member_pk_id',
        'attendance_date',
        'check_in_time'
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
