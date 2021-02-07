<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobsQuestion extends Model
{

    protected $table = 'jobs_question';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'post_id',
        'type',
        'question',
        'name',
        'is_required',
    ];


    public function answers() {
        return $this->hasMany('App\Models\JobsAnswer','question_id');
    }




}
