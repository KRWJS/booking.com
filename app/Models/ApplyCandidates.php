<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyCandidates extends Model
{

	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'candidate_id',
    ];




}
