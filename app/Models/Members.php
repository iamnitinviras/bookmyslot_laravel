<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class Members extends Model
{
    use HasFactory, Sortable;

    protected $table = 'members';
    protected $fillable = [
        'branch_id',
        'gym_customer_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone_number',
        'address',
        'join_date',
        'date_of_birth',
        'package_start_date',
        'package_end_date',
        'is_active',
        'created_by',
        'package_id',
        'height',
        'weight',
        'city',
        'state',
        'country',
        'zip',
        'profile_image',
        'gender',
        'status',
        'primary_goal',
        'secondary_goal',
        'occupation',
        'last_login_at',
        'notes',
    ];
    public $sortable = [
        'id',
        'gym_customer_id',
        'name',
        'phone_number',
        'join_date'
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select('id','first_name','last_name');
    }
    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id')->select('id','name','price');
    }

    public function payments()
    {
        return $this->hasMany(MemberPayment::class, 'id', 'member_pk_id');
    }

    public function pending_payments()
    {
        return $this->hasMany(PendingPayments::class, 'id', 'member_pk_id');
    }
}
