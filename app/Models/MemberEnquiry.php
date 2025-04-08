<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Str;

class MemberEnquiry extends Model
{
    use HasFactory, Sortable;

    protected $table = 'member_enquiries';
    protected $fillable = [
        'branch_id',
        'name',
        'email',
        'gender',
        'next_follow_up_date',
        'phone',
        'location',
        'interest',
        'notes',
        'enquiry_source',
        'created_by',
    ];
    public $sortable = [
        'id',
        'branch_id',
        'name',
        'email',
        'gender',
        'next_follow_up_date',
        'phone',
        'location',
        'interest',
        'notes',
        'enquiry_source'
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select('id','first_name','last_name');
    }
}
