<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MemberPayment extends Model
{
    use HasFactory, Sortable;

    protected $table = 'member_payments';
    protected $fillable = [
        'branch_id',
        'package_id',
        'amount_paid',
        'member_pk_id',
        'package_price',
        'payment_date',
        'bill_date',
        'activation_date',
        'payment_type',
        'due_amount',
        'payment_mode',
        'created_by',
        'discount'
    ];

    public function member()
    {
        return $this->hasOne(Members::class, 'id', 'member_pk_id')->select('id','name','phone_number','email','gym_customer_id','join_date','package_end_date');
    }
    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id')->select('id','name','lang_name','price','number_of_months');
    }
}
