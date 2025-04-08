<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;

class Testimonial extends Model
{
    use HasFactory, Sortable;

    public $table = 'testimonials';
    public $primaryKey = 'testimonial_id';

    protected $fillable = [
        'testimonial_id',
        'name',
        'company',
        'description',
        'testimonial_image',
    ];

    public $sortable = [
        'testimonial_id',
        'name',
        'company',
        'description',
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

    public function setTestimonialImageAttribute($value)
    {
        $this->attributes['testimonial_image'] = uploadFile($value, 'testimonial_image');
    }

    public function getTestimonialImageAttribute()
    {
        return getFileUrl($this->attributes['testimonial_image']);
    }
}
