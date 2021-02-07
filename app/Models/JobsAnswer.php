<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobsAnswer extends Model
{

    protected $table = 'jobs_answer';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'answer',
        'label',

    ];

    //
}
