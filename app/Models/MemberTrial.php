<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MemberTrial extends Model
{
    use HasFactory, Sortable;

    protected $table = 'member_trials';
    protected $fillable = [
        'branch_id',
        'name',
        'phone_number',
        'trainer',
        'created_by',
        'duration_of_trial',
        'notes'
    ];
    public $sortable = [
        'id',
        'name',
        'phone_number',
        'trainer',
        'created_by',
        'duration_of_trial',
        'notes',
    ];
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select('id','first_name','last_name');
    }
}
