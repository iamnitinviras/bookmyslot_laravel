<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class PendingPayments extends Model
{
    use HasFactory, Sortable;

    protected $table = 'pending_payments';
    protected $fillable = [
        'branch_id',
        'member_pk_id',
        'package_id',
        'due_amount',
        'status'
    ];

    public function member()
    {
        return $this->hasOne(Members::class, 'id', 'member_pk_id')->select('id','name','phone_number','email','gym_customer_id','join_date','package_end_date');
    }
    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id')->select('id','name','price','number_of_months');
    }
}
