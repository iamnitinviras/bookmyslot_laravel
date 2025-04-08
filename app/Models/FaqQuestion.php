<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;

class FaqQuestion extends Model
{
    use HasFactory, Sortable;

    public $table = 'faq_questions';
    public $primaryKey = 'id';
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
        'id',
        'question',
        'answer',
        'lang_question',
        'lang_answer'

    ];

    public $sortable = [
        'id',
        'question',
        'answer',
    ];

    protected $casts = [
        'lang_question' => "array",
        'lang_answer' => "array",
    ];

    public function getLocalQuestionAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->question;
        } else {
            return $this->lang_question[app()->getLocale()] ?? $this->question;
        }
    }

    public function getLocalAnswerAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->answer;
        } else {
            return $this->lang_answer[app()->getLocale()] ?? $this->answer;
        }
    }
}
