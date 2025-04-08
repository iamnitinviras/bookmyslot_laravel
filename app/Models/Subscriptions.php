<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Subscriptions extends Model
{
    use HasFactory;

    public $table = 'subscriptions';
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
        'user_id',
        'plan_id',
        'payment_method',
        'payment_type',
        'start_date',
        'expiry_date',
        'is_current',
        'details',
        'remark',
        'amount',
        'type',
        'branch_limit',
        'status',
        'staff_limit',
        'branch_unlimited',
        'staff_unlimited',
        'transaction_id',
        'subscription_id',
        'json_response',
    ];

    public function scopehasFilter($query){
        if(!empty(request()->user_id)){
            $query->where('user_id',request()->user_id);
        }

        if(!empty(request()->plan_id)){
            $query->where('plan_id',request()->plan_id);
        }

        if(!empty(request()->from_date)){
            $query->whereDate('start_date',request()->from_date);
        }

        if(!empty(request()->to_date)){
            $query->whereDate('expiry_date',request()->to_date);
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function plan(){
        return $this->belongsTo(Plans::class,'plan_id','plan_id');
    }
}
