<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyAnswer extends Model
{

    protected $table = 'apply_answer';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apply_id',
        'question_id',
        'answer',
    ];




}
