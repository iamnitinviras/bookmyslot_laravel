<?php

namespace App\Models;

use App\Models\User;
use App\Models\Feedback;
use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model implements Searchable
{
    use HasFactory, Sortable;

    protected $table = 'branches';
    protected $fillable = [
        'user_id',
        'branch_title',
        'branch_phone',
        'street_address',
        'city',
        'state',
        'country',
        'zip',
    ];

    protected $casts = [
        'branch_title' => "string",
        'branch_phone' => "string",
        'slug' => "string",
        'qr_details' => "json"
    ];

    public $sortable = ['id', 'title'];

    public function users()
    {
        $table = (new User())->getTable();
        return $this->belongsToMany(User::class, 'branch_users', 'branch_id', 'user_id')->select("$table.first_name", "$table.last_name", "$table.phone_number", "$table.email", "$table.profile_image", "$table.id", "$table.created_at");
    }

    public function created_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function packages()
    {
        $table = (new Package())->getTable();
        return $this->hasMany(Package::class, 'branch_id', 'id')->orderBy('id', 'ASC');
    }
    public function expenses_categories()
    {
        return $this->hasMany(ExpenseCategory::class, 'branch_id', 'id');
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'branch_id', 'id');
    }
    public function vendor_setting()
    {
        return $this->hasOne(VendorSetting::class, 'user_id', 'user_id');
    }

    public function getLogoNameAttribute()
    {
        return ucfirst(substr($this->title, 0, 1));
    }

    public function getLanguageStringAttribute()
    {
        return implode(', ', $this->language ?? []);
    }

    public function getLogoUrlAttribute()
    {
        return getFileUrl($this->attributes['logo']);
    }

    public function setLogoAttribute($value)
    {
        if ($value != null) {
            if (gettype($value) == 'string') {
                $this->attributes['logo'] = $value;
            } else {
                $this->attributes['logo'] = uploadFile($value, 'logo');
            }
        }
    }

    public function setQrDetailsAttribute($value)
    {
        if (gettype($value) != 'array') {
            $value = explode(',', $value);
        }

        $this->attributes['qr_details'] = json_encode($value);
    }

    public function getLanguageAttribute()
    {

        return array_filter((json_decode($this->attributes['language'], 1) ?? []));
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('admin.board.show', $this->id);
        $url .= "|" . route('admin.board.edit', $this->id);
        return new \Spatie\Searchable\SearchResult($this, $this->title, $url);
    }


    public function scopeAdmin($q, $params)
    {
        return $q->when(isset($params['admin_user_id']), function ($q) use ($params) {
            $q->whereHas('users', function ($q) use ($params) {
                $q->whereRaw('branch_users.branch_id in (select branch_id from branch_users where user_id = ' . $params['admin_user_id'] . ')');
            });
        });
    }

}
