<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobsApply extends Model
{
    protected $table = 'apply';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'job_id',
        'post_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'resume',
        'cover_letter',
        'linkedin_url',
        'session_id'
    ];
}
